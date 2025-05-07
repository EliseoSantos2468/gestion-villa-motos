<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recibo;
use App\Models\Cliente;
use App\Models\Marca;
use App\Models\Producto;
use GuzzleHttp\Client;
use Barryvdh\DomPDF\Facade\Pdf;

class ReciboController extends Controller
{
    public function index()
    {
        $recibos = Recibo::with('cliente', 'productos')->get();
    
        if ($recibos->isEmpty()) {
            return view('gestion.ventas', compact('recibos'));      
        }
        
        return view('gestion.ventas', compact('recibos'));
    }

    public function generarPDF($id)
        {
            $recibo = Recibo::with(['cliente', 'productos'])->findOrFail($id);

            $pdf = Pdf::loadView('pdf.recibo', compact('recibo'));

            return $pdf->download('recibo_' . $recibo->id . '.pdf');
        }
            public function indexVenta()
            {
        $marcas = Marca::all();
        $productos = Producto::with([
            'marcas' => function ($query) {
                $query->select('marca.id', 'nombre_marca', 'precio_cliente', 'precio_mayoreo', 'venta_producto', 'cantidad')
                      ->withPivot('cantidad');
            },
            'clientes' => function ($query) {
                $query->select('cliente.id', 'nombres_cliente','apellidos_cliente')
                      ->withPivot('cantidad');
            }
        ])->get();
        $clientes = Cliente::all();
        $recibos = Recibo::with([
            'productos' => function ($query) {
                $query->select('producto.id', 'nombre_producto');
            },
            'cliente' => function ($query) {
                $query->select('cliente.id', 'nombres_cliente', 'apellidos_cliente');
            }
        ])->get();
    
        if ($recibos->isEmpty()) {
            return view('gestion.venta_nueva', compact('recibos','marcas','productos','clientes'));
        }
    
        return view('gestion.venta_nueva', compact('recibos','marcas','productos','clientes'));
    }
    public function indexEscritorio(){
        $recibos = Recibo::with([
            'productos' => function ($query) {
                $query->select('producto.id', 'nombre_producto');
            },
            'cliente' => function ($query) {
                $query->select('cliente.id', 'nombres_cliente', 'apellidos_cliente');
            }
        ])->get();

        return view('gestion.escritorio', compact('recibos'));
    }

    public function show($id){
        $recibo = Recibo::findOrFail($id);

        return response()->json($recibo, 200);
    }

    public function store(Request $request){

        $request->validate([
            'id_cliente' => 'required|exists:cliente,id',
            'total' => 'required|numeric',
            'productos' => 'required|array',
            'productos.*.id_producto' => 'required|exists:producto,id',
            'productos.*.id_marca' => 'required|exists:marca,id',
            'productos.*.cantidad' => 'required|integer|min:1',
        ]);
        

        foreach($request->productos as $producto){
            $DBproducto = Producto::with('marcas')->findOrFail($producto['id_producto']);

            if(!$DBproducto){
                return response()->json('producto no encontrado',200);
            }

            // recolectando la marca seleccionada
            $marca = $DBproducto->marcas->firstWhere('id', $producto['id_marca']);

            //validando que exista la marca
            if(!$marca){
                return response()->json('la marca no existe en este producto');
            }

            $cantidadDisponible = $marca->pivot->cantidad;

            // validando que la cantidad seleccionada no exceda la cantidad actual de el producto
            if($producto['cantidad'] > $cantidadDisponible){
                return back()->with('error', 'la cantidad solicitada excede la cantidad del producto');
            }
        }
        
        $recibo = Recibo::create([
            'fecha' => now()->toDateString(),
            'total' => $request->total,
            'id_cliente' => $request->id_cliente,
        ]);
        
        $productosConCantidad = [];
        $total=0;
        foreach ($request->productos as $producto) {
            $DBproducto = Producto::with('marcas')->findOrFail($producto['id_producto']);
        
            $productosConCantidad[$producto['id_producto']] = ['cantidad' => $producto['cantidad']];
        
            $marca = $DBproducto->marcas->firstWhere('id', $producto['id_marca']);
        
            $cantidad = $producto['cantidad'];
            
            // Precio según cantidad (mayoreo o normal)
            $precio = $cantidad >= 10 ? $marca->pivot->precio_mayoreo : $marca->pivot->precio_cliente;
        
            // Sumar al total
            $total += $precio * $cantidad;
        
            // Actualizar cantidad disponible
            $marca->pivot->cantidad -= $cantidad;
            $marca->pivot->save(); 
        }
        
        $recibo->update([
            'total' => $total
        ]);

        $recibo->productos()->attach($productosConCantidad);

        $cliente = Cliente::findOrFail($recibo->id_cliente);

        $cliente->productos()->attach($productosConCantidad);

        return redirect()->route('mostrarRecibos');
    }

    public function update(Request $request, $id){
        $request->validate([
            'fecha' => 'required|date',
            'total' => 'required|numeric', 
            'id_cliente' => 'required|exists:cliente,id', 
            'productos' => 'required|array',
            'produtos.*.id_producto' => 'required|exists:producto,id',
            'produtos.*.id_marca' => 'required|exists:marca,id',
            'produtos.*.cantidad' => 'required|integer|min:1',
        ]);

        $recibo = Recibo::findOrFail($id);

        $recibo->update([
            'fecha' => $request->fecha,
            'total' => $request->total,
            'id_cliente' => $request->id_cliente,
        ]);

        $productosConCantidad = [];
        foreach ($request->productos as $producto) {
            $productosConCantidad[$producto['id_producto']] = ['cantidad' => $producto['cantidad']];
        }
    
        $recibo->productos()->sync($productosConCantidad);

        return response()->json($recibo, 200);
    }

    public function destroy($id){
        $recibo = Recibo::findOrFail($id);

        $recibo->productos()->detach();

        $recibo->delete();

        return response()->json('eliminado con exito', 200);
    }
}

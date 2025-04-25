<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recibo;
use App\Models\Cliente;
use App\Models\Producto;

class ReciboController extends Controller
{
    public function index(){
        $recibos = Recibo::with(['productos' => function ($query) {
            $query->select('producto.id', 'nombre_producto');
        }])->get();

        if($recibos->isEmpty()){
            $data = [
                'message' => 'no hay registros de recibo'

            ];
            return response()->json($data, 200);
        }

        return response()->json($recibos, 200);
    }

    public function show($id){
        $recibo = Recibo::findOrFail($id);

        return response()->json($recibo, 200);
    }

    public function store(Request $request){
        $request->validate([
            'fecha' => 'required|date',
            'id_cliente' => 'required|exists:cliente,id',
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
                return response()->json('la cantidad a comprar excede la cantidad de el producto', 200);
            }
        }
        
        $recibo = Recibo::create([
            'fecha' => $request->fecha,
            'total' => 0,
            'id_cliente' => $request->id_cliente,
        ]);
        
        $productosConCantidad = [];
        $total=0;
        foreach ($request->productos as $producto) {
            $DBproducto = Producto::with('marcas')->findOrFail($producto['id_producto']);

            $productosConCantidad[$producto['id_producto']] = ['cantidad' => $producto['cantidad']];

            $marca = $DBproducto->marcas->firstWhere('id', $producto['id_marca']);

            $total += $marca->pivot->precio_cliente * $producto['cantidad'];

            $marca->pivot->cantidad -= $producto['cantidad'];
            $marca->pivot->save(); 
        }
        
        $recibo->update([
            'total' => $total
        ]);

        $recibo->productos()->attach($productosConCantidad);

        $cliente = Cliente::findOrFail($recibo->id_cliente);

        $cliente->productos()->attach($productosConCantidad);

        return response()->json($recibo, 200);
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

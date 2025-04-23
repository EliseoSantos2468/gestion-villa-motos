<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class ProductoController extends Controller
{
    public function index(){
        $productos = Producto::with(['marcas' => function ($query) {
            $query->select('marca.id', 'nombre_marca')->withPivot('cantidad');
        }])->get();

        if($productos->isEmpty()){
            $data=[
                'message' => 'no hay ningun registro de producto',
            ];

            return response()->json($data, 200);
        }

        return response()->json($productos, 200);
    }

    public function show($id){
        $producto = Producto::findOrFail($id);

        return response()->json($producto, 200);
    }

    public function store(Request $request){
        $request->validate([
            'nombre_producto' => 'required|string|max:355',
            'precio_cliente' => 'required|numeric',
            'precio_mayoreo' => 'required|numeric',
            'descripcion_producto' => 'required|string|max:355',
            'venta_producto' => 'required|integer',
            'marcas' => 'required|array',
            'marcas.*.id' => 'required|exists:marca,id',
            'marcas.*.cantidad' => 'required|integer|min:1',
        ]);

        $producto = Producto::create([
            'nombre_producto' => $request->nombre_producto,
            'precio_cliente' => $request->precio_cliente,
            'precio_mayoreo' => $request->precio_mayoreo,
            'descripcion_producto' => $request->descripcion_producto,
            'venta_producto' => $request->venta_producto,
        ]);

        $this->asignarMarcas($request, $producto->id);

        return response()->json('se creo con exito', 200);
    }

    public function asignarMarcas(Request $request, $producto_id){
        
        $producto = Producto::findOrFail($producto_id);

        $datosParaSync = [];

        foreach($request->marcas as $marca){
            $datosParaSync[$marca['id']] = ['cantidad' => $marca['cantidad']];
        }

        $producto->marcas()->syncWithoutDetaching($datosParaSync);

        return response()->json("marcas asignadas correctamente");
    }

    public function update(Request $request, $id){
        $request->validate([
            'nombre_producto' => 'required|string|max:355',
            'precio_cliente' => 'required|numeric',
            'precio_mayoreo' => 'required|numeric',
            'descripcion_producto' => 'required|string|max:355',
            'venta_producto' => 'required|integer',
            'marcas' => 'required|array',
            'marcas.*.id' => 'required|exists:marca,id',
            'marcas.*.cantidad' => 'required|integer|min:1',
        ]);

        $producto = Producto::findOrFail($id);

        $producto->update([
            'nombre_producto' => $request->nombre_producto,
            'precio_cliente' => $request->precio_cliente,
            'precio_mayoreo' => $request->precio_mayoreo,
            'descripcion_producto' => $request->descripcion_producto,
            'venta_producto' => $request->venta_producto,
        ]);

        $marcasNuevas = [];

        foreach ($request->marcas as $marca) {
            $marcasNuevas[$marca['id']] = ['cantidad' => $marca['cantidad']];
    
            if ($producto->marcas()->where('marca_id', $marca['id'])->exists()) {
                $producto->marcas()->updateExistingPivot($marca['id'], ['cantidad' => $marca['cantidad']]);
            } else {
                $producto->marcas()->attach($marca['id'], ['cantidad' => $marca['cantidad']]);
            }
        }

        $marcasActuales = $producto->marcas->pluck('id')->toArray();

        $marcasEnviadas = array_column($request->marcas, 'id');
        $marcasParaEliminar = array_diff($marcasActuales, $marcasEnviadas);

        if (!empty($marcasParaEliminar)) {
            $producto->marcas()->detach($marcasParaEliminar);
        }

        return response()->json($producto, 200);
    }

    public function destroy($id){
        $producto = Producto::findOrFail($id);

        $producto->marcas()->detach();

        $producto->delete();

        return response()->json('eliminado con exito', 200);
    }
}

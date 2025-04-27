<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Producto;
use App\Http\Controllers\Controller;

class ProductoApiController extends Controller
{
    public function index(){
        $productos = Producto::with([
            'marcas' => function ($query) {
                $query->select('marca.id', 'nombre_marca')
                      ->withPivot('cantidad');
            },
            'clientes' => function ($query) {
                $query->select('cliente.id', 'nombres_cliente','apellidos_cliente')
                      ->withPivot('cantidad');
            }
        ])->get();

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
            'descripcion_producto' => 'required|string|max:355',
            'marcas' => 'required|array',
            'marcas.*.id' => 'required|exists:marca,id',
            'marcas.*.cantidad' => 'required|integer|min:1',
            'marcas.*.precio_cliente' => 'required|numeric',
            'marcas.*.precio_mayoreo' => 'required|numeric',
            'marcas.*.venta_producto' => 'required|integer',
        ]);

        $producto = Producto::create([
            'nombre_producto' => $request->nombre_producto,
            'descripcion_producto' => $request->descripcion_producto,
        ]);

        $this->asignarMarcas($request, $producto->id);

        return response()->json('se creo con exito', 200);
    }

    public function asignarMarcas(Request $request, $producto_id){
        
        $producto = Producto::findOrFail($producto_id);

        $datosParaSync = [];

        foreach($request->marcas as $marca){
            $datosParaSync[$marca['id']] = [
                'cantidad' => $marca['cantidad'],
                'precio_cliente' => $marca['precio_cliente'],
                'precio_mayoreo' => $marca['precio_mayoreo'],
                'venta_producto' => $marca['venta_producto'],
            ];
        }

        $producto->marcas()->syncWithoutDetaching($datosParaSync);

        return response()->json("marcas asignadas correctamente");
    }

    public function update(Request $request, $id){
        $request->validate([
            'nombre_producto' => 'required|string|max:355',
            'descripcion_producto' => 'required|string|max:355',
            'marcas' => 'required|array',
            'marcas.*.id' => 'required|exists:marca,id',
            'marcas.*.cantidad' => 'required|integer|min:1',
            'marcas.*.precio_cliente' => 'required|numeric',
            'marcas.*.precio_mayoreo' => 'required|numeric',
            'marcas.*.venta_producto' => 'required|integer',
        ]);

        $producto = Producto::findOrFail($id);

        $producto->update([
            'nombre_producto' => $request->nombre_producto,
            'descripcion_producto' => $request->descripcion_producto,
        ]);

        $marcasNuevas = [];

        foreach ($request->marcas as $marca) {
            $marcasNuevas[$marca['id']] = [
                'cantidad' => $marca['cantidad'],
                'precio_cliente' => $marca['precio_cliente'],
                'precio_mayoreo' => $marca['precio_mayoreo'],
                'venta_producto' => $marca['venta_producto'],
            ];
    
            if ($producto->marcas()->where('marca_id', $marca['id'])->exists()) {
                $producto->marcas()->updateExistingPivot($marca['id'], [
                                                                        'cantidad' => $marca['cantidad'],
                                                                        'precio_cliente' => $marca['precio_cliente'],
                                                                        'precio_mayoreo' => $marca['precio_mayoreo'],
                                                                        'venta_producto' => $marca['venta_producto'],
                                                                    ]);
            } else {
                $producto->marcas()->attach($marca['id'], [
                                                            'cantidad' => $marca['cantidad'],
                                                            'precio_cliente' => $marca['precio_cliente'],
                                                            'venta_producto' => $marca['venta_producto'],
                                                        ]);
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

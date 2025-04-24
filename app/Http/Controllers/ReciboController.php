<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recibo;

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
            'total' => 'required|numeric', 
            'id_cliente' => 'required|exists:cliente,id',
            'productos' => 'required|array',
            'produtos.*.id_producto' => 'required|exists:producto,id',
            'produtos.*.cantidad' => 'required|integer|min:1',
        ]);

        
        $recibo = Recibo::create([
            'fecha' => $request->fecha,
            'total' => $request->total,
            'id_cliente' => $request->id_cliente,
        ]);
        
        $productosConCantidad = [];
        foreach ($request->productos as $producto) {
            $productosConCantidad[$producto['id_producto']] = ['cantidad' => $producto['cantidad']];
        }
    
        $recibo->productos()->attach($productosConCantidad);

        return response()->json($recibo, 200);
    }

    public function update(Request $request, $id){
        $request->validate([
            'fecha' => 'required|date',
            'total' => 'required|numeric', 
            'id_cliente' => 'required|exists:cliente,id', 
            'productos' => 'required|array',
            'produtos.*.id_producto' => 'required|exists:producto,id',
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

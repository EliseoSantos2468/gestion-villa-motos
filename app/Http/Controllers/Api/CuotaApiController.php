<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Cuota;
use App\Http\Controllers\Controller;

class CuotaApiController extends Controller
{
    public function index(){
        $cuotas = Cuota::all();  
        if($cuotas->isEmpty()){
            $data = [
                'message' => 'no hay registros en la tabla',
                'error' => 404,
            ];
            return response()->json($data, 404);
        }
        return response()->json($cuotas, 200);
    }
    public function show($id){
        $cuota = Cuota::findOrFail($id);
        return response()->json($cuota, 200);
    }
    public function store(Request $request){  
        $request->validate([
            'numero_cuotas' => 'required|integer',
            'valor_cuota' => 'required|numeric',
        ]);
        $cuota = Cuota::create([
            'numero_cuotas' =>$request->numero_cuotas,
            'valor_cuota' =>$request->valor_cuota,
        ]);
        return response()->json($cuota, 200);
    }
    public function update(Request $request, $id){
        $request->validate([
            'numero_cuotas' => 'required|integer',
            'valor_cuota' => 'required|numeric',
        ]);
        $cuota = Cuota::findOrFail($id);
        $cuota->update([
            'numero_cuotas' =>$request->numero_cuotas,
            'valor_cuota' =>$request->valor_cuota,
        ]);
        return response()->json($cuota, 200);
    }
    public function destroy($id){
        $cuota = Cuota::findOrFail($id);
        $cuota->delete();
        return response()->json(['message' => 'Cuota eliminada con éxito'], 200);
    }
}

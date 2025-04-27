<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\fechas;
use App\Http\Controllers\Controller;

class FechasApiController extends Controller
{
    public function index(){
        $fechas = Fechas::all();  
        if($fechas->isEmpty()){
            $data = [
                'message' => 'no hay registros en la tabla',
                'error' => 404,
            ];
            return response()->json($data, 404);
        }
        return response()->json($fechas, 200);
    }

    public function show($id){
        $fechas = Fechas::findOrFail($id);
        return response()->json($fechas, 200);
    }

    public function store(Request $request){  
        $request->validate([
            'fecha_inicio' => 'required|date|before_or_equal:fecha_fin',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'fecha_limite' => 'required|date|after_or_equal:fecha_fin',
        ]);
        
        $fechas = fechas::create([
            'fecha_inicio' =>$request->fecha_inicio,
            'fecha_fin' =>$request->fecha_fin,
            'fecha_limite' =>$request->fecha_limite,
        ]);

        return response()->json($fechas, 200);
    }

    public function update(Request $request, $id){
        $request->validate([
            'fecha_inicio' => 'required|date|before_or_equal:fecha_fin',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio',
            'fecha_limite' => 'required|date',
        ]);
        
        $fechas = Fechas::findOrFail($id);

        $fechas->update([
            'fecha_inicio' =>$request->fecha_inicio,
            'fecha_fin' =>$request->fecha_fin,
            'fecha_limite' =>$request->fecha_limite,
        ]);
        return response()->json($fechas, 200);
    }
    public function destroy($id){
        $fechas = Fechas::findOrFail($id);
        $fechas->delete();
        return response()->json(['message' => 'fechas eliminadas con éxito'], 200);
    }
}

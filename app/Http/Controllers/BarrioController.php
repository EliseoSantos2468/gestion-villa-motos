<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barrio;
use App\Models\Municipio;

class BarrioController extends Controller
{
    public function index(){
        $barrio = Barrio::all();

        if($barrio->isEmpty()){
            $data=[
                'message' => 'no hay ningun registro de barrio',
            ];

            return response()->json($data, 200);
        }

        return response()->json($barrio, 200);
    }

    public function show($id){
        $barrio = Barrio::findOrFail($id);

        return response()->json($barrio, 200);
    }

    public function store(Request $request){
        $request->validate([
            'nombre_barrio' => 'required|string|max:355',
            'municipio_id' => 'required|exists:municipio,id',
        ]);

        $barrio = Barrio::create([
            'nombre_barrio' => $request->nombre_barrio,
            'municipio_id' => $request->municipio_id,
        ]);

        return response()->json('se creo con exito', 200);
    }

    public function update(Request $request, $id){
        $request->validate([
            'nombre_barrio' => 'required|string|max:255',
            'municipio_id' => 'required|exists:municipio,id',
        ]);

        $barrio = Barrio::findOrFail($id);

        $barrio->update([
            'nombre_barrio' => $request->nombre_barrio,
            'municipio_id' => $request->municipio_id,
        ]);

        return response()->json($barrio, 200);
    }

    public function destroy($id){
        $barrio = Barrio::findOrFail($id);

        $barrio->delete();

        return response()->json('eliminado con exito', 200);
    }
}

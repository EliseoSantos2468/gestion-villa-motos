<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Municipio;
use App\Models\Departamento;


class MunicipioController extends Controller
{
    public function index(){
        $municipio = Municipio::all();

        if($municipio->isEmpty()){
            $data=[
                'message' => 'no hay ningun registro de municipio',
            ];

            return response()->json($data, 200);
        }

        return response()->json($municipio, 200);
    }

    public function show($id){
        $municipio = Municipio::findOrFail($id);

        return response()->json($municipio, 200);
    }

    public function store(Request $request){
        $request->validate([
            'nombre_municipio' => 'required|string|max:355',
            'departamento_id' => 'required|exists:departamento,id'
        ]);

        $municipio = Municipio::create([
            'nombre_municipio' => $request->nombre_municipio,
            'departamento_id' => $request->departamento_id,
        ]);

        return response()->json('se creo con exito', 200);
    }

    public function update(Request $request, $id){
        $request->validate([
            'nombre_municipio' => 'required|string|max:255',
            'departamento_id' => 'required|exists:departamento,id'
        ]);

        $municipio = Municipio::findOrFail($id);

        $municipio->update([
            'nombre_municipio' => $request->nombre_municipio,
            'departamento_id' => $request->departamento_id,
        ]);

        return response()->json($municipio, 200);
    }

    public function destroy($id){
        $municipio = Municipio::findOrFail($id);

        $municipio->delete();

        return response()->json('eliminado con exito', 200);
    }
}

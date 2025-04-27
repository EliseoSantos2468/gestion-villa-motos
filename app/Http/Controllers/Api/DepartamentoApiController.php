<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Departamento;
use App\Http\Controllers\Controller;


class DepartamentoApiController extends Controller
{
    public function index(){
        $departamentos = Departamento::with('municipios')->get();

        if($departamentos->isEmpty()){
            $data=[
                'message' => 'no hay ningun registro de departamento',
            ];

            return response()->json($data, 200);
        }

        return response()->json($departamentos, 200);
    }

    public function show($id){
        $departamento = Departamento::with('municipios')->get()->findOrFail($id);

        return response()->json($departamento, 200);
    }

    public function store(Request $request){
        $request->validate([
            'nombre_departamento' => 'required|string|max:355',
        ]);

        $departamento = Departamento::create([
            'nombre_departamento' => $request->nombre_departamento,
        ]);

        return response()->json('se creo con exito', 200);
    }

    public function update(Request $request, $id){
        $request->validate([
            'nombre_departamento' => 'required|string|max:255',
        ]);

        $departamento = Departamento::findOrFail($id);

        $departamento->update([
            'nombre_departamento' => $request->nombre_departamento,
        ]);

        return response()->json($departamento, 200);
    }

    public function destroy($id){
        $departamento = Departamento::findOrFail($id);

        $departamento->delete();

        return response()->json('eliminado con exito', 200);
    }
}

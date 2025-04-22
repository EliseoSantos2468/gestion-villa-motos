<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departamento;


class DepartamentoController extends Controller
{
    public function index(){
        $departamento = Departamento::all();

        if($departamento->isEmpty()){
            $data=[
                'message' => 'no hay ningun registro de departamento',
            ];

            return response()->json($data, 200);
        }

        return response()->json($departamento, 200);
    }

    public function show($id){
        $departamento = Departamento::findOrFail($id);

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

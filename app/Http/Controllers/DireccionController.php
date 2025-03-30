<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Direccion;

class DireccionController extends Controller
{   
    public function index(){
        $direccion = Direccion::all();

        if($direccion->isEmpty()){
            $data = [
                'message' =>'tabla vacia',
            ];

            return response()->json($data, 200);
        }

        return response()->json($direccion, 200);
    }

    public function show($id){
        $direccion = Direccion::findOrFail($id);

        return response()->json($direccion, 200);
    }

    public function store(Request $request){
        $request->validate([
            'barrio_colonia' => 'required|string|max:355',
            'municipio' => 'required|string|max:255',
            'dept' => 'required|string|max:255',
        ]);

        $direccion = Direccion::create([
            'barrio_colonia' => $request->barrio_colonia,
            'municipio' => $request->municipio,
            'dept' => $request->dept,
        ]);

        return response()->json($direccion, 200);
    }

    public function update(Request $request,$id){
        $request->validate([
            'barrio_colonia' => 'required|string|max:355',
            'municipio' => 'required|string|max:255',
            'dept' => 'required|string|max:255',
        ]);

        $direccion = Direccion::findOrFail($id);
    
        $direccion->update([
            'barrio_colonia' => $request->barrio_colonia,
            'municipio' => $request->municipio,
            'dept' => $request->dept,
        ]);

        return response()->json($direccion, 200);
    }

    public function destroy($id){
        $direccion = Direccion::findOrFail($id);

        $direccion->delete();

        return response()->json(['message'=>'direccion eliminada con exito']);
    }
}

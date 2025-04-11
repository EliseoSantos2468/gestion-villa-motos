<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Referencia;

class ReferenciaController extends Controller
{
    public function index(){
        $referencias = Referencia::all();  

        if($referencias->isEmpty()){//debuf api
            $data = [
                'message' => 'no hay registros en la tabla',
                'error' => 404,
            ];

            return response()->json($data, 404);
        }

        // return view('',compact('referencias'));
        return response()->json($referencias, 200);//debug api
    }  

    public function mostrarReferencia($id){
        $referencia = Referencia::findOrFail($id);

        // if($referencia->isempty()){
        //     $data = [
        //     'message' => 'el usuario no existe'
        //     ];
        //     return response()->json($data, 200);
        // }

        // return view('', compact('referencia'));
        return response()->json($referencia, 200);//debug api
    }

    public function crearReferencia(Request $request){  

        $request->validate([
            'telefono_ref' => 'required|string|max:255',
            'nombre_ref' => 'required|string|max:255',
        ]);

        $referencia = Referencia::create([
            'telefono_ref' =>$request->telefono_ref,
            'nombre_ref' =>$request->nombre_ref,
        ]);

        // return back()->with('success', 'Referencia creada con exito');
        return response()->json($referencia, 200);//debug api
    }

    public function actualizarReferencia(Request $request, $id){
        $request->validate([
            'telefono_ref' => 'required|string|max:255',
            'nombre_ref' => 'required|string|max:255',
        ]);

        $referencia = Referencia::findOrFail($id);

        $referencia->update([
            'telefono_ref' => $request->telefono_ref,
            'nombre_ref' => $request->nombre_ref,
        ]);

        $data = [
            'message' => 'usuario actualizado con exito',
            'telefono_ref' => $referencia->telefono_ref,
            'nombre_ref' => $referencia->nombre_ref,
        ];

        // return redirect()->route('')->with('success', 'se actualizo la referencia correctamente');
        return response()->json($data, 200);//debug api
    }

    public function eliminarReferencia($id){
        $referencia = Referencia::findOrFail($id);

        $referencia->delete();

        // return back()->with('success', 'referencia eliminada con exito');
        return response()->json(['message' => 'referencia eliminada con exito'], 200);//debug api
    }
}

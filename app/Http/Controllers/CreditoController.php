<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Credito;

class CreditoController extends Controller
{
    public function index(){
        $credito = Credito::all();  
        if($credito->isEmpty()){
            $data = [
                'message' => 'no hay registros en la tabla',
                'error' => 404,
            ];
            return response()->json($data, 404);
        }
        return response()->json($credito, 200);
    }

    public function show($id){
        $credito = Credito::findOrFail($id);
        return response()->json($credito, 200);
    }

    public function store(Request $request){  
        $request->validate([
            'monto_facturado' => 'required|numeric',
            'interes_moratorio' => 'required|numeric',
            'prima' => 'required|numeric',
        ]);
        
        $credito = Credito::create([
            'monto_facturado' =>$request->monto_facturado,
            'interes_moratorio' =>$request->interes_moratorio,
            'prima' =>$request->prima,
        ]);

        return response()->json($credito, 200);
    }

    public function update(Request $request, $id){
        $request->validate([
            'monto_facturado' => 'required|numeric',
            'interes_moratorio' => 'required|numeric',
            'prima' => 'required|numeric',
        ]);
        
        $credito = Credito::findOrFail($id);

        $credito->update([
            'monto_facturado' =>$request->monto_facturado,
            'interes_moratorio' =>$request->interes_moratorio,
            'prima' =>$request->prima,
        ]);
        return response()->json($credito, 200);
    }
    public function destroy($id){
        $credito = Credito::findOrFail($id);
        $credito->delete();
        return response()->json(['message' => 'credito eliminado con éxito'], 200);
    }
}

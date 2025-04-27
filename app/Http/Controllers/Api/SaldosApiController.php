<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Saldos;
use App\Http\Controllers\Controller;

class SaldosApiController extends Controller
{
    public function index(){
        $saldos = Saldos::all();  
        if($saldos->isEmpty()){
            $data = [
                'message' => 'no hay registros en la tabla',
                'error' => 404,
            ];
            return response()->json($data, 404);
        }
        return response()->json($saldos, 200);
    }
    public function show($id){
        $saldos = Saldos::findOrFail($id);
        return response()->json($saldos, 200);
    }
    public function store(Request $request){  
        $request->validate([
            'saldo_mora' => 'required|numeric',
            'saldo_p_interes' => 'required|numeric',
            'saldo_pendiente' => 'required|numeric',
        ]);
        $saldos = Saldos::create([
            'saldo_mora' =>$request->saldo_mora,
            'saldo_p_interes' =>$request->saldo_p_interes,
            'saldo_pendiente' =>$request->saldo_pendiente,
        ]);
        return response()->json($saldos, 200);
    }
    public function update(Request $request, $id){
        $request->validate([
            'saldo_mora' => 'required|numeric',
            'saldo_p_interes' => 'required|numeric',
            'saldo_pendiente' => 'required|numeric',
        ]);
        $saldos = Saldos::findOrFail($id);
        $saldos->update([
            'saldo_mora' =>$request->saldo_mora,
            'saldo_p_interes' =>$request->saldo_p_interes,
            'saldo_pendiente' =>$request->saldo_pendiente,
        ]);
        return response()->json($saldos, 200);
    }
    public function destroy($id){
        $saldos = Saldos::findOrFail($id);
        $saldos->delete();
        return response()->json(['message' => 'Saldo eliminado con éxito'], 200);
    }


}

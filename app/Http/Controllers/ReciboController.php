<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recibo;

class ReciboController extends Controller
{
    public function index(){
        $recibos = Recibo::all();

        if($recibos->isEmpty()){
            $data = [
                'message' => 'no hay registros de recibo'

            ];
            return response()->json($data, 200);
        }

        return response()->json($recibos, 200);
    }

    public function show($id){
        $recibo = Recibo::findOrFail($id);

        return response()->json($recibo, 200);
    }

    public function store(Request $request){
        $request->validate([
            'fecha' => 'required|date',
            'total' => 'required|numeric', 
        ]);

        $recibo = Recibo::create([
            'fecha' => $request->fecha,
            'total' => $request->total,
        ]);

        return response()->json($recibo, 200);
    }

    public function update(Request $request, $id){
        $request->validate([
            'fecha' => 'required|date',
            'total' => 'required|numeric', 
        ]);

        $recibo = Recibo::findOrFail($id);

        $recibo->update([
            'fecha' => $request->fecha,
            'total' => $request->total,
        ]);

        return response()->json($recibo, 200);
    }

    public function destroy($id){
        $recibo = Recibo::findOrFail($id);

        $recibo->delete();

        return response()->json('eliminado con exito', 200);
    }
}

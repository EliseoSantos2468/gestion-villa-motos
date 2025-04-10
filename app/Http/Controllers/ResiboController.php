<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Resibo;

class ResiboController extends Controller
{
    public function index(){
        $resibos = Resibo::all();

        if($resibos->isEmpty()){
            $data = [
                'message' => 'no hay registros de resibo'

            ];
            return response()->json($data, 200);
        }

        return response()->json($resibos, 200);
    }

    public function show($id){
        $resibo = Resibo::findOrFail($id);

        return response()->json($resibo, 200);
    }

    public function store(Request $request){
        $request->validate([
            'fecha' => 'required|date',
            'total' => 'required|numeric', 
        ]);

        $resibo = Resibo::create([
            'fecha' => $request->fecha,
            'total' => $request->total,
        ]);

        return response()->json($resibo, 200);
    }

    public function update(Request $request, $id){
        $request->validate([
            'fecha' => 'required|date',
            'total' => 'required|numeric', 
        ]);

        $resibo = Resibo::findOrFail($id);

        $resibo->update([
            'fecha' => $request->fecha,
            'total' => $request->total,
        ]);

        return response()->json($resibo, 200);
    }

    public function destroy($id){
        $resibo = Resibo::findOrFail($id);

        $resibo->delete();

        return response()->json('eliminado con exito', 200);
    }
}

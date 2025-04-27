<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Interes;
use App\Http\Controllers\Controller;

class InteresApiController extends Controller
{
    public function index(){
        $intereses = Interes::all();  
        if($intereses->isEmpty()){
            $data = [
                'message' => 'no hay registros en la tabla',
                'error' => 404,
            ];
            return response()->json($data, 404);
        }
        return response()->json($intereses, 200);
    }
    public function show($id){
        $interes = Interes::findOrFail($id);
        return response()->json($interes, 200);
    }
    public function store(Request $request){  
        $request->validate([
            'interes_general' => 'required|numeric',
        ]);
        $interes = Interes::create([
            'interes_general' =>$request->interes_general,
        ]);
        return response()->json($interes, 200);
    }
    public function update(Request $request, $id){
        $request->validate([
            'interes_general' => 'required|numeric',
        ]);
        $interes = Interes::findOrFail($id);
        $interes->update([
            'interes_general' =>$request->interes_general,
        ]);
        return response()->json($interes, 200);
    }
    public function destroy($id){
        $interes = Interes::findOrFail($id);
        $interes->delete();
        return response()->json(['message' => 'Interes eliminado con éxito'], 200);
    }
}

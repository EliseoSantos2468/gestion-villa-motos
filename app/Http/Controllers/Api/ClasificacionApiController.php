<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Clasificacion;
use App\Http\Controllers\Controller;

class ClasificacionApiController extends Controller
{
    public function index(){
        $clasificaciones = Clasificacion::all();

        if($clasificaciones->isEmpty()){
            $data=[
                'message' => 'no hay ningun registro de clasificacion',
            ];

            return response()->json($data, 200);
        }

        return response()->json($clasificaciones, 200);
    }

    public function show($id){
        $clasificacion = Clasificacion::findOrFail($id);

        return response()->json($clasificacion, 200);
    }

    public function store(Request $request){
        $request->validate([
            'nombre_clasificacion' => 'required|string|max:255',
        ]);

        $clasificacion = Clasificacion::create([
            'nombre_clasificacion' => $request->nombre_clasificacion,
        ]);

        return response()->json('se creo con exito', 200);
    }

    public function update(Request $request, $id){
        $request->validate([
            'nombre_clasificacion' => 'required|string|max:255'
        ]);

        $clasificacion = Clasificacion::findOrFail($id);

        $clasificacion->update([
            'nombre_clasificacion' => $request->nombre_clasificacion,
        ]);

        return response()->json($clasificacion, 200);
    }

    public function destroy($id){
        $clasificacion = Clasificacion::findOrFail($id);

        $clasificacion->delete();

        return response()->json('eliminado con exito', 200);
    }
}

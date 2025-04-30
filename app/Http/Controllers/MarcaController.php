<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Marca;


class MarcaController extends Controller
{
    public function index(){
        $marca = Marca::all();

        if($marca->isEmpty()){
            $data=[
                'message' => 'no hay ningun registro de marca',
            ];

            return response()->json($data, 200);
        }

        return response()->json($marca, 200);
    }

    public function show($id){
        $marca = Marca::findOrFail($id);

        return response()->json($marca, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombres_marcas' => 'required|array|min:1',
            'nombres_marcas.*' => 'required|string|max:355',
        ]);
    
        foreach ($request->nombres_marcas as $nombre) {
            Marca::create([
                'nombre_marca' => $nombre,
            ]);
        }
    
        return back()->with('success', 'Las marcas se crearon con éxito');
    }

    public function update(Request $request, $id){
        $request->validate([
            'nombre_marca' => 'required|string|max:255',
        ]);

        $marca = Marca::findOrFail($id);

        $marca->update([
            'nombre_marca' => $request->nombre_marca,
        ]);

        return response()->json($marca, 200);
    }

    public function destroy($id){
        $marca = Marca::findOrFail($id);

        $marca->delete();

        return response()->json('eliminado con exito', 200);
    }
}

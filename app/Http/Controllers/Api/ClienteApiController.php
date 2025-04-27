<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Departamento;
use App\Models\Referencia;
use App\Models\Municipio;
use GuzzleHttp\Client;
use App\Http\Controllers\Controller;

class ClienteApiController extends Controller
{
    public function index(){
            $cliente = Cliente::with([
                'referencias' => function($query){
                    $query->select('referencias_personales.id', 'nombre_ref', 'telefono_ref');
                },
                'productos' => function($query){
                    $query->select('producto.id', 'nombre_producto')
                            ->withPivot('cantidad');
                },
                'credito' => function($query){
                    $query->select('id', 'monto_facturado', 'interes_moratorio', 'prima', 'cliente_id');
                }
            ])->get();

        if($cliente->isEmpty()){
            $data = [
                'message' => 'no hay registros de cliente'

            ];
            return response()->json($data, 200);
        }

        return response()->json($cliente, 200);
    }

    public function show($id){
        $cliente = Cliente::findOrFail($id);

        return response()->json($cliente, 200);
    }

    public function store(Request $request){
        $request->validate([
            'nombres_cliente' => 'required|string|max:255',
            'apellidos_cliente' => 'required|string|max:255',
            'dui_cliente' => 'required|string|max:455', 
            'telefono_cliente' => 'required|string|max:455', 
            'nit_cliente' => 'required|string|max:455', 
            'email_cliente' => 'required|email|max:455',  
            'barrio' => 'required|string|max:355', 
            'id_departamento' => 'required|exists:departamento,id', 
            'id_municipio' => 'required|exists:municipio,id', 
            'referencias' => 'required|array', 
            'referencias.*.telefono_ref' => 'required|string|max:255', 
            'referencias.*.nombre_ref' => 'required|string|max:255', 
        ]);

        $municipio = Municipio::where('id', $request->id_municipio)
                                ->where('departamento_id', $request->id_departamento)
                                ->first();

        if(!$municipio){
            return response()->json('error municipio no encontrado', 200);
        }

        $cliente = Cliente::create([
            'nombres_cliente' => $request->nombres_cliente,
            'apellidos_cliente' => $request->apellidos_cliente,
            'dui_cliente' => $request->dui_cliente,
            'telefono_cliente' => $request->telefono_cliente,
            'nit_cliente' => $request->nit_cliente,
            'email_cliente' => $request->email_cliente,
            'monto_max' => 1000.00,
            'barrio' => $request->barrio,
            'id_clasificacion' => 3,
            'id_departamento' => $request->id_departamento,
            'id_municipio' => $request->id_municipio,
        ]);

        $idReferencias = [];

        foreach($request->referencias as $referencia){
            $referencia = Referencia::create([
                'telefono_ref' =>$referencia['telefono_ref'],
                'nombre_ref' =>$referencia['nombre_ref'],       
            ]);

            $idReferencias[] = $referencia->id;
        }


        $this->asignarReferencia($idReferencias, $cliente->id);

        return response()->json($cliente, 200);
    }

    public function asignarReferencia($idReferencias, $id_cliente){

        $cliente = Cliente::findOrFail($id_cliente);

        $cliente->referencias()->syncWithoutDetaching($idReferencias);

    }

    public function update(Request $request, $id){
        $request->validate([
            'nombres_cliente' => 'required|string|max:255',
            'apellidos_cliente' => 'required|string|max:255',
            'dui_cliente' => 'required|string|max:455', 
            'telefono_cliente' => 'required|string|max:455', 
            'nit_cliente' => 'required|string|max:455', 
            'email_cliente' => 'required|email|max:455', 
            'monto_max' => 'required|numeric', 
            'barrio' => 'required|string|max:355', 
            'id_clasificacion' => 'required|exists:clasificacion,id', 
            'id_departamento' => 'required|exists:departamento,id', 
            'id_municipio' => 'required|exists:municipio,id', 
            'referencias' => 'required|array', 
            'referencias.*.id_referencia' => 'required|exists:referencias_personales,id',  
        ]);

        $cliente = Cliente::findOrFail($id);

        $municipio = Municipio::where('id', $request->id_municipio)
        ->where('departamento_id', $request->id_departamento)
        ->first();

        if(!$municipio){
        return response()->json('error municipio no encontrado', 200);
        }

        $cliente->update([
            'nombres_cliente' => $request->nombres_cliente,
            'apellidos_cliente' => $request->apellidos_cliente,
            'dui_cliente' => $request->dui_cliente,
            'telefono_cliente' => $request->telefono_cliente,
            'nit_cliente' => $request->nit_cliente,
            'email_cliente' => $request->email_cliente,
            'monto_max' => $request->monto_max,
            'barrio' => $request->barrio,
            'id_clasificacion' => $request->id_clasificacion,
            'id_departamento' => $request->id_departamento,
            'id_municipio' => $request->id_municipio,
        ]);

        $referenciasNuevas = [];
        
        foreach ($request->referencias as $referencia) {
            $referenciasNuevas[]=$referencia['id_referencia'];
        }
        
        $cliente->referencias()->sync($referenciasNuevas);
        
        return response()->json($cliente->load('referencias'), 200);
    }

    public function destroy($id){
        $cliente = Cliente::findOrFail($id);

        $cliente->referencias()->detach();

        $cliente->delete();

        return response()->json('eliminado con exito', 200);
    }
}

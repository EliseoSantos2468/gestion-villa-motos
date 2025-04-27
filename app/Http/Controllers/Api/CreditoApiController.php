<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Credito;
use App\Models\Cuota;
use App\Models\Fechas;
use App\Models\Interes;
use App\Models\Saldos;
use App\Models\Cliente;
use App\Http\Controllers\Controller;

class CreditoApiController extends Controller
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

    public function store(Request $request)
    {
        $request->validate([
            'monto_facturado' => 'required|numeric',
            'interes_moratorio' => 'required|numeric',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
            'fecha_limite' => 'required|date',
            'numero_cuotas' => 'required|integer',
            'interes_id' => 'required|exists:interes,id',
            'cliente_id' => 'required|exists:cliente,id',
        ]);
    
        // Calcular prima, capital y valor de cuota
        $interes = Interes::findOrFail($request->interes_id);
        $prima = $request->monto_facturado * 0.5;
        $capital = $request->monto_facturado - $prima;
        $valor_cuota = ($capital / $request->numero_cuotas) * $interes->interes_general;
    
        // Buscar o crear la cuota
        $cuota = Cuota::firstOrCreate(
            ['numero_cuotas' => $request->numero_cuotas, 'valor_cuota' => $valor_cuota]
        );
    
        // Buscar o crear las fechas
        $fecha = Fechas::firstOrCreate(
            [
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin' => $request->fecha_fin,
                'fecha_limite' => $request->fecha_limite
            ]
        );
    
        // Crear el crédito con todos los datos
        $credito = Credito::create([
            'monto_facturado' => $request->monto_facturado,
            'interes_moratorio' => $request->interes_moratorio,
            'prima' => $prima,
            'cuota_id' => $cuota->id,
            'interes_id' => $request->interes_id,
            'cliente_id' => $request->cliente_id,
            'fechas_id' => $fecha->id,
        ]);
    
        // Crear los saldos
        $saldo= Saldos::create([
            'saldo_p_interes' => $capital * $interes->interes_general,
            'saldo_pendiente' => $capital,
            'credito_id' => $credito->id
        ]);

        $cliente = Cliente::findOrFail($request->cliente_id);
        
        $cliente->monto_max = $cliente->monto_max - $saldo->saldo_p_interes;
        $cliente->save();

        return response()->json($credito, 200);
    }

    public function update(Request $request, $id){
        $request->validate([
            'monto_facturado' => 'required|numeric',
            'interes_moratorio' => 'required|numeric',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date',
            'fecha_limite' => 'required|date',
            'numero_cuotas' => 'required|integer',
            'interes_id' => 'required|exists:interes,id',
            'cliente_id' => 'required|exists:cliente,id',
        ]);

        // Calcular prima, capital y valor de cuota
        $interes = Interes::findOrFail($request->interes_id);
        $prima = $request->monto_facturado * 0.5;
        $capital = $request->monto_facturado - $prima;
        $valor_cuota = ($capital / $request->numero_cuotas) * $interes->interes_general;
        
        // Buscar o crear la cuota
        $cuota = Cuota::firstOrCreate(
            ['numero_cuotas' => $request->numero_cuotas, 'valor_cuota' => $valor_cuota]
        );
    
        // Buscar o crear las fechas
        $fecha = Fechas::firstOrCreate(
            [
                'fecha_inicio' => $request->fecha_inicio,
                'fecha_fin' => $request->fecha_fin,
                'fecha_limite' => $request->fecha_limite
            ]
        );

        //logica para restaurar el monto maximo del cliente
        $credito = Credito::findOrFail($id);

        $cliente = Cliente::findOrFail($request->cliente_id);

        $cliente->monto_max = $cliente->monto_max + $credito->saldo->saldo_p_interes;

        $cliente->save();

        $credito->update([
            'monto_facturado' => $request->monto_facturado,
            'interes_moratorio' => $request->interes_moratorio,
            'prima' => $prima,
            'cuota_id' => $cuota->id,
            'interes_id' => $request->interes_id,
            'cliente_id' => $request->cliente_id,
            'fechas_id' => $fecha->id,
        ]);

        // Crear los saldos
        $saldo= Saldos::create([
            'saldo_p_interes' => $capital * $interes->interes_general,
            'saldo_pendiente' => $capital,
            'credito_id' => $credito->id
        ]);

        
        $cliente->monto_max = $cliente->monto_max - $saldo->saldo_p_interes;
        $cliente->save();

        return response()->json($credito, 200);
    }
    public function destroy($id){
        $credito = Credito::findOrFail($id);
        $credito->delete();
        return response()->json(['message' => 'credito eliminado con éxito'], 200);
    }
}

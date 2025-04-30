<?php

namespace App\Http\Controllers;
use App\Models\Credito;
use App\Models\Cuota;
use App\Models\Fechas;
use App\Models\Interes;
use App\Models\Saldos;
use App\Models\Cliente;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CreditoController extends Controller
{
    public function index(){
        $intereses = Interes::all();
        $creditos = Credito::with('saldo')->get();
        $clientes = Cliente::with('credito.saldo')->get();
        if($creditos->isEmpty()){
            $data = [
                'message' => 'no hay registros en la tabla',
                'error' => 404,
            ];
            return view('gestion.creditos',compact('creditos','clientes','intereses'));
        }
        return view('gestion.creditos',compact('creditos','clientes','intereses'));
    }

    public function show($id){
        $credito = Credito::with(['clientes', 'cuotas', 'intereses', 'fechas', 'saldo'])->findOrFail($id);
        return view('gestion.mostrarCredito', compact('credito'));
    }

    public function pagarCuota($id)
    {
        $credito = Credito::with(['saldo', 'cuotas'])->findOrFail($id);
    
        $saldo = $credito->saldo->first();
        $cuota = $credito->cuotas;
    
        if ($saldo && $cuota) {
            $valorCuota = number_format($cuota->valor_cuota, 2, '.', '');
            $saldoActual = number_format($saldo->saldo_p_interes, 2, '.', '');
    
            // Si es la última cuota, pagar todo lo que quede
            if ($cuota->numero_cuotas <= 1) {
                $nuevoSaldo = '0.00';
            } else {
                $nuevoSaldo = bcsub($saldoActual, $valorCuota, 2);
                if (bccomp($nuevoSaldo, '0.00', 2) === -1) {
                    $nuevoSaldo = '0.00';
                }
            }
    
            $saldo->saldo_p_interes = $nuevoSaldo;
            $saldo->save();
    
            $cuota->numero_cuotas = max(0, $cuota->numero_cuotas - 1);
            $cuota->save();
    
            if (bccomp($nuevoSaldo, '0.00', 2) === 0) {
                $saldo->delete();
                $credito->delete();
            }
    
            return redirect()->route('mostrarCreditos')->with('success', 'Cuota pagada exitosamente');
        }
    
        return redirect()->route('mostrarCreditos')->with('error', 'No hay saldo pendiente o datos incompletos');
    }


    public function store(Request $request)
    {
        $request->validate([
            'monto_facturado' => 'required|numeric',
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

        
        $fecha_inicio = Carbon::now();
        $numero_cuotas = (int) $request->numero_cuotas;

        // Calcular fecha_fin sumando el número de cuotas en meses
        $fecha_fin = $fecha_inicio->copy()->addMonths($numero_cuotas);

        // Calcular fecha_limite sumando 3 días a la fecha_fin
        $fecha_limite = $fecha_fin->copy()->addDays(3);
    
        // Buscar o crear las fechas
        $fecha = Fechas::firstOrCreate(
            [
                'fecha_inicio' => $fecha_inicio,
                'fecha_fin' => $fecha_fin,
                'fecha_limite' => $fecha_limite
            ]
        );
    
        // Crear el crédito con todos los datos
        $credito = Credito::create([
            'monto_facturado' => $request->monto_facturado,
            'interes_moratorio' => 1.15,
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

        return back()->with('success','se asigno el credito con exito');
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

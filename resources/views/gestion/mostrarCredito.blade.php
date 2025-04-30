@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/detalleCredito.css') }}">


<div class="credito-detalle-container">
    <h2 class="credito-titulo">Detalle del Crédito</h2>
    <div class="credito-card">
        <div class="credito-card-body">
            <h5 class="credito-id">Crédito ID: {{ $credito->id }}</h5>
            <ul class="credito-lista">
                <li><strong>Monto facturado:</strong> ${{ number_format($credito->monto_facturado, 2) }}</li>
                <li><strong>Interés moratorio:</strong> {{ $credito->interes_moratorio }}%</li>
                <li><strong>Prima:</strong> ${{ number_format($credito->prima, 2) }}</li>
                <li><strong>Cliente:</strong> {{ $credito->clientes->nombres_cliente ?? 'N/A' }} {{ $credito->clientes->apellidos_cliente ?? '' }}</li>
                <li><strong>Interés:</strong> {{ $credito->intereses->interes_general ?? 'N/A' }}%</li>
                <li><strong>Valor Cuota:</strong> ${{ $credito->cuotas->valor_cuota ?? 'N/A' }}</li>
                <li><strong>Número de Cuotas:</strong> {{ $credito->cuotas->numero_cuotas ?? 'N/A' }}</li>
                <li><strong>Saldo Pendiente:</strong> ${{ $credito->saldo->first()?->saldo_p_interes ?? 'N/A' }}</li>
                <li><strong>Fecha de Inicio:</strong> {{ \Carbon\Carbon::parse($credito->fechas->fecha_inicio ?? '')->format('d/m/Y') }}</li>
                <li><strong>Fecha Fin:</strong> {{ \Carbon\Carbon::parse($credito->fechas->fecha_fin ?? '')->format('d/m/Y') }}</li>
                <li><strong>Fecha Límite:</strong> {{ \Carbon\Carbon::parse($credito->fechas->fecha_limite ?? '')->format('d/m/Y') }}</li>
            </ul>

            <div class="credito-botones">
                <a href="{{ route('mostrarCreditos') }}" class="btn-volver">← Volver</a>
                <form action="{{ route('pagar.cuota', $credito->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-pagar">Pagar Cuota</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2 class="mb-4">Detalle del Crédito</h2>
    <div class="card shadow">
        <div class="card-body">
            <h5 class="card-title">Crédito ID: {{ $credito->id }}</h5>
            <ul class="list-group list-group-flush">
                <li class="list-group-item"><strong>Monto facturado:</strong> ${{ number_format($credito->monto_facturado, 2) }}</li>
                <li class="list-group-item"><strong>Interés moratorio:</strong> {{ $credito->interes_moratorio }}%</li>
                <li class="list-group-item"><strong>Prima:</strong> ${{ number_format($credito->prima, 2) }}</li>
                
                {{-- Relación con Cliente --}}
                <li class="list-group-item"><strong>Cliente:</strong> 
                    {{ $credito->clientes->nombres_cliente ?? 'N/A' }} 
                    {{ $credito->clientes->apellidos_cliente ?? '' }}
                </li>

                {{-- Relación con Interés --}}
                <li class="list-group-item"><strong>Interés:</strong> 
                    {{ $credito->intereses->interes_general ?? 'N/A' }}%
                </li>

                {{-- Relación con Cuota --}}
                <li class="list-group-item"><strong>Valor Cuota:</strong> 
                    ${{ $credito->cuotas->valor_cuota ?? 'N/A' }}
                </li>
                <li class="list-group-item"><strong>Número de Cuotas:</strong> 
                    {{ $credito->cuotas->numero_cuotas ?? 'N/A' }}
                </li>

                {{-- Relacion con saldos --}}
                <li class="list-group-item"><strong>Saldo Pendiente:</strong> 
                    ${{ $credito->saldo->first()?->saldo_p_interes ?? 'N/A' }}
                </li>

                {{-- Relación con Fechas --}}
                <li class="list-group-item"><strong>Fecha de Inicio:</strong> 
                    {{ \Carbon\Carbon::parse($credito->fechas->fecha_inicio ?? '')->format('d/m/Y') }}
                </li>
                <li class="list-group-item"><strong>Fecha Fin:</strong> 
                    {{ \Carbon\Carbon::parse($credito->fechas->fecha_fin ?? '')->format('d/m/Y') }}
                </li>
                <li class="list-group-item"><strong>Fecha Límite:</strong> 
                    {{ \Carbon\Carbon::parse($credito->fechas->fecha_limite ?? '')->format('d/m/Y') }}
                </li>
            </ul>
            

            <a href="{{ route('mostrarCreditos') }}" class="btn btn-secondary mt-3">Volver a la lista de Créditos</a>
            <form action="{{ route('pagar.cuota', $credito->id) }}" method="POST" class="mt-3">
                @csrf
                <button type="submit" class="btn btn-success">Pagar Cuota</button>
            </form>
        </div>
    </div>
</div>
@endsection
@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{asset('css/creditos.css')}}">

<div class="clientes">
    <h1>Asignacion de creditos</h1>

    <div class="clientes-acciones">
        <input type="text" placeholder="Buscar Clientes">
    </div>

    <div class="tabla">
        <table class="tabla-clientes">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Telefono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($clientes as $cliente)                    
                <tr>
                    <td>{{$cliente->id}}</td>
                    <td>{{$cliente->nombres_cliente}}</td>
                    <td>{{$cliente->email_cliente}}</td>
                    <td>{{$cliente->telefono_cliente}}</td>
                    <td class="columna-botones">

                        @if ($cliente->credito->first()?->saldo->first()?->saldo_p_interes == 0)
                        <button class="btn-asignar" 
                                type="button" 
                                data-bs-toggle="modal" 
                                data-bs-target="#asignarCreditoModal"
                                data-cliente-id="{{ $cliente->id }}">
                            <span class="material-symbols-rounded">monetization_on</span>
                            <p>Asignar Crédito</p>
                        </button>
                    @else
                        <a href="{{ route('mostrarCredito', ['id' => $cliente->credito->first()->id]) }}" class="btn-pagar">
                            <span class="material-symbols-rounded">payments</span>
                            <p>Pagar Cuota</p>
                        </a>
                    @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal Asignar Crédito -->
    <div class="modal fade" id="asignarCreditoModal" tabindex="-1" aria-labelledby="asignarCreditoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="asignarCreditoModalLabel">Asignar Crédito al Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <form id="form-asignar-credito" method="POST" action="{{ route('crearCredito') }}">
                        @csrf

                        <input type="hidden" name="cliente_id" id="cliente_id">
                        <div class="row mb-3">
                            <div class="col">
                                <label class="form-label">Monto del Crédito ($)</label>
                                <input type="number" name="monto_facturado" id="monto_facturado" class="form-control" placeholder="1000" max="1000" step="0.01" required>
                                </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <label class="form-label">Tasa de Interés (%)</label>
                                <select id="interes_id" name="interes_id" class="form-select">
                                    <option value="" selected disabled>Seleccione un porcentaje</option>
                                    @foreach ($intereses as $interes)
                                        <option value="{{ $interes->id }}">
                                            {{ number_format(($interes->interes_general - 1) * 100, 0) }}%
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <label class="form-label">Plazo (meses)</label>
                                <input type="number"
                                       name="numero_cuotas"
                                       id="numero_cuotas"
                                       class="form-control"
                                       placeholder="12"
                                       min="2"
                                       max="12"
                                       step="2">
                            </div>
                        </div>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success" id="btn-asignar-credito">Asignar Crédito</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('btn-asignar-credito').addEventListener('click', function () {
            document.getElementById('form-asignar-credito').submit();
        });
    </script>
    <script>
        const asignarCreditoModal = document.getElementById('asignarCreditoModal');
    
        asignarCreditoModal.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;
            const clienteId = button.getAttribute('data-cliente-id');
            document.getElementById('cliente_id').value = clienteId;
        });
    </script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const asignarBtns = document.querySelectorAll('.btn-asignar');
        asignarBtns.forEach(btn => {
            btn.addEventListener('click', function () {
                const clienteId = this.getAttribute('data-cliente-id');
                document.getElementById('cliente_id_modal').value = clienteId;
            });
        });
    });
    </script>

<script>
    document.getElementById('btn-asignar-credito').addEventListener('click', function () {
        const monto = parseFloat(document.getElementById('monto_facturado').value);
        if (isNaN(monto) || monto <= 0) {
            alert('Por favor, ingrese un monto válido mayor a 0.');
        } else if (monto > 1000) {
            alert('El monto del crédito no puede ser mayor a $1000.');
        } else {
            document.getElementById('form-asignar-credito').submit();
        }
    });
</script>

    @endsection
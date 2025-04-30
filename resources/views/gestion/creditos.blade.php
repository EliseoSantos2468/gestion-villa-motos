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
                        <a href="" class="btn-editar">
                            <span class="material-symbols-rounded">edit</span>
                            <p>editar</p>
                        </a>

                        <a href="" class="btn-eliminar">
                            <span class="material-symbols-rounded">delete</span>
                            <p>Eliminar</p>
                        </a>

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

    <div class="cotizador-credito">
        <div class="card shadow-lg">
            <div class="card-body" style="margintop: 20px;">
                <h2 class="card-title text-center mb-4">Cotizador de Crédito</h2>
                <form id="cotizadorForm" >
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="monto" class="form-label">Monto del Crédito ($):</label>
                            <input type="number" id="monto" class="form-control" value="10000" min="1000" required>
                        </div>
                        <div class="col-md-6">
                            <label for="plazo" class="form-label">Plazo (meses):</label>
                            <input type="number" id="plazo" class="form-control" value="12" min="6" max="60" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="interes" class="form-label">Tasa de Interés (% anual):</label>
                            <div class="input-group">
                                <input type="number" id="interes" class="form-control" value="5" min="0" step="0.1" required>
                                <span class="input-group-text">%</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="frecuencia" class="form-label">Frecuencia de Pago:</label>
                            <select id="frecuencia" class="form-select">
                                <option value="mensual">Mensual</option>
                                <option value="quincenal">Quincenal</option>
                                <option value="semanal">Semanal</option>
                            </select>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Calcular Cuota</button>
                </form>

                <div id="resultados" class="mt-4 resultados-container">
                    <h3 class="text-center">Resultados del Cálculo</h3>
                    <div class="table-responsive">
                        <table class="table table-bordered resultados-table">
                            <thead>
                                <tr>
                                    <th>Concepto</th>
                                    <th>Valor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Cuota</td>
                                    <td id="cuota"></td>
                                </tr>
                                <tr>
                                    <td>Total a Pagar</td>
                                    <td id="totalPagar"></td>
                                </tr>
                                <tr>
                                    <td>Interés Total</td>
                                    <td id="interesTotal"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div id="tablaAmortizacion" class="amortizacion-container">
                        <h4 class="text-center">Tabla de Amortización</h4>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover amortizacion-table">
                                <thead>
                                    <tr>
                                        <th>Periodo</th>
                                        <th>Saldo Inicial</th>
                                        <th>Cuota</th>
                                        <th>Interés</th>
                                        <th>Amortización</th>
                                        <th>Saldo Final</th>
                                    </tr>
                                </thead>
                                <tbody id="tablaAmortizacionBody">
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                                <input type="number" name="monto_facturado" id="monto_facturado" class="form-control" placeholder="1000.00">
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
    @endsection
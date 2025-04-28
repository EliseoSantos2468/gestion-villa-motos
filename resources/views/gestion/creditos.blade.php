@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{asset('css/creditos.css')}}">

<div class="clientes">
    <h1>Asignacion de creditos</h1>

    <div class="clientes-acciones">
        <input type="text" placeholder="Buscar Clientes">

        <button class="boton-crear" type="button" data-bs-toggle="modal" data-bs-target="#nuevoClienteModal">
            <span class="material-symbols-rounded">
                add
            </span>
            <p>Nuevo Cliente</p>
        </button>
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
                <tr>
                    <td>1</td>
                    <td>Edras Lazo</td>
                    <td>lazo@ues.edu.sv</td>
                    <td>7891-9523</td>
                    <td class="columna-botones">
                        <a href="" class="btn-editar">
                            <span class="material-symbols-rounded">edit</span>
                            <p>editar</p>
                        </a>

                        <a href="" class="btn-eliminar">
                            <span class="material-symbols-rounded">delete</span>
                            <p>Eliminar</p>
                        </a>

                        <button class="btn-asignar" type="button" data-bs-toggle="modal" data-bs-target="#asignarCreditoModal">
                            <span class="material-symbols-rounded">monetization_on</span>
                            <p>Asignar Crédito</p>
                        </button>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>CRISTIAN ALBERTO PINEDA</td>
                    <td>lazo@ues.edu.sv</td>
                    <td>7891-9523</td>
                    <td class="columna-botones">
                        <a href="" class="btn-editar">
                            <span class="material-symbols-rounded">edit</span>
                            <p>editar</p>
                        </a>

                        <a href="" class="btn-eliminar">
                            <span class="material-symbols-rounded">delete</span>
                            <p>Eliminar</p>
                        </a>

                        <button class="btn-asignar" type="button" data-bs-toggle="modal" data-bs-target="#asignarCreditoModal">
                            <span class="material-symbols-rounded">monetization_on</span>
                            <p>Asignar Crédito</p>
                        </button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="cotizador-credito">
        <div class="card shadow-lg">
            <div class="card-body" style="margintop: 20px;">
                <h2 class="card-title text-center mb-4">Cotizador de Crédito</h2>
                <form id="cotizadorForm">
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

    <!-- Modal Nuevo Cliente -->
    <div class="modal fade" id="nuevoClienteModal" tabindex="-1" aria-labelledby="nuevoClienteModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nuevoClienteModalLabel">Nuevo Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="row mb-3">
                            <div class="col">
                                <label class="form-label">Nombre Completo</label>
                                <input type="text" class="form-control" placeholder="Nombre">
                            </div>
                            <div class="col">
                                <label class="form-label">DUI</label>
                                <input type="text" class="form-control" placeholder="00000000-0">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <label class="form-label">NIT</label>
                                <input type="text" class="form-control" placeholder="0000-000000-000-0">
                            </div>
                            <div class="col">
                                <label class="form-label">Correo</label>
                                <input type="email" class="form-control" placeholder="Correo">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <label class="form-label">Teléfono</label>
                                <input type="text" class="form-control" placeholder="0000-0000">
                            </div>
                            <div class="col">
                                <label class="form-label">Departamento</label>
                                <input type="text" class="form-control" placeholder="Ahuachapán">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <label class="form-label">Municipio</label>
                                <input type="text" class="form-control" placeholder="Ahuachapán">
                            </div>
                            <div class="col">
                                <label class="form-label">Dirección</label>
                                <input type="text" class="form-control" placeholder="Dirección">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary">Guardar</button>
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
                    <form>
                        <div class="row mb-3">
                            <div class="col">
                                <label class="form-label">Nombre del Cliente</label>
                                <input type="text" class="form-control" placeholder="Ej: Cristian Alberto Pineda" readonly>
                            </div>
                            <div class="col">
                                <label class="form-label">Monto del Crédito ($)</label>
                                <input type="number" class="form-control" placeholder="1000.00">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <label class="form-label">Tasa de Interés (%)</label>
                                <input type="number" class="form-control" placeholder="5%">
                            </div>
                            <div class="col">
                                <label class="form-label">Plazo (meses)</label>
                                <input type="number" class="form-control" placeholder="12">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <label class="form-label">Fecha de Inicio</label>
                                <input type="date" class="form-control">
                            </div>
                            <div class="col">
                                <label class="form-label">Observaciones</label>
                                <textarea class="form-control" rows="2" placeholder="Observaciones del crédito"></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-success">Asignar Crédito</button>
                </div>
            </div>
        </div>
    </div>


    @endsection
@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{asset('css/ventas.css')}}">

    <div class="ventas">
        <h1>Ventas</h1>

        <div class="ventas-acciones">
            <input type="text" placeholder="Buscar ventas">

            <a href="{{route('nueva_venta')}}" class="boton-crear">
                <span class="material-symbols-rounded">
                    add
                </span>
                <p>Nueva Venta</p>
            </a>
        </div>

        <div class="tabla">
            <table class="tabla-ventas">
                <thead>
                  <tr>
                    <th>Codigo</th>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>V00000052</td>
                    <td>17-04-2025 06:56 PM</td>
                    <td>EDRAS ARIEL VIERA LAZO</td>
                    <td>$ 5,999.00</td>
                    <td>Finalizado</td>
                    <td class="columna-botones">
                        <a href="" class="btn-editar">
                            <span class="material-symbols-rounded">
                                edit
                            </span>
                            <p>editar</p>
                        </a>

                        <a href="" class="btn-pdf">
                            <span class="material-symbols-rounded">
                                description
                            </span>
                            <p>PDF</p>
                        </a>

                        <a href="" class="btn-eliminar">
                            <span class="material-symbols-rounded">
                                block
                            </span>
                            <p>Anular</p>
                        </a>

                    </td>
                  </tr>
                </tbody>
              </table>
        </div>
    </div>
  
@endsection
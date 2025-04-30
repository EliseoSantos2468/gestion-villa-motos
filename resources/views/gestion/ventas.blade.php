@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{asset('css/ventas.css')}}">

    <div class="ventas">
        <h1>Ventas</h1>

        <div class="ventas-acciones">
            <input type="text" placeholder="Buscar ventas">

            <a href="{{route('nuevaVenta')}}" class="boton-crear">
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
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Total</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
                    @forEach($recibos as $recibo)
                    <tr>
                      <td>{{$recibo->id}}</td>
                      <td>{{$recibo->fecha}}</td>
                      <td>{{ $recibo->cliente->nombres_cliente ?? 'Sin cliente' }}</td>
                      <td>{{$recibo->total}}</td>
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
                  @endforeach
                </tbody>
              </table>
        </div>
    </div>
  
@endsection
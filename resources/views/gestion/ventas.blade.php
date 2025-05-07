@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{asset('css/ventas.css')}}">

    <div class="ventas">
        <h1>Ventas</h1>

        <div class="ventas-acciones">
        <input type="text" id="busqueda" placeholder="Buscar por ID o Nombre">

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
                        <a href="{{ route('recibo.pdf', ['id' => $recibo->id]) }}" class="btn-pdf">
                            <span class="material-symbols-rounded">description</span>
                            <p>PDF</p>
                        </a>
                        
                      </td>
                    </tr>
                  @endforeach
                </tbody>
              </table>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const inputBusqueda = document.getElementById('busqueda');
        const filas = document.querySelectorAll('.tabla-ventas tbody tr');

        inputBusqueda.addEventListener('keyup', function () {
            const filtro = this.value.toLowerCase();

            filas.forEach(fila => {
                const id = fila.cells[0].textContent.toLowerCase();
                const nombre = fila.cells[2].textContent.toLowerCase();

                if (id.includes(filtro) || nombre.includes(filtro)) {
                    fila.style.display = '';
                } else {
                    fila.style.display = 'none';
                }
            });
        });
    });
</script>

@endsection
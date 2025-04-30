@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{asset('css/escritorio.css')}}">

    <div class="escritorio">
        
        <h1 class="escritorio-titulo">Escritorio</h1>

        {{-- <div class="graficas">
            <div class="graficas-dias">

                <h2>Totales Ultimos 30 dias</h2>

                <div id="grafica1"></div> --}}

                    
                {{-- <script>
                    var authors = @json($librosPorAutor->pluck('autor'));
                    var totals = @json($librosPorAutor->pluck('total'));

                    var options = {
                        series: totals,
                        chart: {
                            type: 'pie',
                            height: 350
                        },
                        labels: authors,
                        title: {
                            text: 'Distribución de Libros por Autor'
                        }
                    };

                    var chart = new ApexCharts(document.querySelector("#chart"), options);
                    chart.render();
                </script> --}}
            {{-- </div>
            <div class="graficas-meses">

                <h2>Totales por Meses</h2>

                <div id="grafica2"></div> --}}

                {{-- <script>
                    var authors = @json($librosPorAutor->pluck('autor'));
                    var totals = @json($librosPorAutor->pluck('total'));

                    var options = {
                        series: totals,
                        chart: {
                            type: 'pie',
                            height: 350
                        },
                        labels: authors,
                        title: {
                            text: 'Distribución de Libros por Autor'
                        }
                    };

                    var chart = new ApexCharts(document.querySelector("#chart"), options);
                    chart.render();
                </script> --}}
            {{-- </div>
        </div> --}}

        <div class="escritorio-ultimasVentas">
            <h2>Historico de Ventas</h2>
            <table class="tabla-ventas">
                <thead>
                  <tr>
                    <th>ID</th>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Total</th>
                      </tr>
                </thead>
                <tbody>
                    @foreach ($recibos as $recibo)
                        <tr>
                        <td>{{$recibo->id}}</td>
                        <td>{{$recibo->fecha}}</td>
                        <td>{{$recibo->cliente->nombres_cliente}}</td>
                        <td>{{$recibo->total}}</td>
                        </tr>
                    @endforeach
                </tbody>
              </table>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
@endsection
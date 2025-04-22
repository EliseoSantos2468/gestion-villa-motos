@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{asset('css/escritorio.css')}}">

    <div class="escritorio">
        
        <h1 class="escritorio-titulo">Escritorio</h1>

        <div class="graficas">
            <div class="graficas-dias">

                <h2>Totales Ultimos 30 dias</h2>

                <div id="grafica1"></div>

                    
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
            </div>
            <div class="graficas-meses">

                <h2>Totales por Meses</h2>

                <div id="grafica2"></div>

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
            </div>
        </div>

        <div class="escritorio-ultimasVentas">
            <h2>Ultimas Ventas</h2>
            <table class="tabla-ventas">
                <thead>
                  <tr>
                    <th>Código</th>
                    <th>Fecha</th>
                    <th>Cliente</th>
                    <th>Total</th>
                    <th>Estado</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>V00000049</td>
                    <td>14-04-2025 08:25 PM</td>
                    <td>EDRAS ARIEL VIERA LAZO</td>
                    <td>$ 5,999.00</td>
                    <td><span class="badge finalizado">Finalizado</span></td>
                  </tr>
                  <tr>
                    <td>V00000048</td>
                    <td>31-12-2024 09:30 AM</td>
                    <td>Sin cliente</td>
                    <td>$ 0.00</td>
                    <td><span class="badge pendiente">Pendiente</span></td>
                  </tr>
                </tbody>
              </table>
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
@endsection
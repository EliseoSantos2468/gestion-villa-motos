@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{asset('css/reportes.css')}}">

    <div class="reportes">
        <h1>Reportes</h1>

        <div class="contenedorSelect">
            <select name="" id="tipoReporte" onchange="cambiarFormulario()" class="reportesSelect">
                <option value="" selected disabled>Seleccione un reporte</option>
                <option value="ventas">Reporte de Ventas</option>
                <option value="vendedores">Reporte de Ventas por Vendedores</option>
                <option value="clientes">Reporte de Ventas por Clientes</option>
            </select>

            <button class="btn_generar">
                <span class="material-symbols-rounded">
                    print
                </span>
                <p>Generar Reporte</p>
            </button>
        </div>

        <div id="formularioContenedor">
            
        </div>
    </div>
    <script>
        function cambiarFormulario() {
          const tipo = document.getElementById("tipoReporte").value;
          const contenedor = document.getElementById("formularioContenedor");
        
          let formularioHTML = "";
        
          switch (tipo) {
            case "ventas":
              formularioHTML = `
                <div>
                    <label>Fecha inicial:</label>
                    <input type="date" name="fecha_inicio">
                </div>   

                <div>
                    <label>Fecha final:</label>
                    <input type="date" name="fecha_final">
                </div>

              `;
              break;
            case "vendedores":
              formularioHTML = `
                
                <div class="vendedor">
                    <label>Vendedor:</label>
                    <select name="vendedor" id="">
                        <option value="" selected>Todos</option>
                    </select>
                </div>

                <div>
                    <label>Fecha inicial:</label>
                    <input type="date" name="Vfecha_inicio">
                </div>

                <div>
                    <label>Fecha final:</label>
                    <input type="date" name="Vfecha_final">
                </div>

              `;
              break;
            case "clientes":
              formularioHTML = `
                <div class="cliente">
                    <label>Cliente:</label>
                    <select name="cliente" id="">
                        <option value="" selected>Todos</option>
                    </select>
                </div>

                <div>
                    <label>Fecha inicial:</label>
                    <input type="date" name="Cfecha_inicio">
                </div>

                <div>
                    <label>Fecha final:</label>
                    <input type="date" name="Cfecha_final">
                </div>
              `;
              break;
            default:
              formularioHTML = "";
          }
        
          contenedor.innerHTML = formularioHTML;
        }
        </script>
@endsection
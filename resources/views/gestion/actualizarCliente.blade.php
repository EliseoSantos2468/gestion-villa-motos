@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{asset('css/actualizar_cliente.css')}}">

<form method="POST" action="{{route('actualizarCliente', $cliente->id)}}">
    @csrf
    @method('PUT')

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-10 col-lg-8">
      <div class="form-card">
        <div class="row mb-4">
          <h5 class="card-title display-6">Editar Cliente</h5>
        </div>
        <!-- Aquí empieza el contenido del formulario -->
        <form>
          <div class="row mb-3">
            <div class="col">
              <label class="form-label">Nombre Completo</label>
              <input type="text" name="nombres_cliente" id="nombres_cliente" class="form-control" placeholder="Nombre" required value="{{$cliente->nombres_cliente}}">
            </div>
            <div class="col">
              <label class="form-label">Apellidos</label>
              <input type="text" name="apellidos_cliente" id="apellidos_cliente" class="form-control" placeholder="Apellidos" required value="{{$cliente->apellidos_cliente}}">
            </div>
            <div class="col">
              <label class="form-label">DUI</label>
              <input type="text" name="dui_cliente" id="dui_cliente" class="form-control" placeholder="00000000-0" required value="{{$cliente->dui_cliente}}">
            </div>
          </div>

          <div class="row mb-3">
            <div class="col">
              <label class="form-label">Monto máximo</label>
              <input type="number" name="monto_max" id="monto_max" class="form-control" required value="{{$cliente->monto_max}}">
            </div>
            <div class="col">
              <label class="form-label">Clasificación</label>
              <select name="id_clasificacion" id="id_clasificacion" class="form-select">
                <option value="" disabled selected>Seleccione una clasificación</option>
                @foreach ($clasificaciones as $clasificacion)
                  <option value="{{$clasificacion->id}}" {{ $clasificacion->id == $cliente->id_clasificacion ? 'selected' : '' }}>
                    {{$clasificacion->nombre_clasificacion}}
                  </option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col">
              <label class="form-label">NIT</label>
              <input type="text" name="nit_cliente" id="nit_cliente" class="form-control" placeholder="0000-000000-000-0" required value="{{$cliente->nit_cliente}}">
            </div>
            <div class="col">
              <label class="form-label">Correo</label>
              <input type="email" name="email_cliente" id="email_cliente" class="form-control" placeholder="Correo" required value="{{$cliente->email_cliente}}">
            </div>
          </div>

          <div class="row mb-3">
            <div class="col">
              <label class="form-label">Referencias Personales</label>
              <div class="referencias-containerA">
                <div class="referencia-item mb-2">
                  <div class="row g-2">
                    <div class="col-md-5">
                      <input type="text" class="form-control nombre-referenciaA" placeholder="Nombre referencia" name="nombre_ref">
                    </div>
                    <div class="col-md-5">
                      <input type="tel" class="form-control telefono-referenciaA" id="telefono" placeholder="0000-0000" maxlength="9" name="telefono_ref">
                    </div>
                    <div class="col-md-2">
                      <button type="button" class="btn btn-sm btn-outline-danger add-referenciaA">
                        <span class="material-symbols-rounded">add</span>
                      </button>
                    </div>
                  </div>
                </div>
                <div id="referencias-listaA"></div>
              </div>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col">
              <label class="form-label">Teléfono</label>
              <input type="tel" name="telefono_cliente" id="telefono_cliente" class="form-control" placeholder="0000-0000" value="{{$cliente->telefono_cliente}}">
            </div>
            <div class="col">
              <label class="form-label">Departamento</label>
              <select id="departamentoSelectE" class="form-select" name="id_departamento">
                <option value="" disabled>Seleccione un departamento</option>
                @foreach ($departamentos as $departamento)
                  <option value="{{ $departamento->id }}" {{ $departamento->id == $cliente->id_departamento ? 'selected' : '' }}>
                    {{ $departamento->nombre_departamento }}
                  </option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col">
              <label class="form-label">Municipio</label>
              <select id="municipioSelectE" class="form-select" name="id_municipio">
                <option value="" selected disabled>Seleccione un municipio</option>
              </select>
            </div>
            <div class="col">
              <label class="form-label">Barrio/Colonia</label>
              <input type="text" name="barrio" id="barrio" class="form-control" placeholder="Dirección" value="{{$cliente->barrio}}">
            </div>
          </div>

          <button type="submit" class="btn btn-primary" id="btn-actualizar">
            Actualizar
          </button>
        </form>
        <!-- Fin del contenido del formulario -->
      </div>
    </div>
  </div>
</div>

  <script>
    let referenciasCount2 = 0; // Para numerar correctamente
    
    // Datos que vienen del servidor (referencias actuales del cliente)
    const referenciasIniciales = @json($cliente->referencias); // Suponiendo que pasaste las referencias en el controlador
    
    const referenciasContainer = document.querySelector('.referencias-containerA');
    const listaReferencias = document.getElementById('referencias-listaA');
    
    // Función para crear una referencia visual + inputs
    function crearReferencia(idReferencia, nombreReferencia, telefonoReferencia) {
      const referenciaDiv = document.createElement('div');
      referenciaDiv.classList.add('referencia-item');
      referenciaDiv.dataset.index = referenciasCount2;
    
      // Campo oculto para id_referencia
      const inputIdReferencia = document.createElement('input');
      inputIdReferencia.type = 'hidden';
      inputIdReferencia.name = `referencias[${referenciasCount2}][id_referencia]`;
      inputIdReferencia.value = idReferencia; // Asume que cada referencia tiene un id único
    
      const inputNombre = document.createElement('input');
      inputNombre.type = 'hidden';
      inputNombre.name = `referencias[${referenciasCount2}][nombre_ref]`;
      inputNombre.value = nombreReferencia;
      inputNombre.classList.add(`input-nombre-${referenciasCount2}`);
    
      const inputTelefono = document.createElement('input');
      inputTelefono.type = 'hidden';
      inputTelefono.name = `referencias[${referenciasCount2}][telefono_ref]`;
      inputTelefono.value = telefonoReferencia;
      inputTelefono.classList.add(`input-telefono-${referenciasCount2}`);
    
      const texto = document.createElement('p');
      texto.innerHTML = `Nombre: ${nombreReferencia}, Teléfono: ${telefonoReferencia}`;
    
      const botonEliminar = document.createElement('button');
      botonEliminar.type = 'button';
      botonEliminar.classList.add('btn', 'btn-sm', 'btn-danger', 'ms-2');
      botonEliminar.innerText = 'Eliminar';
      botonEliminar.addEventListener('click', function() {
        // Eliminar inputs ocultos
        inputIdReferencia.remove();
        inputNombre.remove();
        inputTelefono.remove();
        // Eliminar visualmente la referencia
        referenciaDiv.remove();
      });
    
      referenciaDiv.appendChild(texto);
      referenciaDiv.appendChild(botonEliminar);
      listaReferencias.appendChild(referenciaDiv);
    
      // Añadir los inputs ocultos al contenedor
      referenciasContainer.appendChild(inputIdReferencia);
      referenciasContainer.appendChild(inputNombre);
      referenciasContainer.appendChild(inputTelefono);
    
      referenciasCount2++; // Incrementar contador
    }
    
    // Cargar referencias existentes al cargar la página
    window.addEventListener('DOMContentLoaded', function() {
      if (referenciasIniciales && referenciasIniciales.length > 0) {
        referenciasIniciales.forEach(ref => {
          crearReferencia(ref.id, ref.nombre_ref, ref.telefono_ref); // Pasar id_referencia aquí
        });
      }
    });
    
    // Evento para agregar nuevas referencias manualmente
    document.querySelector('.add-referenciaA').addEventListener('click', function() {
      const nombreReferencia = document.querySelector('.nombre-referenciaA').value;
      const telefonoReferencia = document.querySelector('.telefono-referenciaA').value;
    
      if (nombreReferencia && telefonoReferencia) {
    
        crearReferencia(null, nombreReferencia, telefonoReferencia);
    
        // Limpiar campos
        document.querySelector('.nombre-referenciaA').value = '';
        document.querySelector('.telefono-referenciaA').value = '';
      } else {
        alert('Por favor, completa ambos campos.');
      }
    });
  </script>
   
  
  <script>
    const departamentosConMunicipios = @json($departamentos);
  
    const departamentoSelectE = document.getElementById('departamentoSelectE');
    const municipioSelectE = document.getElementById('municipioSelectE');
  
    // Estos valores vienen del cliente
    const departamentoCliente = {{ $cliente->id_departamento }};
    const municipioCliente = {{ $cliente->id_municipio }};
  
    function cargarMunicipios(departamentoId, municipioIdSeleccionado = null) {
      municipioSelectE.innerHTML = '<option value="" disabled>Seleccione un municipio</option>';
  
      const departamento = departamentosConMunicipios.find(dep => dep.id == departamentoId);
  
      if (departamento && departamento.municipios.length > 0) {
        municipioSelectE.disabled = false;
        departamento.municipios.forEach(municipio => {
          const option = document.createElement('option');
          option.value = municipio.id;
          option.textContent = municipio.nombre_municipio;
          // Si coincide con el municipio actual del cliente, lo seleccionamos
          if (municipioIdSeleccionado && municipio.id == municipioIdSeleccionado) {
            option.selected = true;
          }
          municipioSelectE.appendChild(option);
        });
      } else {
        municipioSelectE.disabled = true;
      }
    }
  
    // Cuando cambia el departamento manualmente
    departamentoSelectE.addEventListener('change', function() {
      const departamentoId = this.value;
      cargarMunicipios(departamentoId);
    });
  
    // Al cargar el formulario: cargar municipios del cliente automáticamente
    window.addEventListener('DOMContentLoaded', function() {
      if (departamentoCliente) {
        departamentoSelectE.value = departamentoCliente;
        cargarMunicipios(departamentoCliente, municipioCliente);
      }
    });
  </script>
  <script src="{{ asset('js/Auth/editar.js') }}"></script>
@endsection
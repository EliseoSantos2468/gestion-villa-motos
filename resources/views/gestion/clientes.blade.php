@extends('layouts.app')


@section('content')
<link rel="stylesheet" href="{{asset('css/clientes.css')}}">

<div class="clientes">
  <h1>Clientes</h1>

  @if (session('success'))
  <div class="alert alert-success" style="display:none;">
    {{ session('success') }}
  </div>
  @endif

  @if (session('error'))
  <div class="alert alert-danger" style="display:none;">
    {{ session('error') }}
  </div>
  @endif

  @if (session('warning'))
  <div class="alert alert-warning" style="display:none;">
    {{ session('warning') }}
  </div>
  @endif

  @if (session('info'))
  <div class="alert alert-info" style="display:none;">
    {{ session('info') }}
  </div>
  @endif


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
          <th>Nombres</th>
          <th>Apellidos</th>
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
          <td>{{$cliente->apellidos_cliente}}</td>
          <td>{{$cliente->email_cliente}}</td>
          <td>{{$cliente->telefono_cliente}}</td>
          <td class="columna-botones">
            {{-- <button type="button" class="btn-editar" title="Editar" data-bs-toggle="modal" data-bs-target="#editarClienteModal"
              data-id="{{ $cliente->id }}"
              data-nombres="{{ $cliente->nombres_cliente }}"
              data-apellidos="{{ $cliente->apellidos_cliente }}"
              data-dui="{{ $cliente->dui_cliente }}"
              data-nit="{{ $cliente->nit_cliente }}"
              data-id_departamento="{{ $cliente->id_departamento }}"
              data-id_municipio="{{ $cliente->id_municipio }}"
              data-email="{{ $cliente->email_cliente }}"
              data-telefono="{{ $cliente->telefono_cliente }}"
              data-referencias='@json($cliente->referencias)'
              data-barrio="{{ $cliente->barrio }}">
              <span class="material-symbols-rounded">edit</span>
              <span class="btn-text">editar</span>
            </button> --}}
            <a href="{{route('actualizarClientevista', $cliente->id)}}" class="btn-editar">
              <span class="material-symbols-rounded">edit</span>
              <p class="btn-text">editar</p>
            </a>
            <form action="{{route('borrarCliente', $cliente->id)}}" method="POST">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn-eliminar" title="Eliminar">
                <span class="material-symbols-rounded">delete</span>
                <span class="btn-text">Eliminar</span>
              </button>
            </form>
          </td>
        </tr>
        @endforeach

      </tbody>
    </table>
  </div>
</div>


<!-- Modal -->
<div class="modal fade" id="nuevoClienteModal" tabindex="-1" aria-labelledby="nuevoClienteModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="nuevoClienteModalLabel">Nuevo Cliente</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <form method="POST" action="{{route('crearCliente')}}">
          @csrf
          <div class="row mb-3">
            <div class="col">
              <label class="form-label">Nombre Completo</label>
              <input type="text" name="nombres_cliente" class="form-control" placeholder="Nombre" required>
              @error('nombres_cliente')
              <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
            <div class="col">
              <label class="form-label">Apellidos</label>
              <input type="text" name="apellidos_cliente" class="form-control" placeholder="Apellidos" required>
              @error('apellidos_cliente')
              <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
            <div class="col">
              <label class="form-label">DUI</label>
              <input type="text" name="dui_cliente" class="form-control" placeholder="00000000-0" required maxlength="9" pattern="\d{8}-\d">  
              @error('dui_cliente')
              <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
          </div>

          <div class="row mb-3">
            <div class="col">
              <label class="form-label">Referencias Personales</label>
              <div class="referencias-container">
                <div class="referencia-item mb-2">
                  <div class="row g-2">
                    <div class="col-md-5">
                      <input type="text" class="form-control nombre-referencia" placeholder="Nombre referencia" maxlength="50">
                      @error('nombre_ref')
                      <small class="text-danger">{{ $message }}</small>
                      @enderror

                    </div>
                    <div class="col-md-5">
                      <input type="tel" class="form-control telefono-referencia" id="telefono" placeholder="0000-0000" maxlength="9">
                      @error('telefono_ref')
                      <small class="text-danger">{{ $message }}</small>
                      @enderror
                    </div>
                    <div class="col-md-2">
                      <button type="button" class="btn btn-sm btn-outline-danger add-referencia">
                        <span class="material-symbols-rounded">add</span>
                      </button>
                    </div>
                  </div>
                </div>
                <div id="referencias-lista">
                  <!-- Aquí se mostrarán las referencias agregadas -->
                </div>
              </div>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col">
              <label class="form-label">NIT</label>
              <input type="text" name="nit_cliente" class="form-control" placeholder="0000-000000-000-0" required maxlength="14">
              @error('nit_cliente')
              <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
            <div class="col">
              <label class="form-label">Correo</label>
              <input type="email" name="email_cliente" class="form-control" placeholder="Correo" required>
              @error('email_cliente')
              <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
          </div>

          <!-- Resto de tu formulario... -->
          <div class="row mb-3">
            <div class="col">
              <label class="form-label">Teléfono</label>
              <input type="tel" name="telefono_cliente" class="form-control" placeholder="0000-0000"  required maxlength="9">
              @error('telefono_cliente')
              <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
            <div class=" col">
              <label class="form-label">Departamento</label>
              <select id="departamentoSelect" class="form-select" name="id_departamento" requerid>
                <option value="" selected disabled>Seleccione un departamento</option>
                @foreach ($departamentos as $departamento)
                <option value="{{ $departamento->id }}">{{ $departamento->nombre_departamento }}</option>
                @endforeach
              </select>
            </div>
          </div>

          <div class="row mb-3">
            <div class="col">
              <label class="form-label">Municipio</label>
              <select id="municipioSelect" class="form-select" name="id_municipio" requerid>
                <option value="" selected disabled>Seleccione un municipio</option>
                <!-- Opciones se agregarán aquí -->
              </select>
            </div>
            <div class="col">
              <label class="form-label">Barrio/Colonia</label>
              <input type="text" name="barrio" class="form-control" placeholder="Dirección" required>
              @error('barrio')
              <small class="text-danger">{{ $message }}</small>
              @enderror
            </div>
          </div>
          <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  let referenciasCount = 0; // Para numerar las referencias correctamente

  document.querySelector('.add-referencia').addEventListener('click', function() {
    const nombreReferencia = document.querySelector('.nombre-referencia').value;
    const telefonoReferencia = document.querySelector('.telefono-referencia').value;
    const referenciasContainer = document.querySelector('.referencias-container');
    const listaReferencias = document.getElementById('referencias-lista');

    if (nombreReferencia && telefonoReferencia) {
      // Crear un contenedor para esta referencia
      const referenciaDiv = document.createElement('div');
      referenciaDiv.classList.add('referencia-item');
      referenciaDiv.dataset.index = referenciasCount; // Guardamos el número de referencia para identificarla

      // Crear inputs ocultos
      const inputNombre = document.createElement('input');
      inputNombre.type = 'hidden';
      inputNombre.name = `referencias[${referenciasCount}][nombre_ref]`;
      inputNombre.value = nombreReferencia;
      inputNombre.classList.add(`input-nombre-${referenciasCount}`);

      const inputTelefono = document.createElement('input');
      inputTelefono.type = 'hidden';
      inputTelefono.name = `referencias[${referenciasCount}][telefono_ref]`;
      inputTelefono.value = telefonoReferencia;
      inputTelefono.classList.add(`input-telefono-${referenciasCount}`);

      // Crear texto visible
      const texto = document.createElement('p');
      texto.innerHTML = `Nombre: ${nombreReferencia}, Teléfono: ${telefonoReferencia}`;

      // Crear botón de eliminar
      const botonEliminar = document.createElement('button');
      botonEliminar.type = 'button';
      botonEliminar.classList.add('btn', 'btn-sm', 'btn-danger', 'ms-2');
      botonEliminar.innerText = 'Eliminar';
      botonEliminar.addEventListener('click', function() {
        // Eliminar inputs ocultos
        document.querySelector(`.input-nombre-${referenciasCount}`)?.remove();
        document.querySelector(`.input-telefono-${referenciasCount}`)?.remove();
        // Eliminar visualmente la referencia
        referenciaDiv.remove();
      });

      referenciaDiv.appendChild(texto);
      referenciaDiv.appendChild(botonEliminar);

      listaReferencias.appendChild(referenciaDiv);

      // Agregar inputs ocultos al formulario
      referenciasContainer.appendChild(inputNombre);
      referenciasContainer.appendChild(inputTelefono);

      // Limpiar campos
      document.querySelector('.nombre-referencia').value = '';
      document.querySelector('.telefono-referencia').value = '';

      referenciasCount++; // Incrementar para siguiente referencia
    } else {
      alert('Por favor, completa ambos campos.');
    }
  });
</script>

<script>
  const departamentosConMunicipios = @json($departamentos);

  const departamentoSelect = document.getElementById('departamentoSelect');
  const municipioSelect = document.getElementById('municipioSelect');

  departamentoSelect.addEventListener('change', function() {
    const departamentoId = this.value;

    // Limpiar municipios anteriores
    municipioSelect.innerHTML = '<option value="" selected disabled>Seleccione un municipio</option>';

    const departamento = departamentosConMunicipios.find(dep => dep.id == departamentoId);

    if (departamento && departamento.municipios.length > 0) {
      municipioSelect.disabled = false;
      departamento.municipios.forEach(municipio => {
        const option = document.createElement('option');
        option.value = municipio.id;
        option.textContent = municipio.nombre_municipio; 
        municipioSelect.appendChild(option);
      });
    } else {
      municipioSelect.disabled = true;
    }
  });
</script>
<script src="{{ asset('js/Auth/modal_validation.js') }}"></script>

@endsection
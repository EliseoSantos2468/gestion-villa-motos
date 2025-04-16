@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{asset('css/clientes.css')}}">

    <div class="clientes">
        <h1>Clientes</h1>

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
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Telefono</th>
                    <th>Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Edras Lazo</td>
                    <td>lazo@ues.edu.sv</td>
                    <td>7891-9523</td>
                    <td class="columna-botones">
                        <a href="" class="btn-editar">
                            <span class="material-symbols-rounded">
                                edit
                            </span>
                            <p>editar</p>
                        </a>

                        <a href="" class="btn-eliminar">
                            <span class="material-symbols-rounded">
                                delete
                            </span>
                            <p>Eliminar</p>
                        </a>

                    </td>
                  </tr>
                  <tr>
                    <td>CRISTIAN ALBERTO PINEDA</td>
                    <td>lazo@ues.edu.sv</td> 
                    <td>7891-9523</td>
                    <td class="columna-botones">
                        <a href="" class="btn-editar">
                            <span class="material-symbols-rounded">
                                edit
                            </span>
                            <p>editar</p>
                        </a>

                        <a href="" class="btn-eliminar">
                            <span class="material-symbols-rounded">
                                delete
                            </span>
                            <p>Eliminar</p>
                        </a>
                    </td>
                  </tr>
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
  
@endsection
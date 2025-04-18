@extends('layouts.app')

@section('content')
    <link rel="stylesheet" href="{{asset('css/nueva_venta.css')}}">

    <div class="nuevaVenta">
        <h1>Nueva Venta</h1>

        
        <div class="acciones">
            <div class="nuevaVenta-cliente">
                <select name="" id="" class="select-cliente">
                    <option value="" selected disabled>seleccione un cliente</option>
                    <option value="">Edras</option>
                </select>
    
                <a href="" class="btn-agregar">
                    <span class="material-symbols-rounded">
                        add
                    </span>
                </a>
            </div>

            <button class="btn-detalle" data-bs-toggle="modal" data-bs-target="#nuevoDetalleModal">
                <span class="material-symbols-rounded">
                    add
                </span>
                <p>Nuevo Detalle</p>
            </button>

        </div>

        <div class="tabla">
            <table class="tabla-venta">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Marca</th>
                        <th>Modelo</th>
                        <th>Color</th>
                        <th>Chasis</th>
                        <th>Precio</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>FREEDOM</td>
                        <td>FXR 200L</td>
                        <td>ROJO</td>
                        <td>NO</td>
                        <td>$ 4,454.00</td>
                        <td class="columna-botones">
                            <a href="" class="btn-editar">
                                <span class="material-symbols-rounded">edit</span>
                                <p>editar</p>
                            </a>

                            <a href="" class="btn-eliminar">
                                <span class="material-symbols-rounded">delete</span>
                                <p>Eliminar</p>
                            </a>
                        </td>
                    </tr>
                </tbody>
        </table>

        
    </div>
    <div class="contenedorTotal">
        <div class="total">
            <p class="total-precio"><span>Total</span>$ 4,454.00</p>
            <button class="total-boton">
                <span class="material-symbols-rounded">check</span>
                <p>Cerrar Venta</p>
            </button>
        </div>
    </div>

        <!-- Modal -->
<div class="modal fade" id="nuevoDetalleModal" tabindex="-1" aria-labelledby="nuevoDetalleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="nuevoDetalleModalLabel">Nuevo Detalle</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <form>
            <div class="row mb-3">
              <div class="col">
                <label class="form-label">Marca</label>
                <select name="" id="" class="form-select">
                    <option value="" selected disabled>Seleccione una marca</option>
                </select>
              </div>
              <div class="col">
                <label class="form-label">Modelo</label>
                <select name="" id="" class="form-select">
                    <option value="" selected disabled>Seleccione un modelo</option>
                </select>
              </div>
            </div>
  
            <div class="row mb-3">
              <div class="col">
                <label class="form-label">Color </label>
                <input type="text" class="form-control" placeholder="Color"Color>
              </div>
              <div class="col">
                <label class="form-label">Tipo</label>
                <select name="" id="" class="form-select">
                    <option value="" selected disabled>Seleccione un tipo</option>
                    <option value="">Urbana</option>
                    <option value="">Rural</option>
                </select>
              </div>
            </div>
  
            <div class="row mb-3">
              <div class="col">
                <label class="form-label">Chasis</label>
                <input type="text" class="form-control" placeholder="Chasis">
              </div>
              <div class="col">
                <label class="form-label">Motor</label>
                <input type="text" class="form-control" placeholder="Motor">
              </div>
            </div>
  
            <div class="row mb-3">
              <div class="col">
                <label class="form-label">Poliza</label>
                <input type="text" class="form-control" placeholder="Poliza">
              </div>
              <div class="col">
                <label class="form-label">Precio</label>
                <input type="number" class="form-control" placeholder="Precio" min="0" step="0.01" required>
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
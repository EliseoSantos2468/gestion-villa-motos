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
          <th>ID</th>
          <th>Marca</th>
          <th>Producto</th>
          <th>Descripcion</th>
          <th>Precio C</th>
          <th>Precio M</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>1</td>
          <td>HONDA</td>
          <td>Llanta</td>
          <td>NUM 200</td>
          <td>1,200</td>
          <td>1,000</td>

          <td class="columna-botones">
            <a href="" class="btn-editar" title="Editar">
              <span class="material-symbols-rounded">edit</span>
            </a>
            <a href="" class="btn-informacion" title="Información" data-bs-toggle="modal" data-bs-target="#infoProductoModal">
              <span class="material-symbols-rounded">info</span>
            </a>
            <a href="" class="btn-eliminar" title="Eliminar">
              <span class="material-symbols-rounded">delete</span>
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
                <h5 class="modal-title" id="nuevoDetalleModalLabel">Agregar Producto a Venta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Marca</label>
                            <select class="form-select" id="selectMarca">
                                <option value="" selected disabled>Seleccione una marca</option>
                                <option value="1">HONDA</option>
                                <option value="2">TOYOTA</option>
                                <option value="3">YAMAHA</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Producto</label>
                            <select class="form-select" id="selectProducto">
                                <option value="" selected disabled>Seleccione un producto</option>
                                <option value="1" data-precio-cliente="1200" data-precio-mayoreo="1000" data-descripcion="Llanta para motocicleta">Llanta</option>
                                <option value="2" data-precio-cliente="800" data-precio-mayoreo="700" data-descripcion="Retrovisor original">Retrovisor</option>
                                <option value="3" data-precio-cliente="1500" data-precio-mayoreo="1300" data-descripcion="Kit de herramientas completo">Kit de herramientas</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="form-label">Precio Unitario</label>
                            <input type="number" class="form-control" id="precioUnitario" value="0.00" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Cantidad</label>
                            <input type="number" class="form-control" id="cantidad" min="1" value="1">
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Precio Total</label>
                            <input type="number" class="form-control" id="precioTotal" value="0.00" readonly>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <label class="form-label">Descripción</label>
                            <textarea class="form-control" id="descripcionProducto" rows="2" readonly></textarea>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Tipo de Venta</label>
                            <select class="form-select" id="tipoVenta">
                                <option value="cliente">Cliente Normal</option>
                                <option value="mayoreo">Mayoreo</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Descuento (%)</label>
                            <input type="number" class="form-control" id="descuento" min="0" max="100" value="0">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary">Agregar a Venta</button>
            </div>
        </div>
    </div>
</div>
  @endsection
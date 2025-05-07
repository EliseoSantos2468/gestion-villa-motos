@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/nueva_venta.css') }}">

<div class="nuevaVenta">
  <h1>Nueva Venta</h1>

  <form action="{{ route('crearRecibo') }}" method="POST">
    @csrf

    <div class="acciones">
      <div class="nuevaVenta-cliente">
        <select name="id_cliente" id="id_cliente" class="select-cliente" required>
          <option value="" selected disabled>Seleccione un cliente</option>
          @foreach ($clientes as $cliente)
            <option value="{{ $cliente->id }}">{{ $cliente->nombres_cliente }}</option>
          @endforeach
        </select>
      </div>

      <button type="button" class="btn-detalle" data-bs-toggle="modal" data-bs-target="#nuevoDetalleModal">
        <p>Agregar producto</p>
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
        <tbody id="tablaProductos">
          {{-- Productos se insertan aquí --}}
        </tbody>
      </table>
    </div>

    <input type="hidden" name="total" id="totalInput">
    <div class="contenedorTotal">
      <div class="total">
        <p class="total-precio"><span>Total</span>$ 0.00</p>
        <button class="total-boton" type="submit">
          <span class="material-symbols-rounded">check</span>
          <p>Cerrar Venta</p>
        </button>
      </div>
    </div>
  </form>
</div>

<!-- Modal -->
<div class="modal fade" id="nuevoDetalleModal" tabindex="-1" aria-labelledby="nuevoDetalleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Agregar Producto a Venta</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <div class="row mb-3">
          <div class="col-md-6">
            <label class="form-label">Producto</label>
            <select class="form-select" id="id_producto">
              <option value="" selected disabled>Seleccione un producto</option>
              @foreach ($productos as $producto)
                <option value="{{ $producto->id }}">{{ $producto->nombre_producto }}</option>
              @endforeach
            </select>
          </div>
          <div class="col-md-6">
            <label class="form-label">Marca</label>
            <select class="form-select" id="id_marca">
              <option value="" selected disabled>Seleccione una marca</option>
              @foreach ($marcas as $marca)
                <option value="{{ $marca->id }}">{{ $marca->nombre_marca }}</option>
              @endforeach
            </select>
          </div>
        </div>

        <div class="row mb-3">
          <div class="col-md-4">
            <label class="form-label">Cantidad</label>
            <input type="number" class="form-control" id="cantidad" min="1" value="1">
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="btnAgregarProducto">Agregar a Venta</button>
      </div>
    </div>
  </div>
</div>

<script>
  const productos = @json($productos);
  let total = 0;
  let contadorProducto = 0;

  function actualizarTotal() {
  total = Math.max(0, total); // Evitar negativos
  document.querySelector('.total-precio').innerHTML = `<span>Total</span>$ ${total.toFixed(2)}`;
  document.getElementById('totalInput').value = total.toFixed(2); // ✅ Actualiza el input hidden
}

  document.getElementById('id_producto').addEventListener('change', function () {
    const productoId = this.value;
    const producto = productos.find(p => p.id == productoId);
    const marcaSelect = document.getElementById('id_marca');
    marcaSelect.innerHTML = `<option value="" disabled selected>Seleccione una marca</option>`;
    if (producto && producto.marcas) {
      producto.marcas.forEach(m => {
        marcaSelect.innerHTML += `<option value="${m.id}">${m.nombre_marca}</option>`;
      });
    }
  });

  document.getElementById('btnAgregarProducto').addEventListener('click', function () {
    const idProducto = document.getElementById('id_producto').value;
    const idMarca = document.getElementById('id_marca').value;
    const cantidad = parseInt(document.getElementById('cantidad').value);

    if (!idProducto || !idMarca || cantidad < 1) {
      alert("Complete todos los campos correctamente.");
      return;
    }

    const producto = productos.find(p => p.id == idProducto);
    const marca = producto.marcas.find(m => m.id == idMarca);
    const precioCliente = parseFloat(marca.precio_cliente);
    const precioMayoreo = parseFloat(marca.precio_mayoreo);
    const descripcion = producto.descripcion_producto ?? 'N/A';

    let subtotal = cantidad >= 10 ? precioMayoreo * cantidad : precioCliente * cantidad;
    total += subtotal;
    actualizarTotal();

    const row = document.createElement('tr');
    row.setAttribute('data-subtotal', subtotal); // Guardar el subtotal en la fila

    row.innerHTML = `
      <td>
        <input type="hidden" name="productos[${contadorProducto}][id_producto]" value="${producto.id}">
        ${producto.id}
      </td>
      <td>
        <input type="hidden" name="productos[${contadorProducto}][id_marca]" value="${marca.id}">
        ${marca.nombre_marca}
      </td>
      <td>${producto.nombre_producto}</td>
      <td>${descripcion}</td>
      <td>$${precioCliente.toFixed(2)}</td>
      <td>$${precioMayoreo.toFixed(2)}</td>
      <td class="columna-botones">
        <input type="hidden" name="productos[${contadorProducto}][cantidad]" value="${cantidad}">
        <a href="#" class="btn-eliminar" title="Eliminar">
          <span class="material-symbols-rounded">delete</span>
        </a>
      </td>
    `;

    contadorProducto++;
    document.getElementById('tablaProductos').appendChild(row);

    // Limpiar campos
    document.getElementById('id_producto').value = "";
    document.getElementById('id_marca').innerHTML = `<option value="" selected disabled>Seleccione una marca</option>`;
    document.getElementById('cantidad').value = 1;

    // Cerrar modal
    const modal = bootstrap.Modal.getInstance(document.getElementById('nuevoDetalleModal'));
    modal.hide();
  });

  document.getElementById('tablaProductos').addEventListener('click', function (e) {
    if (e.target.closest('.btn-eliminar')) {
      e.preventDefault();
      const row = e.target.closest('tr');
      const subtotal = parseFloat(row.getAttribute('data-subtotal')) || 0;
      total -= subtotal;
      actualizarTotal();
      row.remove();
    }
  });

  actualizarTotal();
</script>
@endsection

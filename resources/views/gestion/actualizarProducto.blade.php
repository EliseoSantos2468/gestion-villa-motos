@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/actualizar_producto.css') }}">

<div class="container">
    <h2>Actualizar Producto</h2>

    <form action="{{ route('actualizarProducto', $producto->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nombre_producto" class="form-label">Nombre del Producto</label>
            <input type="text" name="nombre_producto" class="form-control" value="{{ $producto->nombre_producto }}" required>
        </div>

        <div class="mb-3">
            <label for="descripcion_producto" class="form-label">Descripción</label>
            <textarea name="descripcion_producto" class="form-control" rows="2" required>{{ $producto->descripcion_producto }}</textarea>
        </div>

        <hr>
        <h4>Marcas Asociadas</h4>
        <div id="marcas-container">
            @foreach($producto->marcas as $i => $marca)
                <div class="row marca-item mb-3 border rounded p-2">
                    <div class="col-md-3">
                        <label>Marca</label>
                        <select name="marcas[{{ $i }}][id]" class="form-control" required>
                            <option value="" disabled>Seleccione una marca</option>
                            @foreach ($marcas as $m)
                                <option value="{{ $m->id }}" {{ $m->id == $marca->id ? 'selected' : '' }}>
                                    {{ $m->nombre_marca }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label>Cantidad</label>
                        <input type="number" name="marcas[{{ $i }}][cantidad]" class="form-control"
                               value="{{ $marca->pivot->cantidad }}" required>
                    </div>
                    <div class="col-md-2">
                        <label>Precio Cliente</label>
                        <input type="number" step="0.01" name="marcas[{{ $i }}][precio_cliente]" class="form-control"
                               value="{{ $marca->pivot->precio_cliente }}" required>
                    </div>
                    <div class="col-md-2">
                        <label>Precio Mayoreo</label>
                        <input type="number" step="0.01" name="marcas[{{ $i }}][precio_mayoreo]" class="form-control"
                               value="{{ $marca->pivot->precio_mayoreo }}" required>
                    </div>
                    <div class="col-md-2">
                        <label>Venta Producto</label>
                        <input type="number" name="marcas[{{ $i }}][venta_producto]" class="form-control"
                               value="{{ $marca->pivot->venta_producto }}" required>
                    </div>
                    <div class="col-md-1 d-flex align-items-end">
                        <button type="button" class="btn btn-danger remove-marca"><span class="material-symbols-rounded">delete</span></button>
                    </div>
                </div>
            @endforeach
        </div>

        <button type="button" class="btn btn-secondary my-3" id="add-marca">Agregar Marca</button>
        <br>
        <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    </form>
</div>

<script>
    let marcaIndex = {{ count($producto->marcas) }};
    const marcasDisponibles = @json($marcas);

    function getMarcasSeleccionadas() {
        return Array.from(document.querySelectorAll('select[name^="marcas"]')).map(select => select.value).filter(val => val);
    }

    function generarSelect(index) {
        const seleccionadas = getMarcasSeleccionadas();
        const opciones = marcasDisponibles
            .filter(m => !seleccionadas.includes(m.id.toString()))
            .map(m => `<option value="${m.id}">${m.nombre_marca}</option>`)
            .join('');

        return `
            <select name="marcas[${index}][id]" class="form-control marca-select" required>
                <option value="" disabled selected>Seleccione una marca</option>
                ${opciones}
            </select>
        `;
    }

    function actualizarOpcionesSelects() {
        const seleccionadas = getMarcasSeleccionadas();

        document.querySelectorAll('select[name^="marcas"]').forEach(select => {
            const valorActual = select.value;
            const index = select.name.match(/\d+/)[0];

            select.innerHTML = `<option value="" disabled>Seleccione una marca</option>` +
                marcasDisponibles
                    .filter(m => m.id == valorActual || !seleccionadas.includes(m.id.toString()))
                    .map(m => {
                        const isSelected = m.id == valorActual ? 'selected' : '';
                        return `<option value="${m.id}" ${isSelected}>${m.nombre_marca}</option>`;
            }).join('');
        });
    }

    document.getElementById('add-marca').addEventListener('click', () => {
        const row = document.createElement('div');
        row.className = 'row marca-item mb-3 border rounded p-2';

        row.innerHTML = `
            <div class="col-md-3">
                <label>Marca</label>
                ${generarSelect(marcaIndex)}
            </div>
            <div class="col-md-2">
                <label>Cantidad</label>
                <input type="number" name="marcas[${marcaIndex}][cantidad]" class="form-control" required>
            </div>
            <div class="col-md-2">
                <label>Precio Cliente</label>
                <input type="number" step="0.01" name="marcas[${marcaIndex}][precio_cliente]" class="form-control" required>
            </div>
            <div class="col-md-2">
                <label>Precio Mayoreo</label>
                <input type="number" step="0.01" name="marcas[${marcaIndex}][precio_mayoreo]" class="form-control" required>
            </div>
            <div class="col-md-2">
                <label>Venta Producto</label>
                <input type="number" name="marcas[${marcaIndex}][venta_producto]" class="form-control" required>
            </div>
            <div class="col-md-1 d-flex align-items-end">
                <button type="button" class="btn btn-danger remove-marca"><span class="material-symbols-rounded">delete</span></button>
            </div>
        `;

        document.getElementById('marcas-container').appendChild(row);
        marcaIndex++;
        actualizarOpcionesSelects();
    });

    document.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-marca')) {
            e.target.closest('.marca-item').remove();
            actualizarOpcionesSelects();
        }
    });

    document.addEventListener('change', function (e) {
        if (e.target.classList.contains('marca-select')) {
            actualizarOpcionesSelects();
        }
    });

    // Ejecutar una vez al cargar
    actualizarOpcionesSelects();
</script>
@endsection

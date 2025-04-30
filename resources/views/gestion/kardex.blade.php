@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/kardex.css') }}">

<div class="inventario">
    <h1>Kardex e Inventario</h1>

    <div class="inventario-acciones">
        <input type="text" placeholder="Buscar productos..." class="buscador">

        <button class="boton-crearMarca" type="button" data-bs-toggle="modal" data-bs-target="#nuevaMarcaModal">
            <p>Nuevo marca</p>
        </button>
        <button class="boton-crear" type="button" data-bs-toggle="modal" data-bs-target="#nuevoProductoModal">
            <p>Nueva producto</p>
        </button>
    </div>

    <div class="modal fade" id="nuevaMarcaModal" tabindex="-1" aria-labelledby="nuevaMarcaModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="nuevaMarcaModalLabel">Agregar Marcas</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-3"><strong>Ingrese el nombre de las marcas que desea registrar:</strong></p>

                        <div id="contenedor-marcas">
                            <div class="row mb-3 grupo-marca">
                                <div class="col-10">
                                    <input type="text" name="nombres_marcas[]" class="form-control" placeholder="Nombre de la marca" required>
                                </div>
                                <div class="col-2">
                                    <button type="button" class="btn btn-danger btn-sm btn-eliminar-campo">X</button>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="btn btn-success btn-sm" id="btn-agregar-campo">
                            + Agregar otra marca
                        </button>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar Marcas</button>
                    </div>
                </div>
            </form>
        </div>
    </div>



    <!-- Modal Crear Nuevo Producto -->
    <div class="modal fade" id="nuevoProductoModal" tabindex="-1" aria-labelledby="nuevoProductoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nuevoProductoModalLabel">Crear Nuevo Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('crearProducto')}}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col">
                                <label for="nombre">Nombre del Producto</label>
                                <input type="text" id="nombre_producto" name="nombre_producto" class="form-control" required>
                            </div>
                            <div id="marcas-container">
                                <div class="marca-item row mb-3">
                                    <div class="col">
                                        <label>Marca</label>
                                        <select name="marcas[0][id]" class="form-control marca-select" required>
                                            <option value="" disabled selected>Seleccione una marca</option>
                                            @foreach ($marcas as $marca)
                                            <option value="{{$marca->id}}">{{$marca->nombre_marca}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label>Cantidad</label>
                                        <input type="number" name="marcas[0][cantidad]" class="form-control" required min="1">
                                    </div>
                                    <div class="col">
                                        <label>Precio Cliente</label>
                                        <input type="number" name="marcas[0][precio_cliente]" class="form-control" required step="0.01">
                                    </div>
                                    <div class="col">
                                        <label>Precio Mayoreo</label>
                                        <input type="number" name="marcas[0][precio_mayoreo]" class="form-control" required step="0.01">
                                    </div>
                                    <div class="col d-flex align-items-end">
                                        <button type="button" class="btn btn-danger remove-marca">Eliminar</button>
                                    </div>
                                </div>
                            </div>

                            <button type="button" id="add-marca" class="btn btn-secondary mt-2">Agregar otra marca</button>
                        </div>

                        <div class="mb-3">
                            <label for="descripcion">Descripción</label>
                            <textarea id="descripcion" name="descripcion_producto" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-primary">Guardar Producto</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de productos -->
    <div class="tabla mt-4">
        <div class="tabla-scroll">
            <table class="tabla-productos">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Marca</th>
                        <th>P. Cliente</th>
                        <th>P. Mayoreo</th>
                        <th>Stock</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productos as $producto)
                    @foreach ($producto->marcas as $marca)
                    <tr>
                        <td>{{$producto->id}}</td>
                        <td>{{$producto->nombre_producto}}</td>
                        <td>{{$marca->nombre_marca}}</td>
                        <td>{{$marca->precio_cliente}}</td>
                        <td>{{$marca->precio_mayoreo}}</td>
                        <td>{{$marca->pivot->cantidad}}</td>
                        <td class="columna-botones">
                            <a href="#" class="btn-informacion" title="Información"><span class="material-symbols-rounded">info</span></a>
                            <a href="{{route('actualizarProductovista', $producto->id)}}" class="btn-editar" title="Editar"><span class="material-symbols-rounded">edit</span></a>
                            <form action="{{route('borrarProducto', $producto->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn-eliminar" type="submit" title="Eliminar"><span class="material-symbols-rounded">delete</span></button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<script>
    let index = 1;

    function updateSelectOptions() {
        const allSelects = document.querySelectorAll('.marca-select');
        const selectedValues = Array.from(allSelects).map(select => select.value).filter(v => v);

        allSelects.forEach(select => {
            const options = select.querySelectorAll('option');
            options.forEach(option => {
                if (option.value === "" || option.selected) return;
                option.hidden = selectedValues.includes(option.value);
            });
        });
    }

    document.getElementById('add-marca').addEventListener('click', function() {
        const container = document.getElementById('marcas-container');

        const newItem = document.createElement('div');
        newItem.classList.add('row', 'mb-3', 'marca-item');
        newItem.innerHTML = `
            <div class="col">
                <label>Marca</label>
                <select name="marcas[${index}][id]" class="form-control marca-select" required>
                    <option value="" disabled selected>Seleccione una marca</option>
                    @foreach ($marcas as $marca)
                        <option value="{{$marca->id}}">{{$marca->nombre_marca}}</option>
                    @endforeach
                </select>
            </div>
            <div class="col">
                <label>Cantidad</label>
                <input type="number" name="marcas[${index}][cantidad]" class="form-control" required min="1">
            </div>
            <div class="col">
                <label>Precio Cliente</label>
                <input type="number" name="marcas[${index}][precio_cliente]" class="form-control" required step="0.01">
            </div>
            <div class="col">
                <label>Precio Mayoreo</label>
                <input type="number" name="marcas[${index}][precio_mayoreo]" class="form-control" required step="0.01">
            </div>
            <div class="col d-flex align-items-end">
                <button type="button" class="btn btn-danger remove-marca">Eliminar</button>
            </div>
        `;

        container.appendChild(newItem);
        index++;
        updateSelectOptions();
    });

    // Eliminar un bloque de marca
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-marca')) {
            const item = e.target.closest('.marca-item');
            item.remove();
            updateSelectOptions();
        }
    });

    // Actualizar opciones al cambiar selección
    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('marca-select')) {
            updateSelectOptions();
        }
    });

    // Inicial
    updateSelectOptions();
</script>
@endsection
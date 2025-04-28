@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/kardex.css') }}">

<div class="inventario">
    <h1>Kardex e Inventario</h1>

    <div class="inventario-acciones">
        <input type="text" placeholder="Buscar productos..." class="buscador">

        <button class="boton-crear" type="button" data-bs-toggle="modal" data-bs-target="#nuevoProductoModal">
            <p>Nuevo producto</p>
        </button>
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
                    <form action="#" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <div class="col">
                                <label for="nombre">Nombre del Producto</label>
                                <input type="text" id="nombre" name="nombre" class="form-control" required>
                            </div>
                            <div class="col">
                                <label for="marca">Marca</label>
                                <select id="marca" name="marca" class="form-control" required>
                                    <option value="" disabled selected>Seleccione una marca</option>
                                    <option value="VINI">VINI</option>
                                    <option value="ENDURO">ENDURO</option>
                                    <option value="NRP">NRP</option>
                                    <option value="MICHELIN">MICHELIN</option>
                                    <option value="TVS">TVS</option>
                                    <option value="BAJAJ">BAJAJ</option>
                                </select>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <label for="precio_cliente">Precio al Cliente ($)</label>
                                <input type="number" step="0.01" id="precio_cliente" name="precio_cliente" class="form-control" required>
                            </div>
                            <div class="col">
                                <label for="precio_mayoreo">Precio Mayoreo ($)</label>
                                <input type="number" step="0.01" id="precio_mayoreo" name="precio_mayoreo" class="form-control">
                            </div>
                            <div class="col">
                                <label for="cantidad">Cantidad en Stock</label>
                                <input type="number" id="cantidad" name="cantidad" class="form-control" min="0" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="descripcion">Descripción</label>
                            <textarea id="descripcion" name="descripcion" class="form-control" rows="3"></textarea>
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
                    <!-- Producto ejemplo -->
                    <tr>
                        <td>1</td>
                        <td>Laptop HP EliteBook</td>
                        <td>HP</td>
                        <td>$1,200.00</td>
                        <td>$1,000.00</td>
                        <td>15</td>
                        <td class="columna-botones">
                            <a href="#" class="btn-informacion" title="Información"><span class="material-symbols-rounded">info</span></a>
                            <a href="#" class="btn-editar" title="Editar"><span class="material-symbols-rounded">edit</span></a>
                            <a href="#" class="btn-eliminar" title="Eliminar"><span class="material-symbols-rounded">delete</span></a>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Teclado Mecánico RGB</td>
                        <td>Logitech</td>
                        <td>$85.00</td>
                        <td>$70.00</td>
                        <td>32</td>
                        <td class="columna-botones">
                            <a href="#" class="btn-informacion" title="Información"><span class="material-symbols-rounded">info</span></a>
                            <a href="#" class="btn-editar" title="Editar"><span class="material-symbols-rounded">edit</span></a>
                            <a href="#" class="btn-eliminar" title="Eliminar"><span class="material-symbols-rounded">delete</span></a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
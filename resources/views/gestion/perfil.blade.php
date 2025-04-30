@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/perfil.css') }}">

<div class="perfil-usuario">
    <h1>Mi Perfil</h1>

    <div class="tarjeta-perfil">
        <h2>Información del Usuario</h2>
        <div class="perfil-info">
            <p><strong>Nombre:</strong> {{ Auth::user()->name }}</p>
            <p><strong>Correo:</strong> {{ Auth::user()->email }}</p>
            <p><strong>Rol:</strong> </p>
        </div>
    </div>

    <div class="tarjeta-perfil">
        <h2>Editar Información</h2>
        <form action="#" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Nombre</label>
                <input type="text" name="name" value="" required>
            </div>

            <div class="form-group">
                <label for="email">Correo</label>
                <input type="email" name="email" value="" required>
            </div>

            <div class="form-botones">
                <button type="submit" class="boton-guardar">Guardar Cambios</button>
            </div>
        </form>
    </div>

    <div class="tarjeta-perfil">
        <h2>Cambiar Contraseña</h2>
        <form action="#" method="POST">
            @csrf
            <div class="form-group">
                <label for="actual">Contraseña Actual</label>
                <input type="password" name="actual" required>
            </div>

            <div class="form-group">
                <label for="nueva">Nueva Contraseña</label>
                <input type="password" name="nueva" required>
            </div>

            <div class="form-group">
                <label for="confirmacion">Confirmar Nueva Contraseña</label>
                <input type="password" name="confirmacion" required>
            </div>

            <div class="form-botones">
                <button type="submit" class="boton-guardar">Actualizar Contraseña</button>
            </div>
        </form>
    </div>
</div>
@endsection

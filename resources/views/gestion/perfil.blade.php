@extends('layouts.app')

@section('content')
<link rel="stylesheet" href="{{ asset('css/perfil.css') }}">

<div class="perfil-container">
    <div class="perfil-card">
        <h1 class="perfil-titulo">Mi Perfil</h1>

        <div class="perfil-seccion">
            <h2>Información del Usuario</h2>
            <div class="perfil-datos">
                <p><strong>Nombre:</strong> {{ Auth::user()->name }}</p>
                <p><strong>Correo:</strong> {{ Auth::user()->email }}</p>
            </div>
        </div>

    </div>
</div>
@endsection

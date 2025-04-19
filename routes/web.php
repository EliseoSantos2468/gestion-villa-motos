<?php

use Illuminate\Support\Facades\Route;

// Ruta principal
Route::get('/', function () {
    return view('gestion.escritorio');
});

Route::get('/preview-register', function () {
    return view('auth.register');
})->name('preview.register');

// Rutas de preview (sin autenticación)
Route::get('/preview-login', function () {
    return view('auth.login');
})->name('preview.login');

// Rutas protegidas (requieren autenticación)
Route::prefix('inicio')->group(function(){
    Route::get('/escritorio', function(){
        return view('gestion.escritorio');
    })->name('inicio.escritorio');

    Route::get('/clientes', function(){
        return view('gestion.clientes');
    })->name('inicio.clientes');

    Route::get('/ventas', function(){
        return view('gestion.ventas');
    })->name('inicio.ventas');

    Route::get('/ventas/nueva', function(){
        return view('gestion.venta_nueva');
    })->name('inicio.ventas.nueva');

    Route::get('/creditos', function(){
        return view('gestion.creditos');
    })->name('inicio.creditos');

    Route::get('/soporte', function(){
        return view('gestion.soporte');
    })->name('inicio.soporte');
});
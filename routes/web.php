<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('gestion.escritorio');
});

Route::prefix('inicio')->group(function(){
    Route::get('/escritorio', function(){
        return view('gestion.escritorio');
    })->name('Escritorio');

    Route::get('/clientes', function(){
        return view('gestion.clientes');
    })->name('Clientes');

    Route::get('/Ventas', function(){
        return view('gestion.ventas');
    })->name('Ventas');

    Route::get('/Ventas/nueva', function(){
        return view('gestion.venta_nueva');
    })->name('nueva_venta');

    Route::get('/creditos', function(){
        return view('gestion.creditos');
    })->name('Creditos');
});
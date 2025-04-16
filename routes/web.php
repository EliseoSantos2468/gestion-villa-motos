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
});

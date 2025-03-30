<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReferenciaController;
use App\Http\Controllers\DireccionController;
use Illuminate\Support\Facades\Redis;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('referenciasPersonales')->group(function(){
    Route::get('/referencias', [ReferenciaController::class, 'index'])->name('mostrarReferencias');
    Route::get('/referencia/{id}', [ReferenciaController::class, 'mostrarReferencia'])->name('mostrarReferencia');
    Route::post('/crear/referencia', [ReferenciaController::class, 'crearReferencia'])->name('crearReferencia');
    Route::put('/actualizar/referencia/{id}', [ReferenciaController::class, 'actualizarReferencia'])->name('actualizarReferencia');
    Route::delete('/eliminar/referencia/{id}', [ReferenciaController::class, 'eliminarReferencia'])->name('eliminarReferencia');
});

Route::prefix('direccion')->group(function(){
    Route::get('/mostrar', [DireccionController::class, 'index'])->name('mostrarDirecciones');
    Route::get('/mostrar/{id}', [DireccionController::class, 'show'])->name('mostrarDireccion');
    Route::post('/crear', [DireccionController::class, 'store'])->name('crearDireccion');
    Route::put('/actualizar/{id}', [DireccionController::class, 'update'])->name('actualizarDireccion');
    Route::delete('/borrar/{id}', [DireccionController::class, 'destroy'])->name('borrarDireccion');
});

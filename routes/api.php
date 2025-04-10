<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReferenciaController;
use App\Http\Controllers\DireccionController;
use App\Http\Controllers\ClasificacionController;
use App\Http\Controllers\ResiboController;
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

Route::prefix('clasificacion')->group(function(){
    Route::get('/mostrar', [ClasificacionController::class, 'index'])->name('mostrarClasificaciones');
    Route::get('/mostrar/{id}', [ClasificacionController::class, 'show'])->name('mostrarClasificacion');
    Route::post('/crear', [ClasificacionController::class, 'store'])->name('crearClasificacion');
    Route::put('/actualizar/{id}', [ClasificacionController::class, 'update'])->name('actualizarClasificacion');
    Route::delete('/borrar/{id}', [ClasificacionController::class, 'destroy'])->name('borrarClasificacion');
});

Route::prefix('recibo')->group(function(){
    Route::get('/mostrar', [ResiboController::class, 'index'])->name('mostrarResibos');
    Route::get('/mostrar/{id}', [ResiboController::class, 'show'])->name('mostrarResibo');
    Route::post('/crear', [ResiboController::class, 'store'])->name('crearResibo');
    Route::put('/actualizar/{id}', [ResiboController::class, 'update'])->name('actualizarResibo');
    Route::delete('/borrar/{id}', [ResiboController::class, 'destroy'])->name('borrarResibo');
});

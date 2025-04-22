<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReferenciaController;
use App\Http\Controllers\ClasificacionController;
use App\Http\Controllers\ReciboController;
use App\Http\Controllers\BarrioController;
use App\Http\Controllers\MunicipioController;
use App\Http\Controllers\DepartamentoController;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\CuotaController;
use App\Http\Controllers\InteresController;
use App\Http\Controllers\SaldosController;

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

Route::prefix('clasificacion')->group(function(){
    Route::get('/mostrar', [ClasificacionController::class, 'index'])->name('mostrarClasificaciones');
    Route::get('/mostrar/{id}', [ClasificacionController::class, 'show'])->name('mostrarClasificacion');
    Route::post('/crear', [ClasificacionController::class, 'store'])->name('crearClasificacion');
    Route::put('/actualizar/{id}', [ClasificacionController::class, 'update'])->name('actualizarClasificacion');
    Route::delete('/borrar/{id}', [ClasificacionController::class, 'destroy'])->name('borrarClasificacion');
});

Route::prefix('recibo')->group(function(){
    Route::get('/mostrar', [ReciboController::class, 'index'])->name('mostrarRecibos');
    Route::get('/mostrar/{id}', [ReciboController::class, 'show'])->name('mostrarRecibo');
    Route::post('/crear', [ReciboController::class, 'store'])->name('crearResibo');
    Route::put('/actualizar/{id}', [ReciboController::class, 'update'])->name('actualizarResibo');
    Route::delete('/borrar/{id}', [ReciboController::class, 'destroy'])->name('borrarResibo');
});

Route::prefix('cuota')->group(function(){
    Route::get('/mostrar', [CuotaController::class, 'index'])->name('mostrarCuotas');
    Route::get('/mostrar/{id}', [CuotaController::class, 'show'])->name('mostrarCuota');
    Route::post('/crear', [CuotaController::class, 'store'])->name('crearCuota');
    Route::put('/actualizar/{id}', [CuotaController::class, 'update'])->name('actualizarCuota');
    Route::delete('/borrar/{id}', [CuotaController::class, 'destroy'])->name('borrarCuota');
});

Route::prefix('interes')->group(function(){
    Route::get('/mostrar', [InteresController::class, 'index'])->name('mostrarIntereses');
    Route::get('/mostrar/{id}', [InteresController::class, 'show'])->name('mostrarInteres');
    Route::post('/crear', [InteresController::class, 'store'])->name('crearInteres');
    Route::put('/actualizar/{id}', [InteresController::class, 'update'])->name('actualizarInteres');
    Route::delete('/borrar/{id}', [InteresController::class, 'destroy'])->name('borrarInteres');
});

Route::prefix('saldos')->group(function(){
    Route::get('/mostrar', [SaldosController::class, 'index'])->name('mostrarSaldos');
    Route::get('/mostrar/{id}', [SaldosController::class, 'show'])->name('mostrarSaldo');
    Route::post('/crear', [SaldosController::class, 'store'])->name('crearSaldo');
    Route::put('/actualizar/{id}', [SaldosController::class, 'update'])->name('actualizarSaldo');
    Route::delete('/borrar/{id}', [SaldosController::class, 'destroy'])->name('borrarSaldo');
});

Route::prefix('barrio')->group(function(){
    Route::get('/mostrar', [BarrioController::class, 'index'])->name('mostrarBarrios');
    Route::get('/mostrar/{id}', [BarrioController::class, 'show'])->name('mostrarBarrio');
    Route::post('/crear', [BarrioController::class, 'store'])->name('crearBarrio');
    Route::put('/actualizar/{id}', [BarrioController::class, 'update'])->name('actualizarBarrio');
    Route::delete('/borrar/{id}', [BarrioController::class, 'destroy'])->name('borrarBarrio');
});

Route::prefix('municipio')->group(function(){
    Route::get('/mostrar', [MunicipioController::class, 'index'])->name('mostrarMunicipios');
    Route::get('/mostrar/{id}', [MunicipioController::class, 'show'])->name('mostrarMunicipio');
    Route::post('/crear', [MunicipioController::class, 'store'])->name('crearMunicipio');
    Route::put('/actualizar/{id}', [MunicipioController::class, 'update'])->name('actualizarMunicipio');
    Route::delete('/borrar/{id}', [MunicipioController::class, 'destroy'])->name('borrarMunicipio');
});

Route::prefix('departamento')->group(function(){
    Route::get('/mostrar', [DepartamentoController::class, 'index'])->name('mostrarDepartamentos');
    Route::get('/mostrar/{id}', [DepartamentoController::class, 'show'])->name('mostrarDepartamento');
    Route::post('/crear', [DepartamentoController::class, 'store'])->name('crearDepartamento');
    Route::put('/actualizar/{id}', [DepartamentoController::class, 'update'])->name('actualizarDepartamento');
    Route::delete('/borrar/{id}', [DepartamentoController::class, 'destroy'])->name('borrarDepartamento');
});
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ReferenciaApiController;
use App\Http\Controllers\Api\ClasificacionApiController;
use App\Http\Controllers\Api\ReciboApiController;
use App\Http\Controllers\Api\MunicipioApiController;
use App\Http\Controllers\Api\DepartamentoApiController;
use App\Http\Controllers\Api\MarcaApiController;
use App\Http\Controllers\Api\ProductoApiController;
use App\Http\Controllers\Api\ClienteApiController;
use App\Http\Controllers\Api\FechasApiController;
use App\Http\Controllers\Api\CreditoApiController;
use Illuminate\Support\Facades\Redis;
use App\Http\Controllers\Api\CuotaApiController;
use App\Http\Controllers\Api\InteresApiController;
use App\Http\Controllers\Api\SaldosApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('referenciasPersonales')->group(function(){
    Route::get('/referencias', [ReferenciaApiController::class, 'index'])->name('mostrarReferencias');
    Route::get('/referencia/{id}', [ReferenciaApiController::class, 'mostrarReferencia'])->name('mostrarReferencia');
    Route::post('/crear/referencia', [ReferenciaApiController::class, 'crearReferencia'])->name('crearReferencia');
    Route::put('/actualizar/referencia/{id}', [ReferenciaApiController::class, 'actualizarReferencia'])->name('actualizarReferencia');
    Route::delete('/eliminar/referencia/{id}', [ReferenciaApiController::class, 'eliminarReferencia'])->name('eliminarReferencia');
});

Route::prefix('clasificacion')->group(function(){
    Route::get('/mostrar', [ClasificacionApiController::class, 'index'])->name('mostrarClasificaciones');
    Route::get('/mostrar/{id}', [ClasificacionApiController::class, 'show'])->name('mostrarClasificacion');
    Route::post('/crear', [ClasificacionApiController::class, 'store'])->name('crearClasificacion');
    Route::put('/actualizar/{id}', [ClasificacionApiController::class, 'update'])->name('actualizarClasificacion');
    Route::delete('/borrar/{id}', [ClasificacionApiController::class, 'destroy'])->name('borrarClasificacion');
});

Route::prefix('recibo')->group(function(){
    Route::get('/mostrar', [ReciboApiController::class, 'index'])->name('mostrarApiRecibos');
    Route::get('/mostrar/{id}', [ReciboApiController::class, 'show'])->name('mostrarApiRecibo');
    Route::post('/crear', [ReciboApiController::class, 'store'])->name('crearApiRecibo');
    Route::put('/actualizar/{id}', [ReciboApiController::class, 'update'])->name('actualizarApiRecibo');
    Route::delete('/borrar/{id}', [ReciboApiController::class, 'destroy'])->name('borrarApiRecibo');
});

Route::prefix('cuota')->group(function(){
    Route::get('/mostrar', [CuotaApiController::class, 'index'])->name('mostrarCuotas');
    Route::get('/mostrar/{id}', [CuotaApiController::class, 'show'])->name('mostrarCuota');
    Route::post('/crear', [CuotaApiController::class, 'store'])->name('crearCuota');
    Route::put('/actualizar/{id}', [CuotaApiController::class, 'update'])->name('actualizarCuota');
    Route::delete('/borrar/{id}', [CuotaApiController::class, 'destroy'])->name('borrarCuota');
});

Route::prefix('interes')->group(function(){
    Route::get('/mostrar', [InteresApiController::class, 'index'])->name('mostrarIntereses');
    Route::get('/mostrar/{id}', [InteresApiController::class, 'show'])->name('mostrarInteres');
    Route::post('/crear', [InteresApiController::class, 'store'])->name('crearInteres');
    Route::put('/actualizar/{id}', [InteresApiController::class, 'update'])->name('actualizarInteres');
    Route::delete('/borrar/{id}', [InteresApiController::class, 'destroy'])->name('borrarInteres');
});

Route::prefix('saldos')->group(function(){
    Route::get('/mostrar', [SaldosApiController::class, 'index'])->name('mostrarSaldos');
    Route::get('/mostrar/{id}', [SaldosApiController::class, 'show'])->name('mostrarSaldo');
    Route::post('/crear', [SaldosApiController::class, 'store'])->name('crearSaldo');
    Route::put('/actualizar/{id}', [SaldosApiController::class, 'update'])->name('actualizarSaldo');
    Route::delete('/borrar/{id}', [SaldosApiController::class, 'destroy'])->name('borrarSaldo');
});

Route::prefix('municipio')->group(function(){
    Route::get('/mostrar', [MunicipioApiController::class, 'index'])->name('mostrarMunicipios');
    Route::get('/mostrar/{id}', [MunicipioApiController::class, 'show'])->name('mostrarMunicipio');
    Route::post('/crear', [MunicipioApiController::class, 'store'])->name('crearMunicipio');
    Route::put('/actualizar/{id}', [MunicipioApiController::class, 'update'])->name('actualizarMunicipio');
    Route::delete('/borrar/{id}', [MunicipioApiController::class, 'destroy'])->name('borrarMunicipio');
});

Route::prefix('departamento')->group(function(){
    Route::get('/mostrar', [DepartamentoApiController::class, 'index'])->name('mostrarDepartamentos');
    Route::get('/mostrar/{id}', [DepartamentoApiController::class, 'show'])->name('mostrarDepartamento');
    Route::post('/crear', [DepartamentoApiController::class, 'store'])->name('crearDepartamento');
    Route::put('/actualizar/{id}', [DepartamentoApiController::class, 'update'])->name('actualizarDepartamento');
    Route::delete('/borrar/{id}', [DepartamentoApiController::class, 'destroy'])->name('borrarDepartamento');
});

Route::prefix('marca')->group(function(){
    Route::get('/mostrar', [MarcaApiController::class, 'index'])->name('mostrarApiMarcas');
    Route::get('/mostrar/{id}', [MarcaApiController::class, 'show'])->name('mostrarApiMarca');
    Route::post('/crear', [MarcaApiController::class, 'store'])->name('crearApiMarca');
    Route::put('/actualizar/{id}', [MarcaApiController::class, 'update'])->name('actualizarApiMarca');
    Route::delete('/borrar/{id}', [MarcaApiController::class, 'destroy'])->name('borrarApiMarca');
});

Route::prefix('producto')->group(function(){
    Route::get('/mostrar', [ProductoApiController::class, 'index'])->name('mostrarApiProductos');
    Route::get('/mostrar/{id}', [ProductoApiController::class, 'show'])->name('mostrarApiProducto');
    Route::post('/crear', [ProductoApiController::class, 'store'])->name('crearApiProducto');
    Route::put('/actualizar/{id}', [ProductoApiController::class, 'update'])->name('actualizarApiProducto');
    Route::delete('/borrar/{id}', [ProductoApiController::class, 'destroy'])->name('borrarApiProducto');
});

Route::prefix('cliente')->group(function(){
    Route::get('/mostrar', [ClienteApiController::class, 'index'])->name('mostrarApiClientes');
    Route::get('/mostrar/{id}', [ClienteApiController::class, 'show'])->name('mostrarApiCliente');
    Route::post('/crear', [ClienteApiController::class, 'store'])->name('crearApiCliente');
    Route::put('/actualizar/{id}', [ClienteApiController::class, 'update'])->name('actualizarApiCliente');
    Route::delete('/borrar/{id}', [ClienteApiController::class, 'destroy'])->name('borrarApiCliente');
});

Route::prefix('fechas')->group(function(){
    Route::get('/mostrar', [FechasApiController::class, 'index'])->name('mostrarFechas');
    Route::get('/mostrar/{id}', [FechasApiController::class, 'show'])->name('mostrarFecha');
    Route::post('/crear', [FechasApiController::class, 'store'])->name('crearFecha');
    Route::put('/actualizar/{id}', [FechasApiController::class, 'update'])->name('actualizarFecha');
    Route::delete('/borrar/{id}', [FechasApiController::class, 'destroy'])->name('borrarFecha');
});

Route::prefix('credito')->group(function(){
    Route::get('/mostrar', [CreditoApiController::class, 'index'])->name('mostrarApiCreditos');
    Route::get('/mostrar/{id}', [CreditoApiController::class, 'show'])->name('mostrarApiCredito');
    Route::post('/crear', [CreditoApiController::class, 'store'])->name('crearApiCredito');
    Route::put('/actualizar/{id}', [CreditoApiController::class, 'update'])->name('actualizarApiCredito');
    Route::delete('/borrar/{id}', [CreditoApiController::class, 'destroy'])->name('borrarApiCredito');
});

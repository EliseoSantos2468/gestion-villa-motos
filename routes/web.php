<?php

use App\Http\Controllers\ClienteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ReciboController;
use App\Http\Controllers\CreditoController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Auth;

// Muestra la vista de login
Route::get('/', function () {
    return view('Auth.login');
})->name('login');

// Muestra la vista de registro
Route::get('/register', function () {
    return view('Auth.register');
})->name('register');

// Procesa el formulario de registro
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

// Procesa el formulario de login
Route::post('/login', [LoginController::class, 'login'])->name('login.post');

// Cierra la sesión y redirige al login
Route::get('/logout', function () {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');

// Rutas protegidas (requieren autenticación)
Route::middleware('auth')->prefix('inicio')->group(function () {

    Route::get('/escritorio', [ReciboController::class, 'indexEscritorio'])->name('inicio.escritorio');

    Route::prefix('cliente')->group(function(){
        Route::get('/mostrar', [ClienteController::class, 'index'])->name('mostrarClientes');
        Route::get('/mostrar/{id}', [ClienteController::class, 'show'])->name('mostrarCliente');
        Route::post('/crear', [ClienteController::class, 'store'])->name('crearCliente');
        Route::get('/actualizarForm/{id}', [ClienteController::class, 'updateForm'])->name('actualizarClientevista');
        Route::put('/actualizar/{id}', [ClienteController::class, 'update'])->name('actualizarCliente');
        Route::delete('/borrar/{id}', [ClienteController::class, 'destroy'])->name('borrarCliente');
    });

    Route::prefix('recibo')->group(function(){
        Route::get('/mostrar', [ReciboController::class, 'index'])->name('mostrarRecibos');
        Route::get('/recibo/{id}/pdf', [ReciboController::class, 'generarPDF'])->name('recibo.pdf');
        Route::get('/venta', [ReciboController::class, 'indexVenta'])->name('nuevaVenta');  
        Route::get('/mostrar/{id}', [ReciboController::class, 'show'])->name('mostrarRecibo');
        Route::post('/crear', [ReciboController::class, 'store'])->name('crearRecibo');
        Route::put('/actualizar/{id}', [ReciboController::class, 'update'])->name('actualizarRecibo');
        Route::delete('/borrar/{id}', [ReciboController::class, 'destroy'])->name('borrarRecibo');
    });

    Route::get('/creditos', function () {
        return view('gestion.creditos');
    })->name('inicio.creditos');

    Route::prefix('credito')->group(function(){
        Route::get('/mostrar', [CreditoController::class, 'index'])->name('mostrarCreditos');
        Route::get('/mostrar/{id}', [CreditoController::class, 'show'])->name('mostrarCredito');
        Route::post('/credito/{id}/pagar-cuota', [CreditoController::class, 'pagarCuota'])->name('pagar.cuota');
        Route::post('/crear', [CreditoController::class, 'store'])->name('crearCredito');
        Route::put('/actualizar/{id}', [CreditoController::class, 'update'])->name('actualizarCredito');
        Route::delete('/borrar/{id}', [CreditoController::class, 'destroy'])->name('borrarCredito');
    });

    Route::get('/soporte', function () {
        return view('gestion.soporte');
    })->name('inicio.soporte');

    Route::get('/reportes', function () {
        return view('gestion.reportes');
    })->name('inicio.reportes');

    Route::prefix('producto')->group(function(){
        Route::get('/mostrar', [ProductoController::class, 'index'])->name('mostrarProductos');
        Route::get('/mostrar/{id}', [ProductoController::class, 'show'])->name('mostrarProducto');
        Route::post('/crear', [ProductoController::class, 'store'])->name('crearProducto');
        Route::get('/actualizarForm/{id}', [ProductoController::class, 'updateForm'])->name('actualizarProductovista');
        Route::put('/actualizar/{id}', [ProductoController::class, 'update'])->name('actualizarProducto');
        Route::delete('/borrar/{id}', [ProductoController::class, 'destroy'])->name('borrarProducto');
    });

    Route::prefix('marca')->group(function(){
        Route::get('/mostrar', [MarcaController::class, 'index'])->name('mostrarMarcas');
        Route::get('/mostrar/{id}', [MarcaController::class, 'show'])->name('mostrarMarca');
        Route::post('/crear', [MarcaController::class, 'store'])->name('crearMarca');
        Route::put('/actualizar/{id}', [MarcaController::class, 'update'])->name('actualizarMarca');
        Route::delete('/borrar/{id}', [MarcaController::class, 'destroy'])->name('borrarMarca');
    });

    Route::get('/perfil', function () {
        return view('gestion.perfil');
    })->name('inicio.perfil');
});

<?php

use App\Http\Controllers\ClienteController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ProductoController;
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
    Route::get('/escritorio', function () {
        return view('gestion.escritorio');
    })->name('inicio.escritorio');

    Route::prefix('cliente')->group(function(){
        Route::get('/mostrar', [ClienteController::class, 'index'])->name('mostrarClientes');
        Route::get('/mostrar/{id}', [ClienteController::class, 'show'])->name('mostrarCliente');
        Route::post('/crear', [ClienteController::class, 'store'])->name('crearCliente');
        Route::get('/actualizarForm/{id}', [ClienteController::class, 'updateForm'])->name('actualizarClientevista');
        Route::put('/actualizar/{id}', [ClienteController::class, 'update'])->name('actualizarCliente');
        Route::delete('/borrar/{id}', [ClienteController::class, 'destroy'])->name('borrarCliente');
    });

    Route::get('/ventas', function () {
        return view('gestion.ventas');
    })->name('inicio.ventas');

    Route::get('/ventas/nueva', function () {
        return view('gestion.venta_nueva');
    })->name('inicio.ventas.nueva');

    Route::get('/creditos', function () {
        return view('gestion.creditos');
    })->name('inicio.creditos');

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

    Route::get('/perfil', function () {
        return view('gestion.perfil');
    })->name('inicio.perfil');
});

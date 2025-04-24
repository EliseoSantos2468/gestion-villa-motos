<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Auth;

// Ruta principal
Route::get('/', function () {
    return view('auth.login');
});

Route::get('/register', function () {
    return view('Auth.register');
})->name('register');

Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::get('/logout', function () {
    Auth::logout();
    return redirect()->route('login');
})->name('logout');

// Rutas protegidas (requieren autenticación)
// middleware('auth')->
Route::prefix('inicio')->group(function () {
    Route::get('/escritorio', function () {
        return view('gestion.escritorio');
    })->name('inicio.escritorio');

    Route::get('/clientes', function () {
        return view('gestion.clientes');
    })->name('inicio.clientes');

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

    Route::get('/kardex', function () {
        return view('gestion.kardex');
    })->name('inicio.kardex');

    Route::get('/perfil', function () {
        return view('gestion.perfil');
    })->name('inicio.perfil');
});

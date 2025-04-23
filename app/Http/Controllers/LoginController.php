<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); // Asegúrate que esta vista exista
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/inicio/escritorio'); // Redirige a la ruta deseada después del login
        }

        // Si falla, vuelve al login con error
        return back()->withErrors([
            'email' => 'Las credenciales no son válidas.',
        ])->withInput($request->only('email'));
    }
}

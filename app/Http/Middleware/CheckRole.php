<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Maneja una solicitud entrante.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  mixed  ...$roles
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // Si no está autenticado, redirige al login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Si el usuario tiene el rol permitido
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // Si el usuario no tiene permiso
        abort(403, 'No tienes permiso para acceder a esta página');
    }
}

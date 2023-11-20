<?php

namespace App\Http\Middleware;

use Closure;

class ShareUserData
{
    public function handle($request, Closure $next)
    {
        // Compartir el usuario autenticado con todas las vistas
        view()->share('user', auth()->user());

        return $next($request);
    }
}


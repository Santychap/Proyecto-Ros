<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRol
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, $rol)
    {
        if (auth()->check() && auth()->user()->rol === $rol) {
            return $next($request);
        }

        abort(403, 'No tienes permiso para acceder a esta página.');
    }
}

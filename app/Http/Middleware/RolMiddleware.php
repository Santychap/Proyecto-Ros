<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RolMiddleware
{
    public function handle(Request $request, Closure $next, $rol): Response
    {
        if (auth()->check() && auth()->user()->hasRole($rol)) {
            return $next($request);
        }

        abort(403, 'No autorizado');
    }
}

<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRestauranteHorario
{
    public function handle(Request $request, Closure $next)
    {
        $horaActual = now()->format('H:i');
        $apertura = config('restaurante.horario_apertura', '08:00');
        $cierre = config('restaurante.horario_cierre', '22:00');

        if ($horaActual < $apertura || $horaActual > $cierre) {
            return redirect()->route('home')->with('error', 'El restaurante está cerrado');
        }

        return $next($request);
    }
}
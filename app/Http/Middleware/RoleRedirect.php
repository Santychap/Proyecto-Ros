<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleRedirect
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        // Solo aplicar si el usuario está autenticado
        if (auth()->check()) {
            $user = auth()->user();
            $currentRoute = $request->route()->getName();
            $currentPath = $request->path();
            
            // Rutas públicas que los empleados NO pueden acceder
            $publicRoutes = ['/', 'menu', 'reservas-web', 'noticias-web', 'promociones-web', 'carrito'];
            $publicRouteNames = ['menu.index', 'noticias.publicIndex', 'promociones.publicIndex', 'reservas.publicIndex', 'carrito.index'];
            
            // Si es empleado intentando acceder a páginas públicas
            if ($user->rol === 'empleado') {
                if (in_array($currentPath, $publicRoutes) || in_array($currentRoute, $publicRouteNames)) {
                    return redirect()->route('dashboard')->with('warning', 'Acceso restringido. Como empleado, solo puedes usar el panel administrativo.');
                }
            }
        }
        
        return $next($request);
    }
}
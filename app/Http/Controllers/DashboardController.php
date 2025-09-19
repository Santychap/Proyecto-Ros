<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserva;
use App\Models\Pedido;
use App\Models\User;
use App\Models\Mesa;
use App\Models\Producto;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Redirigir según el rol del usuario
        switch ($user->rol) {
            case 'admin':
                return $this->adminDashboard();
            case 'empleado':
                return $this->empleadoDashboard();
            case 'cliente':
                // Los clientes van directo a la página principal
                return redirect()->route('home');
            default:
                return view('dashboard'); // Dashboard genérico
        }
    }
    
    private function adminDashboard()
    {
        // Estadísticas para el admin
        $totalReservasHoy = Reserva::whereDate('fecha', today())->count();
        $totalPedidosHoy = Pedido::whereDate('created_at', today())->count();
        $totalClientes = User::where('rol', 'cliente')->count();
        $totalEmpleados = User::where('rol', 'empleado')->count();
        $totalProductos = Producto::count();
        $mesasDisponibles = Mesa::count();
        
        // Datos para gráfica de reservas últimos 7 días
        $labels = [];
        $data = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = today()->subDays($i);
            $labels[] = $date->format('d/m');
            $data[] = Reserva::whereDate('fecha', $date)->count();
        }
        
        // Reservas recientes
        $reservasRecientes = Reserva::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        // Pedidos recientes
        $pedidosRecientes = Pedido::with('user')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        
        return view('dashboards.admin', compact(
            'totalReservasHoy',
            'totalPedidosHoy', 
            'totalClientes',
            'totalEmpleados',
            'totalProductos',
            'mesasDisponibles',
            'labels',
            'data',
            'reservasRecientes',
            'pedidosRecientes'
        ));
    }
    
    private function empleadoDashboard()
    {
        $empleado = auth()->user();
        
        // Pedidos asignados al empleado
        $pedidosAsignados = Pedido::where('empleado_id', $empleado->id)
            ->whereIn('estado', ['pendiente', 'en_preparacion'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
            
        // Estadísticas del empleado
        $pedidosHoy = Pedido::where('empleado_id', $empleado->id)
            ->whereDate('created_at', today())
            ->count();
            
        $pedidosCompletados = Pedido::where('empleado_id', $empleado->id)
            ->where('estado', 'completado')
            ->count();
        
        return view('dashboards.empleado', compact(
            'pedidosAsignados',
            'pedidosHoy',
            'pedidosCompletados'
        ));
    }

}
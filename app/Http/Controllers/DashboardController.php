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
        
        switch ($user->rol) {
            case 'admin':
                return $this->adminDashboard();
            case 'empleado':
                return $this->empleadoDashboard();
            case 'cliente':
                return $this->clienteDashboard();
            default:
                // Si no tiene rol definido, asignar cliente por defecto
                $user->update(['rol' => 'cliente']);
                return $this->clienteDashboard();
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
        $pedidosRecientes = Pedido::with(['user', 'detalles.producto', 'pago'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        // Calcular total para cada pedido
        foreach($pedidosRecientes as $pedido) {
            $total = 0;
            foreach($pedido->detalles as $detalle) {
                $total += $detalle->producto->precio * $detalle->cantidad;
            }
            $pedido->total = $total;
        }
        
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
            ->whereIn('estado', ['Pendiente', 'En Proceso'])
            ->with(['detalles.producto', 'user', 'pago'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();
            
        // Estadísticas del empleado
        $pedidosHoy = Pedido::where('empleado_id', $empleado->id)
            ->whereDate('created_at', today())
            ->count();
            
        $pedidosCompletados = Pedido::where('empleado_id', $empleado->id)
            ->where('estado', 'Completado')
            ->count();
        
        return view('dashboards.empleado', compact(
            'pedidosAsignados',
            'pedidosHoy',
            'pedidosCompletados'
        ));
    }
    
    public function empleado()
    {
        return $this->empleadoDashboard();
    }
    
    private function clienteDashboard()
    {
        $cliente = auth()->user();
        
        // Estadísticas del cliente
        $misReservas = Reserva::where('user_id', $cliente->id)->count();
        $misPedidos = Pedido::where('user_id', $cliente->id)->count();
        $reservasActivas = Reserva::where('user_id', $cliente->id)
            ->where('fecha', '>=', today())
            ->count();
        $pedidosPendientes = Pedido::where('user_id', $cliente->id)
            ->whereIn('estado', ['pendiente', 'en_preparacion'])
            ->count();
            
        // Mis reservas recientes
        $misReservasRecientes = Reserva::where('user_id', $cliente->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        // Mis pedidos recientes
        $misPedidosRecientes = Pedido::where('user_id', $cliente->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
            
        // Productos disponibles (para mostrar en el dashboard)
        $productosDisponibles = Producto::take(6)->get();
        
        return view('dashboards.cliente', compact(
            'misReservas',
            'misPedidos',
            'reservasActivas',
            'pedidosPendientes',
            'misReservasRecientes',
            'misPedidosRecientes',
            'productosDisponibles'
        ));
    }

}
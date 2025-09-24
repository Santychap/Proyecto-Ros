<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Pedido;
use App\Models\Producto;
use App\Models\User;
use App\Models\Reserva;
use App\Models\Mesa;
use App\Models\Categoria;
use Carbon\Carbon;

class ReporteController extends Controller
{
    public function index()
    {
        // Solo permitir acceso a administradores
        if (Auth::user()->rol !== 'admin') {
            abort(403, 'No autorizado');
        }
        return view('reportes.index');
    }

    public function descargarPDF($tipo)
    {
        if (Auth::user()->rol !== 'admin') {
            abort(403, 'No autorizado');
        }

        $data = $this->obtenerDatosReporte($tipo);
        
        $pdf = Pdf::loadView('reportes.pdf', compact('data', 'tipo'));
        
        return $pdf->download('reporte-' . $tipo . '-' . date('Y-m-d') . '.pdf');
    }

    public function mostrarReporteIndividual($tipo)
    {
        if (Auth::user()->rol !== 'admin') {
            abort(403, 'No autorizado');
        }

        $data = $this->obtenerDatosModulo($tipo);
        return view('reportes.individual', compact('data', 'tipo'));
    }

    private function obtenerDatosModulo($tipo)
    {
        switch ($tipo) {
            case 'reservas':
                $reservas = Reserva::with('user')->get();
                return [
                    'titulo' => 'Reporte de Reservas',
                    'reservas' => $reservas,
                    'total_reservas' => $reservas->count(),
                    'reservas_hoy' => Reserva::whereDate('fecha', Carbon::today())->count(),
                    'reservas_mes' => Reserva::whereMonth('fecha', Carbon::now()->month)->count()
                ];
            case 'pedidos':
                $pedidos = Pedido::with('user')->get();
                return [
                    'titulo' => 'Reporte de Pedidos',
                    'pedidos' => $pedidos,
                    'total_pedidos' => $pedidos->count(),
                    'pedidos_pendientes' => $pedidos->where('estado', 'pendiente')->count(),
                    'pedidos_completados' => $pedidos->where('estado', 'completado')->count()
                ];
            case 'ventas':
                $pedidos = Pedido::with('user')->get();
                return [
                    'titulo' => 'Reporte de Ventas por Período',
                    'pedidos' => $pedidos,
                    'total_ventas' => $pedidos->sum('total'),
                    'promedio_venta' => $pedidos->avg('total'),
                    'ventas_mes' => $pedidos->sum('total')
                ];
            case 'horarios':
                return [
                    'titulo' => 'Reporte de Horarios Pico',
                    'pedidos_por_hora' => Pedido::selectRaw('HOUR(created_at) as hora, COUNT(*) as total')
                        ->groupBy('hora')
                        ->orderBy('hora')
                        ->get()
                ];
            case 'usuarios':
                $usuarios = User::all();
                return [
                    'titulo' => 'Reporte de Usuarios',
                    'usuarios' => $usuarios,
                    'total_usuarios' => $usuarios->count(),
                    'usuarios_activos' => $usuarios->where('estado', 'activo')->count(),
                    'usuarios_inactivos' => $usuarios->where('estado', 'inactivo')->count(),
                    'clientes' => $usuarios->where('rol', 'cliente')->count(),
                    'empleados' => $usuarios->where('rol', 'empleado')->count(),
                    'administradores' => $usuarios->where('rol', 'admin')->count(),
                    'registros_mes' => User::whereMonth('created_at', Carbon::now()->month)->count()
                ];
            case 'financiero':
                $pedidos = Pedido::all();
                return [
                    'titulo' => 'Reporte de Análisis Financiero',
                    'ingresos_totales' => $pedidos->sum('total'),
                    'pedidos_mes' => Pedido::whereMonth('created_at', Carbon::now()->month)->get(),
                    'promedio_mensual' => $pedidos->sum('total') / max(1, Carbon::now()->month),
                    'ingresos_diarios' => $pedidos->sum('total') / max(1, Carbon::now()->day)
                ];
            default:
                return ['titulo' => 'Reporte', 'error' => 'Tipo de reporte no válido'];
        }
    }

    private function obtenerDatosReporte($tipo)
    {
        switch ($tipo) {
            case 'general':
                $pedidos = Pedido::all();
                return [
                    'titulo' => 'Reporte General - Todos los Módulos',
                    'pedidos_total' => $pedidos->count(),
                    'ingresos_total' => $pedidos->sum('total'),
                    'clientes_total' => User::where('rol', 'cliente')->count(),
                    'empleados_total' => User::whereIn('rol', ['admin', 'empleado'])->count(),
                    'productos_total' => Producto::count(),
                    'categorias_total' => Categoria::count(),
                    'reservas_total' => Reserva::count(),
                    'reservas_hoy' => Reserva::whereDate('fecha', Carbon::today())->count(),
                    'mesas_total' => Mesa::count(),
                    'mesas_disponibles' => Mesa::count(), // Asumiendo que todas están disponibles por defecto
                    'pedidos_pendientes' => Pedido::where('estado', 'pendiente')->count(),
                    'pedidos_completados' => Pedido::where('estado', 'completado')->count()
                ];
            
            case 'diario':
                $hoy = Carbon::today();
                $pedidos = Pedido::whereDate('created_at', $hoy)->get();
                return [
                    'titulo' => 'Reporte General Diario - Todos los Módulos',
                    'fecha' => $hoy->format('d/m/Y'),
                    'pedidos' => $pedidos,
                    'pedidos_total' => $pedidos->count(),
                    'total_ingresos' => $pedidos->sum('total'),
                    'reservas_hoy' => Reserva::whereDate('fecha', $hoy)->count(),
                    'usuarios_registrados_hoy' => User::whereDate('created_at', $hoy)->count(),
                    'clientes_total' => User::where('rol', 'cliente')->count(),
                    'empleados_total' => User::whereIn('rol', ['admin', 'empleado'])->count(),
                    'productos_total' => Producto::count(),
                    'categorias_total' => Categoria::count(),
                    'mesas_total' => Mesa::count()
                ];
            
            case 'semanal':
                $inicioSemana = Carbon::now()->startOfWeek();
                $finSemana = Carbon::now()->endOfWeek();
                $pedidos = Pedido::whereBetween('created_at', [$inicioSemana, $finSemana])->get();
                return [
                    'titulo' => 'Reporte General Semanal - Todos los Módulos',
                    'periodo' => $inicioSemana->format('d/m/Y') . ' - ' . $finSemana->format('d/m/Y'),
                    'pedidos' => $pedidos,
                    'pedidos_total' => $pedidos->count(),
                    'total_ingresos' => $pedidos->sum('total'),
                    'reservas_semana' => Reserva::whereBetween('fecha', [$inicioSemana, $finSemana])->count(),
                    'usuarios_registrados_semana' => User::whereBetween('created_at', [$inicioSemana, $finSemana])->count(),
                    'clientes_total' => User::where('rol', 'cliente')->count(),
                    'empleados_total' => User::whereIn('rol', ['admin', 'empleado'])->count(),
                    'productos_total' => Producto::count(),
                    'categorias_total' => Categoria::count(),
                    'mesas_total' => Mesa::count()
                ];
            
            case 'mensual':
                $inicioMes = Carbon::now()->startOfMonth();
                $finMes = Carbon::now()->endOfMonth();
                $pedidos = Pedido::whereBetween('created_at', [$inicioMes, $finMes])->get();
                return [
                    'titulo' => 'Reporte General Mensual - Todos los Módulos',
                    'periodo' => $inicioMes->format('d/m/Y') . ' - ' . $finMes->format('d/m/Y'),
                    'pedidos' => $pedidos,
                    'pedidos_total' => $pedidos->count(),
                    'total_ingresos' => $pedidos->sum('total'),
                    'reservas_mes' => Reserva::whereBetween('fecha', [$inicioMes, $finMes])->count(),
                    'usuarios_registrados_mes' => User::whereBetween('created_at', [$inicioMes, $finMes])->count(),
                    'clientes_total' => User::where('rol', 'cliente')->count(),
                    'empleados_total' => User::whereIn('rol', ['admin', 'empleado'])->count(),
                    'productos_total' => Producto::count(),
                    'categorias_total' => Categoria::count(),
                    'mesas_total' => Mesa::count()
                ];
            
            default:
                return ['titulo' => 'Reporte', 'error' => 'Tipo de reporte no válido'];
        }
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Pedido;
use App\Models\DetallePedido;
use App\Models\User;
use Illuminate\Http\Request;

class PedidoController extends Controller
{
    // Confirmar pedido (Cliente)
    public function store(Request $request)
    {
        $user = auth()->user();
        $carrito = session('carrito', []);

        if (empty($carrito)) {
            return redirect()->route('carrito.mostrar')->with('error', 'Tu carrito está vacío');
        }

        // Asignación automática de empleado disponible (máximo 2 pedidos por empleado)
        $empleadoDisponible = User::where('rol', 'empleado')
            ->withCount(['pedidos as pedidos_activos_count' => function($query) {
                $query->whereIn('estado', ['Pendiente', 'En Proceso']);
            }])
            ->having('pedidos_activos_count', '<', 2)
            ->orderBy('pedidos_activos_count')
            ->first();

        $pedido = Pedido::create([
            'user_id'      => $user->id,
            'estado'       => 'Pendiente',
            'comentario'   => $request->comentario,
            'empleado_id'  => $empleadoDisponible ? $empleadoDisponible->id : null,
        ]);

        foreach ($carrito as $productoId => $item) {
            $pedido->detalles()->create([
                'producto_id' => $productoId,
                'cantidad'    => $item['cantidad'],
            ]);
        }

        session()->forget('carrito');

        return redirect()->route('pedidos.confirmacion', ['pedido' => $pedido->id]);
    }

    // Página de confirmación del pedido (Cliente)
    public function confirmacion(Pedido $pedido)
    {
        $user = auth()->user();

        // Validar que el pedido sea del usuario o abortar
        if ($pedido->user_id !== $user->id) {
            abort(403);
        }

        // Calcular si puede cancelar (10 minutos)
        $puedeCancelar = false;
        $ahora = now();
        $creadoEn = $pedido->created_at;
        $diferencia = $ahora->diffInMinutes($creadoEn);

        if ($pedido->estado === 'Pendiente' && $diferencia <= 10) {
            $puedeCancelar = true;
        }

        // Cargar detalles con productos
        $pedido->load('detalles.producto');

        // Calcular total
        $total = 0;
        foreach ($pedido->detalles as $detalle) {
            $total += $detalle->producto->precio * $detalle->cantidad;
        }

        return view('pedidos.confirmacion', compact('pedido', 'puedeCancelar', 'total'));
    }

    // Ver pedidos según el rol y búsqueda para admin y clientes, con filtro por estado
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Pedido::query()->with('detalles.producto', 'user', 'empleado');

        // Aplicar filtro de estado si viene en la request
        if ($request->filled('estado')) {
            $query->where('estado', $request->input('estado'));
        }

        if ($user->rol === 'admin') {
            // Búsqueda por cliente, estado o fecha
            if ($request->filled('search')) {
                $search = $request->input('search');

                $query->where(function ($q) use ($search) {
                    $q->whereHas('user', function($q2) use ($search) {
                        $q2->where('name', 'like', "%$search%");
                    })
                    ->orWhere('estado', 'like', "%$search%")
                    ->orWhereDate('created_at', $search);
                });
            }

            $pedidos = $query->latest()->get();

        } elseif ($user->rol === 'empleado') {
            // Los empleados ven solo pedidos de hoy asignados a ellos
            $pedidos = $query->whereDate('created_at', now()->toDateString())
                  ->where('empleado_id', $user->id)
                  ->with(['detalles.producto', 'empleado'])
                  ->get();
                  
            // Debug: Forzar recarga de relaciones
            foreach($pedidos as $pedido) {
                $pedido->load(['detalles.producto', 'empleado']);
            }

        } else {
            // Clientes ven solo sus pedidos
            $query->where('user_id', $user->id);

            $pedidos = $query->latest()->get();
        }

        if ($user->rol === 'empleado') {
            return view('pedidos.empleado', compact('pedidos'));
        } elseif ($user->rol === 'cliente') {
            return view('pedidos.cliente', compact('pedidos'));
        } else {
            return view('pedidos.index', compact('pedidos'));
        }
    }

    // HISTORIAL (solo para admin)
    public function historial()
    {
        $user = auth()->user();

        if ($user->rol !== 'admin') {
            abort(403);
        }

        $pedidos = Pedido::with('detalles.producto', 'user', 'empleado')
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('pedidos.historial', compact('pedidos'));
    }

    // CLIENTE: Cancelar pedido (solo dentro de los 10 minutos y estado Pendiente)
    public function cancelar(Pedido $pedido)
    {
        $user = auth()->user();

        if ($user->rol !== 'cliente' || $pedido->user_id !== $user->id) {
            abort(403);
        }

        if ($pedido->estado !== 'Pendiente') {
            return back()->with('error', 'No se puede cancelar este pedido.');
        }

        // Verificar límite de tiempo (10 minutos)
        $ahora = now();
        $creadoEn = $pedido->created_at;
        $diferencia = $ahora->diffInMinutes($creadoEn);

        if ($diferencia > 10) {
            return back()->with('error', 'El tiempo para cancelar el pedido ha expirado.');
        }

        $pedido->update(['estado' => 'Cancelado']);

        return redirect()->route('pedidos.index')->with('success', 'Pedido cancelado correctamente.');
    }

    // ADMIN y EMPLEADO: Actualizar estado del pedido
    public function actualizarEstado(Request $request, Pedido $pedido)
    {
        $user = auth()->user();

        if (!in_array($user->rol, ['admin', 'empleado'])) {
            abort(403);
        }

        $request->validate([
            'estado' => 'required|in:Pendiente,Pagado,Cancelado',
        ]);

        // Si el estado cambia a Pagado, crear o actualizar el pago
        if ($request->estado === 'Pagado') {
            if ($pedido->pago) {
                // Si ya existe un pago, actualizar su estado
                $pedido->pago->update(['estado' => 'pagado']);
            } else {
                // Si no existe pago, crear uno nuevo
                $pago = \App\Models\Pago::create([
                    'pedido_id' => $pedido->id,
                    'user_id' => $pedido->user_id,
                    'monto' => $pedido->total,
                    'metodo' => 'efectivo',
                    'estado' => 'pagado',
                    'fecha_pago' => now()
                ]);
                
                // Crear detalle del pago con información del registrador
                $datosPago = $user->rol === 'admin' 
                    ? 'Pago registrado manualmente por admin'
                    : 'Pago registrado por empleado: ' . $user->name;
                    
                \App\Models\DetallePago::create([
                    'pago_id' => $pago->id,
                    'descripcion' => 'Pago confirmado por ' . $user->rol,
                    'monto' => $pedido->total,
                    'datos_pago' => $datosPago
                ]);
            }
        }

        $pedido->update(['estado' => $request->estado]);

        return back()->with('success', 'Estado del pedido actualizado correctamente.');
    }

    // Admin cancela pedido (solo admin, estados Pendiente o Pagado)
    public function adminCancelar(Pedido $pedido)
    {
        $user = auth()->user();

        if ($user->rol !== 'admin') {
            abort(403);
        }

        if (!in_array($pedido->estado, ['Pendiente', 'Pagado'])) {
            return back()->with('error', 'No se puede cancelar este pedido en su estado actual.');
        }

        $pedido->update(['estado' => 'Cancelado']);

        return back()->with('success', 'Pedido cancelado por el administrador.');
    }

    // Eliminar pedido (solo admin)
    public function destroy(Pedido $pedido)
    {
        $user = auth()->user();

        if ($user->rol !== 'admin') {
            abort(403);
        }

        // Eliminar detalles del pedido primero
        $pedido->detalles()->delete();
        
        // Eliminar pagos relacionados si existen
        $pedido->pagos()->delete();
        
        // Eliminar el pedido
        $pedido->delete();

        return back()->with('success', 'Pedido eliminado correctamente.');
    }

    // Vaciar todos los pedidos (solo admin)
    public function vaciarTodos()
    {
        $user = auth()->user();

        if ($user->rol !== 'admin') {
            abort(403);
        }

        try {
            // Eliminar en el orden correcto para respetar las claves foráneas
            DetallePedido::query()->delete();
            Pago::query()->delete();
            Pedido::query()->delete();

            return back()->with('success', 'Todos los pedidos han sido eliminados correctamente.');
        } catch (\Exception $e) {
            return back()->with('error', 'Error al eliminar los pedidos: ' . $e->getMessage());
        }
    }
    public function pendientes()
    {
        $user = auth()->user();
        
        if (!in_array($user->rol, ['admin', 'empleado'])) {
            abort(403);
        }

        $pedidosPendientes = Pedido::with(['user', 'detalles.producto', 'pago'])
            ->whereHas('pago', function($query) {
                $query->where('estado', 'pendiente');
            })
            ->orWhereDoesntHave('pago')
            ->get();

        return view('pedidos.pendientes', compact('pedidosPendientes'));
    }
}


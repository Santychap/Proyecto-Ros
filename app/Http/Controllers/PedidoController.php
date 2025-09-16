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

        // Asignación automática de empleado (puedes mejorar con lógica de carga)
        $empleadoDisponible = User::where('rol', 'empleado')->first();

        $pedido = Pedido::create([
            'user_id'      => $user->id,
            'estado'       => 'Pendiente', // Pedido comienza como pendiente
            'comentario'   => $request->comentario,
            'empleado_id'  => $empleadoDisponible ? $empleadoDisponible->id : null,
        ]);

        $carrito = session('carrito', []);

        foreach ($carrito as $productoId => $item) {
            $pedido->detalles()->create([
                'producto_id' => $productoId,
                'cantidad'    => $item['cantidad'],
            ]);
        }

        session()->forget('carrito');

        // Redirigimos a confirmacion pasandole el id del pedido
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

    // Ver pedidos según el rol y búsqueda para admin y clientes
    public function index(Request $request)
    {
        $user = auth()->user();
        $query = Pedido::query()->with('detalles.producto', 'user', 'empleado');

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
            $pedidos = $query->whereDate('created_at', now()->toDateString())
                ->where('empleado_id', $user->id)
                ->get();

        } else {
            // Cliente ve solo sus pedidos, sin botones de acción, solo historial
            $pedidos = $query->where('user_id', $user->id)
                ->latest()
                ->get();
        }

        return view('pedidos.index', compact('pedidos'));
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

    // ADMIN y EMPLEADO: Actualizar estado (solo Pendiente a Pagado)
    public function actualizarEstado(Request $request, Pedido $pedido)
    {
        $user = auth()->user();

        if (!in_array($user->rol, ['admin', 'empleado'])) {
            abort(403);
        }

        $request->validate([
            'estado' => 'required|in:Pendiente,Pagado',
        ]);

        // Solo puede cambiar si el estado actual es Pendiente y se quiere poner en Pagado
        if ($pedido->estado !== 'Pendiente' || $request->estado !== 'Pagado') {
            return back()->with('error', 'No es posible cambiar el estado del pedido.');
        }

        // Actualizar el estado a Pagado
        $pedido->update(['estado' => 'Pagado']);

        // Crear registro en pagos
        Pago::create([
            'pedido_id' => $pedido->id,
            'user_id' => $user->id,  // Usuario que hace el cambio (admin o empleado)
            'monto' => $pedido->total ?? 0, // Asegúrate que el modelo Pedido tiene la propiedad total o calcula
            'metodo' => 'efectivo', // Método genérico para este caso
            'datos_pago' => 'Pago registrado manualmente por ' . $user->rol,
            'fecha_pago' => now(),
        ]);

        return back()->with('success', 'Estado del pedido actualizado a Pagado y pago registrado correctamente.');
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
}

<?php

namespace App\Http\Controllers;

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

        return redirect()->route('pedidos.confirmacion')->with('success', 'Pedido confirmado con éxito');
    }

    // Página de confirmación
    public function confirmacion()
    {
        return view('pedidos.confirmacion');
    }

    // Ver pedidos según el rol y búsqueda para admin
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

    // CLIENTE: Cancelar pedido
    public function cancelar(Pedido $pedido)
    {
        $user = auth()->user();

        if ($user->rol !== 'cliente' || $pedido->user_id !== $user->id) {
            abort(403);
        }

        if ($pedido->estado !== 'Pendiente') {
            return back()->with('error', 'No se puede cancelar este pedido.');
        }

        $pedido->update(['estado' => 'Cancelado']);

        return back()->with('success', 'Pedido cancelado correctamente.');
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

        $pedido->update(['estado' => 'Pagado']);

        return back()->with('success', 'Estado del pedido actualizado a Pagado.');
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

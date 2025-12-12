<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Pedido;
use Illuminate\Http\Request;

class PagoController extends Controller
{
    // Vista específica para administradores
    public function admin()
    {
        $user = auth()->user();
        
        if ($user->rol !== 'admin') {
            return redirect()->route('pagos.index');
        }
        
        $query = Pago::with(['pedido.user', 'user'])->latest();
        
        // Filtro por estado
        if (request('estado')) {
            $query->where('estado', request('estado'));
        }
        
        // Filtro por fecha
        if (request('fecha')) {
            $query->whereDate('fecha_pago', request('fecha'));
        }
        
        // Filtro por nombre del cliente
        if (request('cliente')) {
            $query->whereHas('pedido.user', function($q) {
                $q->where('name', 'like', '%' . request('cliente') . '%');
            });
        }
        
        $pagos = $query->paginate(15)->appends(request()->query());
        
        return view('pagos.admin', compact('pagos'));
    }

    // Ver pagos (admin ve todos, cliente ve solo los suyos)
    public function index()
    {
        $user = auth()->user();
        
        // Redirigir admin a su vista específica
        if ($user->rol === 'admin') {
            return redirect()->route('pagos.admin');
        }
        
        if ($user->rol === 'empleado') {
            $pagos = Pago::with(['pedido.user', 'user'])
                ->whereHas('pedido', function($query) use ($user) {
                    $query->where('empleado_id', $user->id);
                })
                ->latest()->paginate(15);
        } else {
            $pagos = Pago::with(['pedido', 'user'])
                ->whereHas('pedido', function($query) use ($user) {
                    $query->where('user_id', $user->id);
                })
                ->latest()->paginate(15);
        }
        
        return view('pagos.index', compact('pagos'));
    }

    // Crear pago para un pedido
    public function create(Pedido $pedido)
    {
        $user = auth()->user();
        
        // Verificar que el pedido pertenece al usuario
        if ($pedido->user_id !== $user->id) {
            abort(403, 'No tienes permiso para pagar este pedido');
        }
        
        // Verificar que el pedido no tenga ya un pago
        if ($pedido->pago) {
            return redirect()->route('pedidos.confirmacion', $pedido)
                ->with('error', 'Este pedido ya tiene un pago asociado');
        }
        
        $pedido->load('detalles.producto');
        
        return view('pagos.create', compact('pedido'));
    }

    // Procesar pago
    public function store(Request $request, Pedido $pedido)
    {
        \Log::info('Iniciando proceso de pago', [
            'pedido_id' => $pedido->id, 
            'metodo' => $request->metodo,
            'datos_pago' => $request->datos_pago,
            'all_request' => $request->all()
        ]);
        
        $user = auth()->user();
        
        // Permitir a admin y empleados crear pagos para cualquier pedido
        if (!in_array($user->rol, ['admin', 'empleado']) && $pedido->user_id !== $user->id) {
            abort(403);
        }
        
        // Verificar que el pedido no tenga ya un pago
        if ($pedido->pago) {
            return redirect()->route('pedidos.confirmacion', $pedido)
                ->with('error', 'Este pedido ya tiene un pago asociado');
        }
        
        $request->validate([
            'metodo' => 'required|in:efectivo,pse,nequi,daviplata,bancolombia',
            'datos_pago' => 'nullable|array'
        ]);
        
        $estado = $request->estado_pago ?? ($request->metodo === 'efectivo' ? 'pendiente' : 'pagado');
        
        try {
            $pago = Pago::create([
                'pedido_id' => $pedido->id,
                'user_id' => $pedido->user_id,
                'monto' => $pedido->total,
                'metodo' => $request->metodo,
                'estado' => $estado,
                'fecha_pago' => now()
            ]);
            
            \Log::info('Pago creado exitosamente', ['pago_id' => $pago->id]);
            
            // Crear detalle del pago automáticamente con información del registrador
            $datosPago = null;
            if ($user->rol === 'admin') {
                $datosPago = 'Pago registrado manualmente por admin';
            } elseif ($user->rol === 'empleado') {
                $datosPago = 'Pago registrado por empleado: ' . $user->name;
            }
            // Para clientes no se guarda información especial
            
            $detalle = \App\Models\DetallePago::create([
                'pago_id' => $pago->id,
                'descripcion' => 'Detalle del pago para el pedido #' . $pedido->id,
                'monto' => $pedido->total,
                'datos_pago' => $datosPago
            ]);
            
            \Log::info('Detalle de pago creado exitosamente', ['detalle_id' => $detalle->id]);
            
            // Si el pago es exitoso (no efectivo), actualizar estado del pedido
            if ($estado === 'pagado') {
                $pedido->update(['estado' => 'Pagado']);
                \Log::info('Estado del pedido actualizado a Pagado', ['pedido_id' => $pedido->id]);
            }
            
        } catch (\Exception $e) {
            \Log::error('Error creando pago: ' . $e->getMessage());
            return back()->with('error', 'Error al procesar el pago: ' . $e->getMessage());
        }
        
        return redirect()->route('pedidos.confirmacion', $pedido)->with('success', 'Pago exitoso. Tu pedido ha sido pagado correctamente.');
    }

    // Ver detalle de un pago
    public function show(Pago $pago)
    {
        $user = auth()->user();
        
        // Verificar permisos
        if ($user->rol === 'cliente' && $pago->pedido->user_id !== $user->id) {
            abort(403);
        }
        
        $pago->load(['pedido.detalles.producto', 'pedido.user', 'user']);
        
        return view('pagos.show', compact('pago'));
    }

    // Cambiar estado de pago (solo admin y empleado para efectivo)
    public function cambiarEstado(Request $request, Pago $pago)
    {
        $user = auth()->user();
        
        if (!in_array($user->rol, ['admin', 'empleado'])) {
            return back()->with('error', 'No tienes permisos para realizar esta acción');
        }
        
        $request->validate([
            'estado' => 'required|in:pendiente,pagado'
        ]);
        
        if ($pago->metodo !== 'efectivo') {
            return back()->with('error', 'Solo se puede cambiar el estado de pagos en efectivo');
        }
        
        $estadoAnterior = $pago->estado;
        $pago->estado = $request->estado;
        if ($request->estado === 'pagado') {
            $pago->fecha_pago = now();
            // Sincronizar estado del pedido
            $pago->pedido->update(['estado' => 'Pagado']);
        } else {
            // Si se marca como pendiente, también actualizar el pedido
            $pago->pedido->update(['estado' => 'Pendiente']);
        }
        $pago->save();
        

        
        $mensaje = $request->estado === 'pagado' ? 
            'Pago marcado como pagado correctamente' : 
            'Pago marcado como pendiente';
            
        return back()->with('success', $mensaje);
    }

    // Historial de pagos del cliente
    public function historial()
    {
        $user = auth()->user();
        
        // Solo los clientes pueden acceder al historial específico
        if ($user->rol !== 'cliente') {
            return redirect()->route('pagos.index');
        }
        
        $pagos = Pago::with(['pedido.detalles.producto'])
            ->whereHas('pedido', function($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->whereIn('estado', ['pagado', 'cancelado'])
            ->latest()
            ->limit(6)
            ->get();
        
        return view('pagos.historial', compact('pagos'));
    }
}

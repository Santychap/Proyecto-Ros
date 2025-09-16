<?php

namespace App\Http\Controllers;

use App\Models\Pago;
use App\Models\Pedido;
use App\Models\DetallePago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PagoController extends Controller
{
    // Vista para pagar un pedido
    public function create(Pedido $pedido)
    {
        $user = Auth::user();

        if ($user->rol === 'cliente') {
            if ($user->id !== $pedido->user_id || strtolower($pedido->estado) !== 'pendiente') {
                abort(403, 'Cliente no autorizado o pedido no pendiente.');
            }
            $metodos = ['tarjeta', 'transferencia', 'paypal'];
        } elseif ($user->rol === 'admin') {
            $metodos = ['tarjeta', 'transferencia', 'paypal', 'efectivo'];
        } else {
            abort(403, 'Rol no autorizado para pagar.');
        }

        return view('pagos.create', compact('pedido', 'metodos'));
    }

    // Guardar pago
    public function store(Request $request, Pedido $pedido)
    {
        $user = Auth::user();

        // Validar permiso para pagar
        if ($user->rol === 'cliente') {
            if ($user->id !== $pedido->user_id || strtolower($pedido->estado) !== 'pendiente') {
                abort(403, 'Cliente no autorizado o pedido no pendiente.');
            }
        } elseif ($user->rol === 'admin') {
            if (strtolower($pedido->estado) !== 'pendiente') {
                abort(403, 'Pedido no pendiente.');
            }
        } else {
            abort(403, 'Rol no autorizado para pagar.');
        }

        // Definir reglas de validación
        $rules = [
            'metodo' => 'required|in:tarjeta,transferencia,paypal,efectivo',
        ];

        switch ($request->metodo) {
            case 'tarjeta':
                $rules['numero_tarjeta'] = 'required|digits_between:13,19';
                $rules['expiracion_tarjeta'] = ['required', 'regex:/^(0[1-9]|1[0-2])\/\d{2}$/']; // MM/AA
                $rules['cvv_tarjeta'] = 'required|digits:3';
                break;
            case 'transferencia':
                $rules['referencia_transferencia'] = 'required|string|max:255';
                break;
            case 'paypal':
                $rules['email_paypal'] = 'required|email';
                break;
            case 'efectivo':
                // Solo admin puede pagar en efectivo
                if ($user->rol !== 'admin') {
                    abort(403, 'Solo admin puede pagar en efectivo.');
                }
                break;
        }

        $validated = $request->validate($rules);

        // Construir datos_pago
        $datos_pago = '';

        switch ($validated['metodo']) {
            case 'tarjeta':
                $datos_pago = 'Tarjeta terminada en ' . substr($validated['numero_tarjeta'], -4) . ', Expira: ' . $validated['expiracion_tarjeta'];
                break;
            case 'transferencia':
                $datos_pago = 'Referencia transferencia: ' . $validated['referencia_transferencia'];
                break;
            case 'paypal':
                $datos_pago = 'Pago vía PayPal: ' . $validated['email_paypal'];
                break;
            case 'efectivo':
                $datos_pago = 'Pago en efectivo';
                break;
        }

        // Crear el pago
        $pago = Pago::create([
            'pedido_id' => $pedido->id,
            'user_id' => $user->id,
            'monto' => $pedido->total,
            'metodo' => $validated['metodo'],
            'datos_pago' => $datos_pago,
            'fecha_pago' => now(),
        ]);

        // Crear detalle del pago
        DetallePago::create([
            'pago_id' => $pago->id,
            'descripcion' => 'Detalle del pago para el pedido #' . $pedido->id,
            'monto' => $pedido->total,
        ]);

        // Actualizar estado del pedido
        $pedido->update(['estado' => 'Pagado']);

        // Redirigir con mensaje de éxito
        return redirect()->route('pagos.index')->with('success', 'Pago realizado correctamente.');
    }

    // Lista de pagos
    public function index()
    {
        $user = Auth::user();

        $pagos = $user->rol === 'admin'
            ? Pago::latest()->paginate(10)
            : Pago::where('user_id', $user->id)->latest()->paginate(10);

        return view('pagos.index', compact('pagos'));
    }

    // Ver pago
    public function show(Pago $pago)
    {
        $user = Auth::user();

        if ($user->rol !== 'admin' && $pago->user_id !== $user->id) {
            abort(403);
        }

        return view('pagos.show', compact('pago'));
    }
}

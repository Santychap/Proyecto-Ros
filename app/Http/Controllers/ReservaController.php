<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservaController extends Controller
{
    // Mostrar todas las reservas según el rol
    public function index()
    {
        $user = Auth::user();

        if ($user->rol === 'admin') {
            $reservas = Reserva::with('user')->orderBy('fecha', 'desc')->paginate(10);
        } else {
            $reservas = Reserva::where('user_id', $user->id)
                               ->orderBy('fecha', 'desc')
                               ->paginate(10);
        }

        return view('reservas.index', compact('reservas'));
    }

    // Mostrar formulario para nueva reserva (solo cliente y admin)
    public function create()
    {
        $user = auth()->user();

        // ❌ Empleados no pueden acceder
        if (!in_array($user->rol, ['admin', 'cliente'])) {
            abort(403, 'No tienes permiso para acceder a esta página.');
        }

        $clientes = [];

        if ($user->rol === 'admin') {
            $clientes = User::where('rol', 'cliente')->get();
        }

        return view('reservas.create', compact('clientes'));
    }

    // Guardar nueva reserva (con asignación automática de empleado)
    public function store(Request $request)
    {
        $user = Auth::user();

        // ❌ Solo admin o cliente pueden crear reservas
        if (!in_array($user->rol, ['admin', 'cliente'])) {
            abort(403, 'No tienes permiso para crear una reserva.');
        }

        $validatedData = $request->validate([
            'fecha'    => 'required|date|after_or_equal:today',
            'hora'     => 'required',
            'personas' => 'required|integer|min:1',
            'mesas'    => 'nullable|integer|min:1',
            'motivo'   => 'nullable|in:Cumpleaños,Aniversario,Cena de negocios,Otro',
            'nota'     => 'nullable|string|max:1000',
            'user_id'  => 'nullable|exists:users,id', // Solo para admin
        ]);

        // Determinar cliente correcto
        $validatedData['user_id'] = ($user->rol === 'admin' && $request->filled('user_id'))
            ? $request->input('user_id')
            : $user->id;

        // Estado inicial
        $validatedData['estado'] = ($user->rol === 'admin') ? 'Pendiente' : 'Confirmada';

        // Asignar automáticamente un empleado disponible
        $empleadoDisponible = User::where('rol', 'empleado')->first(); // Puedes mejorar la lógica
        $validatedData['empleado_id'] = $empleadoDisponible ? $empleadoDisponible->id : null;

        Reserva::create($validatedData);

        return redirect()->route('reservas.index')->with('success', 'Reserva creada correctamente.');
    }

    // Mostrar formulario para editar una reserva
    public function edit(Reserva $reserva)
    {
        $this->authorize('update', $reserva);

        return view('reservas.edit', compact('reserva'));
    }

    // Actualizar reserva existente
    public function update(Request $request, Reserva $reserva)
    {
        $this->authorize('update', $reserva);

        $validatedData = $request->validate([
            'fecha'    => 'required|date|after_or_equal:today',
            'hora'     => 'required',
            'personas' => 'required|integer|min:1',
            'mesas'    => 'nullable|integer|min:1',
            'motivo'   => 'nullable|in:Cumpleaños,Aniversario,Cena de negocios,Otro',
            'nota'     => 'nullable|string|max:1000',
        ]);

        $reserva->update($validatedData);

        return redirect()->route('reservas.index')->with('success', 'Reserva actualizada correctamente.');
    }

    // Eliminar reserva
    public function destroy(Reserva $reserva)
    {
        $this->authorize('delete', $reserva);

        $reserva->delete();

        return redirect()->route('reservas.index')->with('success', 'Reserva eliminada correctamente.');
    }
}

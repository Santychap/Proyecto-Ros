<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use App\Models\Mesa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReservaController extends Controller
{
    // Mostrar todas las reservas según el rol
    public function index()
    {
        $user = Auth::user();

        if ($user->rol === 'admin') {
            $reservas = Reserva::with(['user', 'mesa'])->orderBy('fecha', 'desc')->paginate(10);
        } else {
            $reservas = Reserva::where('user_id', $user->id)
                               ->orderBy('fecha', 'desc')
                               ->paginate(10);
        }

        return view('reservas.index', compact('reservas'));
    }

    // Mostrar formulario para nueva reserva
    public function create()
    {
        $user = auth()->user();

        if (!in_array($user->rol, ['admin', 'cliente'])) {
            abort(403, 'No tienes permiso para acceder a esta página.');
        }

        $clientes = [];
        $mesas = [];

        if ($user->rol === 'admin') {
            $clientes = User::where('rol', 'cliente')->get();
            $mesas = Mesa::all();
        }

        return view('reservas.create', compact('clientes', 'mesas'));
    }

    // Guardar nueva reserva
    public function store(Request $request)
    {
        $user = Auth::user();

        if (!in_array($user->rol, ['admin', 'cliente'])) {
            abort(403, 'No tienes permiso para crear una reserva.');
        }

        $validatedData = $request->validate([
            'fecha'    => 'required|date|after_or_equal:today',
            'hora'     => 'required',
            'personas' => 'required|integer|min:1',
            'mesa_id'  => 'nullable|exists:mesas,id', // Solo lo usará el admin
            'motivo'   => 'nullable|in:Cumpleaños,Aniversario,Cena de negocios,Otro',
            'nota'     => 'nullable|string|max:1000',
            'user_id'  => 'nullable|exists:users,id', // Solo para admin
        ]);

        // Cliente asignado
        $validatedData['user_id'] = ($user->rol === 'admin' && $request->filled('user_id'))
            ? $request->input('user_id')
            : $user->id;

        // Estado según el rol
        $validatedData['estado'] = ($user->rol === 'admin') ? 'Pendiente' : 'Confirmada';

        // Empleado asignado automáticamente (mejorable)
        $empleadoDisponible = User::where('rol', 'empleado')->first();
        $validatedData['empleado_id'] = $empleadoDisponible ? $empleadoDisponible->id : null;

        // Mesa
        if ($user->rol === 'admin' && $request->filled('mesa_id')) {
            // Admin elige mesa manualmente
            $mesa = Mesa::find($request->input('mesa_id'));
        } else {
            // Cliente: buscar mesa disponible automáticamente
            $mesa = $this->buscarMesaDisponible($validatedData['fecha'], $validatedData['hora'], $validatedData['personas']);
        }

        if (!$mesa) {
            return back()->with('error', 'No hay mesas disponibles para esa fecha y hora.')->withInput();
        }

        $validatedData['mesa_id'] = $mesa->id;

        // Crear reserva
        Reserva::create($validatedData);

        return redirect()->route('reservas.index')->with('success', 'Reserva creada correctamente.');
    }

    // Formulario para editar
    public function edit(Reserva $reserva)
    {
        $this->authorize('update', $reserva);

        $mesas = Mesa::all();
        return view('reservas.edit', compact('reserva', 'mesas'));
    }

    // Actualizar reserva
    public function update(Request $request, Reserva $reserva)
    {
        $this->authorize('update', $reserva);

        $validatedData = $request->validate([
            'fecha'    => 'required|date|after_or_equal:today',
            'hora'     => 'required',
            'personas' => 'required|integer|min:1',
            'mesa_id'  => 'nullable|exists:mesas,id',
            'motivo'   => 'nullable|in:Cumpleaños,Aniversario,Cena de negocios,Otro',
            'nota'     => 'nullable|string|max:1000',
        ]);

        // Si admin modifica la mesa
        if ($request->filled('mesa_id')) {
            $mesa = Mesa::find($request->input('mesa_id'));
            if ($mesa) {
                $validatedData['mesa_id'] = $mesa->id;
            }
        }

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

    // Buscar una mesa disponible automáticamente
    private function buscarMesaDisponible($fecha, $hora, $personas)
    {
        $duracion = 2; // Duración estimada en horas
        $horaInicio = Carbon::parse($hora);
        $horaFin = $horaInicio->copy()->addHours($duracion);

        return Mesa::where('capacidad', '>=', $personas)
            ->whereDoesntHave('reservas', function ($query) use ($fecha, $horaInicio, $horaFin) {
                $query->where('fecha', $fecha)
                    ->where(function ($q) use ($horaInicio, $horaFin) {
                        $q->whereBetween('hora', [$horaInicio->format('H:i:s'), $horaFin->format('H:i:s')])
                          ->orWhereRaw('? BETWEEN hora AND ADDTIME(hora, "2:00:00")', [$horaInicio->format('H:i:s')]);
                    });
            })
            ->orderBy('capacidad', 'asc') // opcional: usar la mesa más pequeña posible
            ->first();
    }
}

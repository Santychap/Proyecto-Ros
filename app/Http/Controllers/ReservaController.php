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

        if ($user->rol === 'cliente') {
            return view('reservas.cliente', compact('reservas'));
        } else {
            return view('reservas.index', compact('reservas'));
        }
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
            'fecha'    => 'required|date|after:today',
            'hora'     => 'required',
            'personas' => 'required|integer|min:1',
            'mesas'    => 'nullable|exists:mesas,id',
            'motivo'   => 'nullable|in:Cumpleaños,Aniversario,Cena de negocios,Otro',
            'nota'     => 'nullable|string|max:1000',
            'user_id'  => 'nullable|exists:users,id',
        ]);

        // Cliente asignado
        $validatedData['user_id'] = ($user->rol === 'admin' && $request->filled('user_id'))
            ? $request->input('user_id')
            : $user->id;

        // Estado siempre confirmada
        $validatedData['estado'] = 'Confirmada';

        // Empleado asignado automáticamente (mejorable)
        $empleadoDisponible = User::where('rol', 'empleado')->first();
        $validatedData['empleado_id'] = $empleadoDisponible ? $empleadoDisponible->id : null;

        // Verificar disponibilidad de mesa
        if ($user->rol === 'admin' && $request->filled('mesas')) {
            // Admin elige mesa manualmente - verificar disponibilidad
            $mesa = Mesa::find($request->input('mesas'));
            if (!$this->verificarDisponibilidadMesa($mesa->id, $validatedData['fecha'], $validatedData['hora'])) {
                return back()->with('error', 'La mesa seleccionada no está disponible en esa fecha y hora.')->withInput();
            }
            $validatedData['mesas'] = $mesa->id;
        } else {
            // Buscar mesa disponible automáticamente
            $mesa = $this->buscarMesaDisponible($validatedData['fecha'], $validatedData['hora'], $validatedData['personas']);
            if (!$mesa) {
                return back()->with('error', 'No hay mesas disponibles para esa fecha y hora. Por favor, selecciona otra fecha u horario.')->withInput();
            }
            $validatedData['mesas'] = $mesa->id;
        }

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
            'mesas'    => 'nullable|exists:mesas,id',
            'motivo'   => 'nullable|in:Cumpleaños,Aniversario,Cena de negocios,Otro',
            'nota'     => 'nullable|string|max:1000',
        ]);

        // Si admin modifica la mesa
        if ($request->filled('mesas')) {
            $mesa = Mesa::find($request->input('mesas'));
            if ($mesa) {
                $validatedData['mesas'] = $mesa->id;
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

    // Verificar disponibilidad de una mesa específica
    private function verificarDisponibilidadMesa($mesaId, $fecha, $hora)
    {
        $duracion = 2;
        $horaInicio = Carbon::parse($hora);
        $horaFin = $horaInicio->copy()->addHours($duracion);

        $reservaExistente = Reserva::where('mesas', $mesaId)
            ->where('fecha', $fecha)
            ->where('estado', '!=', 'Cancelada')
            ->where(function ($q) use ($horaInicio, $horaFin) {
                $q->whereBetween('hora', [$horaInicio->format('H:i:s'), $horaFin->format('H:i:s')])
                  ->orWhereRaw('? BETWEEN hora AND ADDTIME(hora, "2:00:00")', [$horaInicio->format('H:i:s')])
                  ->orWhereRaw('hora BETWEEN ? AND ?', [$horaInicio->format('H:i:s'), $horaFin->format('H:i:s')]);
            })
            ->exists();

        return !$reservaExistente;
    }

    // Buscar una mesa disponible automáticamente
    private function buscarMesaDisponible($fecha, $hora, $personas)
    {
        $duracion = 2;
        $horaInicio = Carbon::parse($hora);
        $horaFin = $horaInicio->copy()->addHours($duracion);

        return Mesa::where('capacidad', '>=', $personas)
            ->whereDoesntHave('reservas', function ($query) use ($fecha, $horaInicio, $horaFin) {
                $query->where('fecha', $fecha)
                    ->where('estado', '!=', 'Cancelada')
                    ->where(function ($q) use ($horaInicio, $horaFin) {
                        $q->whereBetween('hora', [$horaInicio->format('H:i:s'), $horaFin->format('H:i:s')])
                          ->orWhereRaw('? BETWEEN hora AND ADDTIME(hora, "2:00:00")', [$horaInicio->format('H:i:s')])
                          ->orWhereRaw('hora BETWEEN ? AND ?', [$horaInicio->format('H:i:s'), $horaFin->format('H:i:s')]);
                    });
            })
            ->orderBy('capacidad', 'asc')
            ->first();
    }

    // Método público para mostrar formulario de reservas
    public function publicIndex()
    {
        return view('reservas.public');
    }

    // Método público para mostrar formulario de crear reservas
    public function publicCreate()
    {
        return view('reservas.public');
    }

    // Método público para guardar reserva sin autenticación
    public function publicStore(Request $request)
    {
        $validatedData = $request->validate([
            'nombre'   => 'required|string|max:255',
            'email'    => 'required|email|max:255',
            'telefono' => 'required|string|max:20',
            'fecha'    => 'required|date|after:today',
            'hora'     => 'required',
            'personas' => 'required|integer|min:1|max:12',
            'motivo'   => 'nullable|string|max:255',
            'nota'     => 'nullable|string|max:1000',
        ]);

        // Buscar mesa disponible
        $mesa = $this->buscarMesaDisponible($validatedData['fecha'], $validatedData['hora'], $validatedData['personas']);

        if (!$mesa) {
            return back()->with('error', 'No hay mesas disponibles para esa fecha y hora. Por favor, selecciona otra fecha u hora.')->withInput();
        }

        // Buscar o crear usuario temporal
        $user = User::firstOrCreate(
            ['email' => $validatedData['email']],
            [
                'name' => $validatedData['nombre'],
                'password' => bcrypt('temporal123'), // Contraseña temporal
                'rol' => 'cliente'
            ]
        );

        // Crear reserva
        Reserva::create([
            'user_id' => $user->id,
            'mesas' => $mesa->id,
            'fecha' => $validatedData['fecha'],
            'hora' => $validatedData['hora'],
            'personas' => $validatedData['personas'],
            'motivo' => $validatedData['motivo'],
            'nota' => $validatedData['nota'],
            'estado' => 'Confirmada',
        ]);

        return back()->with('success', '¡Reserva creada exitosamente! Te contactaremos pronto para confirmar los detalles.');
    }
}

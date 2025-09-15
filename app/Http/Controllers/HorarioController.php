<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HorarioController extends Controller
{
    // Mostrar horarios del empleado (o admin puede ver todos con búsqueda)
   public function index(Request $request)
{
    $user = Auth::user();

    $search = $request->input('search'); // Obtener el término de búsqueda

    if ($user->rol === 'admin') {
        $query = Horario::with('user');

        if ($search) {
            // Filtrar por nombre o correo del empleado
            $query->whereHas('user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $horarios = $query->get();
    } else {
        // Para empleados, solo sus horarios (sin búsqueda)
        $horarios = $user->horarios;
    }

    return view('horarios.index', compact('horarios', 'search'));
}


    // Formulario para crear nuevo horario (solo admin)
    public function create()
    {
        if (auth()->user()->rol !== 'admin') {
            abort(403);
        }

        $empleados = User::where('rol', 'empleado')->get();

        return view('horarios.create', compact('empleados'));
    }

    // Guardar nuevo horario (solo admin)
    public function store(Request $request)
    {
        if (auth()->user()->rol !== 'admin') {
            abort(403);
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'dia' => 'required|string',
            'hora_entrada' => 'required|date_format:H:i',
            'hora_salida' => 'required|date_format:H:i|after:hora_entrada',
        ]);

        Horario::create($request->all());

        return redirect()->route('horarios.index')->with('success', 'Horario creado correctamente');
    }

    // Mostrar formulario para editar horario (solo admin)
    public function edit(Horario $horario)
    {
        if (auth()->user()->rol !== 'admin') {
            abort(403);
        }

        $empleados = User::where('rol', 'empleado')->get();

        return view('horarios.edit', compact('horario', 'empleados'));
    }

    // Actualizar horario (solo admin)
    public function update(Request $request, Horario $horario)
    {
        if (auth()->user()->rol !== 'admin') {
            abort(403);
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'dia' => 'required|string',
            'hora_entrada' => 'required|date_format:H:i',
            'hora_salida' => 'required|date_format:H:i|after:hora_entrada',
        ]);

        $horario->update($request->all());

        return redirect()->route('horarios.index')->with('success', 'Horario actualizado correctamente');
    }

    // Eliminar horario (solo admin)
    public function destroy(Horario $horario)
    {
        if (auth()->user()->rol !== 'admin') {
            abort(403);
        }

        $horario->delete();

        return redirect()->route('horarios.index')->with('success', 'Horario eliminado correctamente');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $users = User::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->orderBy('id', 'asc')
            ->paginate(10);

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'rol' => 'required|string|in:admin,cliente,empleado',
        ]);

        // contraseña encriptada
        $data['password'] = bcrypt($data['password']);
        // por defecto activo
        $data['estado'] = true;

        User::create($data);

        return redirect()->route('users.index')->with('success', 'Usuario creado correctamente.');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'rol' => 'required|string|in:admin,cliente,empleado',
        ]);

        $user->update($data);

        return redirect()->route('users.index')->with('success', 'Rol de usuario actualizado correctamente.');
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('users.index')->with('success', 'Usuario eliminado correctamente.');
    }

    public function misHorarios()
    {
        $user = auth()->user();
        $horarios = $user->horarios;
        return view('empleado.horarios', compact('horarios'));
    }

    // ✅ Inhabilitar usuario
    public function deactivate($id)
    {
        $user = User::findOrFail($id);
        $user->estado = false; // inhabilitado
        $user->save();

        return redirect()->route('users.index')->with('success', 'Usuario inhabilitado correctamente.');
    }

    // ✅ Activar usuario
    public function activate($id)
    {
        $user = User::findOrFail($id);
        $user->estado = true; // activo
        $user->save();

        return redirect()->route('users.index')->with('success', 'Usuario activado correctamente.');
    }
}

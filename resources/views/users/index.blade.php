@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="text-center mb-4">Usuarios</h1>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('users.create') }}" class="btn btn-primary">Crear Usuario</a>

        {{-- Barra de búsqueda --}}
        <form method="GET" action="{{ route('users.index') }}" class="d-flex">
            <input type="text" name="search" class="form-control me-2" placeholder="Buscar por nombre o correo" value="{{ request('search') }}">
            <button type="submit" class="btn btn-secondary">Buscar</button>
        </form>
    </div>

    <table class="table table-bordered text-center align-middle">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Rol</th>
                <th>Estado</th> {{-- Nueva columna --}}
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->rol }}</td>
                <td>
                    @if ($user->estado)
                        <span class="badge bg-success">Activo</span>
                    @else
                        <span class="badge bg-secondary">Inhabilitado</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('users.edit', $user) }}" class="btn btn-sm btn-warning me-1">Editar</a>

                    @if ($user->estado)
                        <form action="{{ route('users.deactivate', $user->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('¿Inhabilitar este usuario?')">Inhabilitar</button>
                        </form>
                    @else
                        <form action="{{ route('users.activate', $user->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('PATCH')
                            <button class="btn btn-sm btn-success" onclick="return confirm('¿Activar este usuario?')">Activar</button>
                        </form>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6">No se encontraron usuarios.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="d-flex justify-content-center">
        {{ $users->withQueryString()->links() }}
    </div>
</div>
@endsection

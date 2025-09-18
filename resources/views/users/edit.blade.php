@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Usuario</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Formulario para editar solo el rol -->
    <form action="{{ route('users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="rol" class="form-label">Rol</label>
            <select name="rol" id="rol" class="form-select" required>
                <option value="admin" {{ $user->rol == 'admin' ? 'selected' : '' }}>Administrador</option>
                <option value="empleado" {{ $user->rol == 'empleado' ? 'selected' : '' }}>Empleado</option>
                <option value="cliente" {{ $user->rol == 'cliente' ? 'selected' : '' }}>Cliente</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Guardar cambios</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>

    <hr>

    <!-- Botón para activar/inactivar usuario -->
    <form method="POST" action="{{ $user->estado ? route('users.deactivate', $user->id) : route('users.activate', $user->id) }}" style="margin-top: 20px;">
        @csrf
        @method('PATCH')
        <button type="submit" class="btn {{ $user->estado ? 'btn-warning' : 'btn-success' }}">
            {{ $user->estado ? 'inhabilitado usuario' : 'Activar usuario' }}
        </button>
    </form>
</div>
@endsection

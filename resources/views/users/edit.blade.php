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

    <form action="{{ route('users.update', $user) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Correo electrónico</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="mb-3">
            <label for="rol" class="form-label">Rol</label>
            <select name="rol" id="rol" class="form-select" required>
                <option value="">-- Seleccione un rol --</option>
                <option value="admin" {{ (old('rol', $user->rol) == 'admin') ? 'selected' : '' }}>Administrador</option>
                <option value="empleado" {{ (old('rol', $user->rol) == 'empleado') ? 'selected' : '' }}>Empleado</option>
                <option value="cliente" {{ (old('rol', $user->rol) == 'cliente') ? 'selected' : '' }}>Cliente</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Nueva contraseña <small>(Opcional)</small></label>
            <input type="password" class="form-control" id="password" name="password" minlength="8" placeholder="Dejar en blanco para no cambiar">
        </div>

        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirmar nueva contraseña</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" minlength="8">
        </div>

        <button type="submit" class="btn btn-primary">Guardar cambios</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection

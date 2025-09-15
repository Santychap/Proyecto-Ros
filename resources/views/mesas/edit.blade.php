@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Mesa</h1>

    <form method="POST" action="{{ route('mesas.update', $mesa) }}">
        @csrf @method('PUT')
        <div class="mb-3">
            <label for="codigo" class="form-label">Código</label>
            <input type="text" class="form-control" name="codigo" value="{{ $mesa->codigo }}" required>
        </div>
        <div class="mb-3">
            <label for="capacidad" class="form-label">Capacidad</label>
            <input type="number" class="form-control" name="capacidad" value="{{ $mesa->capacidad }}" min="1" required>
        </div>
        <button type="submit" class="btn btn-primary">Actualizar</button>
        <a href="{{ route('mesas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection

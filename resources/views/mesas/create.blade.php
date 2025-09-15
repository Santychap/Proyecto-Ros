@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Crear Mesa</h1>

    <form method="POST" action="{{ route('mesas.store') }}">
        @csrf
        <div class="mb-3">
            <label for="codigo" class="form-label">Código</label>
            <input type="text" class="form-control" name="codigo" required>
        </div>
        <div class="mb-3">
            <label for="capacidad" class="form-label">Capacidad</label>
            <input type="number" class="form-control" name="capacidad" min="1" required>
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('mesas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection

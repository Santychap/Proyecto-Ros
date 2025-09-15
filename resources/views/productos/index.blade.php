@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Productos del Menú</h1>
    <a href="{{ route('productos.create') }}" class="btn btn-primary mb-3">Agregar Producto</a>

    <div class="row">
        @foreach($productos as $producto)
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="position-relative">
                    @if($producto->image)
                        <img src="{{ asset('storage/' . $producto->image) }}" class="card-img-top" style="height: 200px; object-fit: cover;">
                    @else
                        <img src="https://via.placeholder.com/200x200.png?text=Sin+Imagen" class="card-img-top">
                    @endif
                    <span class="position-absolute top-0 end-0 p-2">
                        <i class="bi bi-info-circle-fill text-primary"
                           data-bs-toggle="tooltip"
                           data-bs-placement="left"
                           title="{{ $producto->ingredientes }}"></i>
                    </span>
                </div>
                <div class="card-body">
                    <h5 class="card-title">{{ $producto->nombre }}</h5>
                    <p class="text-muted">{{ $producto->descripcion }}</p>
                    <p><strong>${{ number_format($producto->precio, 2) }}</strong></p>
                    <p><small>Stock: {{ $producto->stock }}</small></p>
                    <p><small>Categoría: {{ $producto->categoria->nombre }}</small></p>

                    <a href="{{ route('productos.edit', $producto) }}" class="btn btn-sm btn-warning">Editar</a>
                    <form action="{{ route('productos.destroy', $producto) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"
                            onclick="return confirm('¿Estás seguro de eliminar este producto?')">
                            Eliminar
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        const tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    });
</script>
@endsection

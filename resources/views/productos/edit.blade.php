@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Editar Producto</h1>

    <form action="{{ route('productos.update', $producto) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="nombre">Nombre del producto</label>
            <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $producto->nombre) }}" required>
        </div>

        <div class="mb-3">
            <label for="image">Imagen</label>
            <input type="file" name="image" class="form-control">
            @if($producto->image)
                <img src="{{ asset('storage/' . $producto->image) }}" alt="Imagen actual" class="img-thumbnail mt-2" style="max-height: 150px;">
            @endif
        </div>

        <div class="mb-3">
            <label for="precio">Precio</label>
            <input type="number" name="precio" class="form-control" step="0.01" value="{{ old('precio', $producto->precio) }}" required>
        </div>

        <div class="mb-3">
            <label for="stock">Stock</label>
            <input type="number" name="stock" class="form-control" min="0" required value="{{ old('stock', $producto->stock) }}">
        </div>

        <div class="mb-3">
            <label for="descripcion">Descripción</label>
            <textarea name="descripcion" class="form-control">{{ old('descripcion', $producto->descripcion) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="ingredientes">Ingredientes</label>
            <textarea name="ingredientes" class="form-control" placeholder="Ej: Pollo, arroz, especias...">{{ old('ingredientes', $producto->ingredientes) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="categoria_id">Categoría</label>
            <select name="categoria_id" class="form-control" required>
                @foreach($categorias as $categoria)
                    <option value="{{ $categoria->id }}" {{ $categoria->id == old('categoria_id', $producto->categoria_id) ? 'selected' : '' }}>
                        {{ $categoria->nombre }}
                    </option>
                @endforeach
            </select>
        </div>

        <button class="btn btn-primary">Actualizar</button>
    </form>
</div>
@endsection

<form action="{{ route('productos.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="mb-3">
        <label for="nombre">Nombre del producto</label>
        <input type="text" name="nombre" class="form-control" required value="{{ old('nombre') }}">
    </div>

    <div class="mb-3">
        <label for="image">Imagen</label>
        <input type="file" name="image" class="form-control">
    </div>

    <div class="mb-3">
        <label for="precio">Precio</label>
        <input type="number" name="precio" class="form-control" step="0.01" required value="{{ old('precio') }}">
    </div>

    <div class="mb-3">
        <label for="stock">Stock</label>
        <input type="number" name="stock" class="form-control" min="0" required value="{{ old('stock', 0) }}">
    </div>

    <div class="mb-3">
        <label for="descripcion">Descripción</label>
        <textarea name="descripcion" class="form-control">{{ old('descripcion') }}</textarea>
    </div>

    <div class="mb-3">
        <label for="ingredientes">Ingredientes</label>
        <textarea name="ingredientes" class="form-control" placeholder="Ej: Pollo, arroz, especias...">{{ old('ingredientes') }}</textarea>
    </div>

    <div class="mb-3">
        <label for="category_id">Categoría</label>
        <select name="category_id" class="form-control" required>
            @foreach($categorias as $categoria)
                <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
            @endforeach
        </select>
    </div>

    <button class="btn btn-success">Guardar</button>
</form>

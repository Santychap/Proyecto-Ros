@extends('layouts.menu')

@section('title', 'Editar Producto - Olla y Sazón')

@section('content')
<div class="producto-form-container">
    <div class="form-header">
        <h1 class="form-title">
            <i class="fas fa-edit"></i>
            Editar Producto
        </h1>
        <p class="form-subtitle">Modifica los datos del producto "{{ $producto->nombre }}"</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            <div>
                <strong>Por favor corrige los siguientes errores:</strong>
                <ul style="margin: 0.5rem 0 0 0; padding-left: 1.5rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="form-card">
        <form action="{{ route('productos.update', $producto) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-utensils"></i> Nombre del Producto
                    </label>
                    <input type="text" name="nombre" class="form-input" 
                           value="{{ old('nombre', $producto->nombre) }}" required 
                           placeholder="Ej: Ajiaco Santafereño">
                </div>
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-dollar-sign"></i> Precio
                    </label>
                    <input type="number" name="precio" class="form-input" 
                           step="0.01" min="0" required
                           value="{{ old('precio', $producto->precio) }}"
                           placeholder="Ej: 18000.00">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-boxes"></i> Stock Disponible
                    </label>
                    <input type="number" name="stock" class="form-input" 
                           min="0" required
                           value="{{ old('stock', $producto->stock) }}"
                           placeholder="Ej: 30">
                </div>
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-tag"></i> Categoría
                    </label>
                    @php
                        $todasCategorias = \App\Models\Categoria::all();
                    @endphp
                    <select name="category_id" class="form-input" required>
                        <option value="">-- Selecciona una categoría --</option>
                        @foreach($todasCategorias as $categoria)
                            <option value="{{ $categoria->id }}" 
                                {{ $categoria->id == old('category_id', $producto->category_id) ? 'selected' : '' }}>
                                {{ $categoria->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-align-left"></i> Descripción
                </label>
                <textarea name="descripcion" class="form-input" rows="3" 
                          placeholder="Describe el producto de manera atractiva...">{{ old('descripcion', $producto->descripcion) }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-list"></i> Ingredientes
                </label>
                <textarea name="ingredientes" class="form-input" rows="3" 
                          placeholder="Ej: Pollo, papas criollas, sabaneras, pastusas, mazorca, guascas...">{{ old('ingredientes', $producto->ingredientes) }}</textarea>
                <small class="form-help">Lista los ingredientes principales separados por comas</small>
            </div>

            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-image"></i> Imagen del Producto
                </label>
                <div class="image-upload-container">
                    <input type="file" name="image" class="form-input" accept="image/*" id="imageInput">
                    <div class="image-preview">
                        @if($producto->image && file_exists(public_path('storage/' . $producto->image)))
                            <img src="{{ asset('storage/' . $producto->image) }}" alt="Imagen actual" id="imagePreview">
                            <p class="image-text">Imagen actual - Selecciona un archivo para cambiarla</p>
                        @elseif($producto->image)
                            <div class="no-image-preview" id="imagePreview">
                                <i class="fas fa-exclamation-triangle"></i>
                                <p>Imagen no encontrada</p>
                                <small>{{ $producto->image }}</small>
                                <p class="upload-hint">Sube una nueva imagen</p>
                            </div>
                        @else
                            <div class="no-image-preview" id="imagePreview">
                                <i class="fas fa-image"></i>
                                <p>Sin imagen</p>
                                <p class="upload-hint">Sube una imagen para este producto</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('productos.index') }}" class="btn-secondary">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Actualizar Producto
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
.producto-form-container {
    max-width: 900px;
    margin: 0 auto;
    padding: 2rem;
}

.form-header {
    text-align: center;
    margin-bottom: 2rem;
}

.form-title {
    font-size: 2.5rem;
    color: var(--color-primary);
    margin-bottom: 0.5rem;
    font-weight: bold;
}

.form-subtitle {
    color: var(--text-muted);
    font-size: 1.1rem;
}

.form-card {
    background: var(--bg-glass);
    border: 2px solid var(--color-primary);
    border-radius: 20px;
    padding: 2rem;
    backdrop-filter: blur(15px);
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    color: var(--color-primary);
    font-weight: 600;
    margin-bottom: 0.5rem;
    font-size: 1rem;
}

.form-label i {
    margin-right: 0.5rem;
    width: 16px;
    text-align: center;
}

.form-input {
    width: 100%;
    padding: 1rem;
    border: 2px solid rgba(255, 215, 0, 0.3);
    border-radius: 10px;
    background: rgba(255, 255, 255, 0.9);
    color: #000000;
    font-size: 1rem;
    transition: all 0.3s ease;
    resize: vertical;
}

.form-input option {
    background: #ffffff;
    color: #000000;
    padding: 0.5rem;
}

.form-input:focus {
    outline: none;
    border-color: var(--color-primary);
    background: rgba(255, 255, 255, 0.95);
    box-shadow: 0 0 0 3px rgba(255, 215, 0, 0.2);
    color: #000000;
}

.form-input::placeholder {
    color: rgba(0, 0, 0, 0.6);
}

.form-help {
    display: block;
    margin-top: 0.5rem;
    color: var(--text-muted);
    font-size: 0.9rem;
    line-height: 1.4;
}

.image-upload-container {
    display: grid;
    grid-template-columns: 1fr 200px;
    gap: 1rem;
    align-items: start;
}

.image-preview {
    text-align: center;
}

.image-preview img {
    width: 100%;
    max-width: 200px;
    height: 150px;
    object-fit: cover;
    border-radius: 10px;
    border: 2px solid var(--color-primary);
}

.no-image-preview {
    width: 200px;
    height: 150px;
    background: rgba(255, 215, 0, 0.1);
    border: 2px dashed var(--color-primary);
    border-radius: 10px;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: var(--color-primary);
    text-align: center;
    padding: 1rem;
}

.no-image-preview i {
    font-size: 2rem;
    margin-bottom: 0.5rem;
}

.no-image-preview small {
    font-size: 0.7rem;
    color: var(--text-muted);
    margin: 0.5rem 0;
    word-break: break-all;
    max-width: 100%;
}

.upload-hint {
    font-size: 0.8rem;
    color: var(--color-primary);
    font-weight: 600;
    margin-top: 0.5rem;
}

.image-text {
    margin-top: 0.5rem;
    font-size: 0.8rem;
    color: var(--text-muted);
}

.form-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    margin-top: 2rem;
}

.btn-primary, .btn-secondary {
    padding: 1rem 2rem;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 1rem;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-primary {
    background: var(--color-primary);
    color: #000;
}

.btn-primary:hover {
    background: var(--color-primary-light);
    color: #000;
    transform: translateY(-2px);
}

.btn-secondary {
    background: rgba(255, 255, 255, 0.1);
    color: var(--text-light);
    border: 2px solid rgba(255, 215, 0, 0.3);
}

.btn-secondary:hover {
    background: rgba(255, 215, 0, 0.1);
    border-color: var(--color-primary);
    color: var(--text-light);
}

.alert {
    padding: 1rem;
    border-radius: 10px;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: flex-start;
    gap: 0.5rem;
}

.alert-error {
    background: rgba(255, 71, 87, 0.1);
    border: 2px solid #ff4757;
    color: #ff4757;
}

@media (max-width: 768px) {
    .form-row {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .image-upload-container {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    
    .image-preview {
        order: -1;
    }
    
    .form-actions {
        flex-direction: column;
    }
    
    .producto-form-container {
        padding: 1rem;
    }
    
    .form-title {
        font-size: 2rem;
    }
}
</style>
@endpush

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('imageInput');
    const imagePreview = document.getElementById('imagePreview');
    
    if (imageInput && imagePreview) {
        imageInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.innerHTML = `
                        <img src="${e.target.result}" alt="Vista previa" style="width: 100%; max-width: 200px; height: 150px; object-fit: cover; border-radius: 10px; border: 2px solid var(--color-primary);">
                        <p class="image-text">Nueva imagen seleccionada</p>
                    `;
                };
                reader.readAsDataURL(file);
            }
        });
    }
});
</script>
@endpush

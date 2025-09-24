@extends('layouts.admin')

@section('title', 'Editar Promoción - Olla y Sazón')

@section('content')
<div class="promocion-form-container">
    <div class="form-header">
        <h1 class="form-title">
            <i class="fas fa-edit"></i>
            Editar Promoción
        </h1>
        <p class="form-subtitle">Modifica los datos de la promoción</p>
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
        <form action="{{ route('promociones.update', $promocion) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-heading"></i> Título de la Promoción
                </label>
                <input type="text" name="titulo" class="form-input" 
                       value="{{ old('titulo', $promocion->titulo) }}" required 
                       placeholder="Ej: Descuento especial fin de semana">
            </div>

            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-align-left"></i> Descripción
                </label>
                <textarea name="descripcion" class="form-input" rows="3"
                          placeholder="Describe los detalles de la promoción...">{{ old('descripcion', $promocion->descripcion) }}</textarea>
            </div>

            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-image"></i> Imagen Actual
                </label>
                @if($promocion->imagen)
                    <div class="current-image">
                        <img src="{{ asset('storage/' . $promocion->imagen) }}" alt="Imagen actual" style="max-width: 200px; border-radius: 10px; margin-bottom: 10px;">
                        <p style="color: #ffd700; font-size: 0.9rem;">Imagen actual de la promoción</p>
                    </div>
                @else
                    <p style="color: #ccc; font-size: 0.9rem;">No hay imagen actual</p>
                @endif
                <input type="file" name="imagen" class="form-input" accept="image/*">
                <small class="form-help">Sube una nueva imagen para reemplazar la actual (JPG, PNG, máximo 2MB)</small>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-percentage"></i> Descuento (%)
                    </label>
                    <input type="number" name="descuento" class="form-input" 
                           value="{{ old('descuento', $promocion->descuento) }}" required 
                           min="0" max="100" step="0.01"
                           placeholder="Ej: 15">
                </div>
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-calendar-alt"></i> Fecha de Inicio
                    </label>
                    <input type="date" name="fecha_inicio" class="form-input" 
                           value="{{ old('fecha_inicio', $promocion->fecha_inicio->format('Y-m-d')) }}" required>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-calendar-times"></i> Fecha de Fin (Opcional)
                </label>
                <input type="date" name="fecha_fin" class="form-input" 
                       value="{{ old('fecha_fin', $promocion->fecha_fin ? $promocion->fecha_fin->format('Y-m-d') : '') }}">
                <small class="form-help">Deja vacío si la promoción no tiene fecha de vencimiento</small>
            </div>

            <div class="form-actions">
                <a href="{{ route('promociones.index') }}" class="btn-secondary">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Actualizar Promoción
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
.promocion-form-container {
    max-width: 800px;
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
    background: #000000;
    border: 3px solid #ffd700;
    border-radius: 20px;
    padding: 2rem;
    box-shadow: 0 0 20px rgba(255, 215, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.8) inset;
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
    color: #ffd700;
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
    border: 2px solid #ffd700;
    border-radius: 10px;
    background: rgba(255, 255, 255, 0.9);
    color: #333;
    font-size: 1rem;
    transition: all 0.3s ease;
    resize: vertical;
}

.form-input:focus {
    outline: none;
    border-color: var(--color-primary);
    background: rgba(255, 255, 255, 0.15);
    box-shadow: 0 0 0 3px rgba(255, 215, 0, 0.2);
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
    
    .form-actions {
        flex-direction: column;
    }
    
    .promocion-form-container {
        padding: 1rem;
    }
    
    .form-title {
        font-size: 2rem;
    }
}
</style>
@endpush

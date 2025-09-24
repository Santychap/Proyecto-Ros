@extends('layouts.menu')

@section('title', 'Editar Mesa - Olla y Sazón')

@section('content')
<div class="mesa-form-container">
    <div class="form-header">
        <h1 class="form-title">
            <i class="fas fa-edit"></i>
            Editar Mesa
        </h1>
        <p class="form-subtitle">Modifica los datos de la mesa "{{ $mesa->codigo }}"</p>
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
        <form action="{{ route('mesas.update', $mesa) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-hashtag"></i> Código de Mesa
                    </label>
                    <input type="text" name="codigo" class="form-input" 
                           value="{{ old('codigo', $mesa->codigo) }}" required 
                           placeholder="Ej: M001">
                </div>
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-users"></i> Capacidad
                    </label>
                    <input type="number" name="capacidad" class="form-input" 
                           min="1" max="20" required
                           value="{{ old('capacidad', $mesa->capacidad) }}"
                           placeholder="Ej: 4">
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-comment"></i> Descripción (Opcional)
                </label>
                <textarea name="descripcion" class="form-input" rows="3" 
                          placeholder="Ej: Mesa junto a la ventana, vista al jardín...">{{ old('descripcion', $mesa->descripcion) }}</textarea>
                <small class="form-help">Agrega detalles especiales sobre la ubicación o características de la mesa</small>
            </div>

            <div class="form-actions">
                <a href="{{ route('mesas.index') }}" class="btn-secondary">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Actualizar Mesa
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
.mesa-form-container {
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
    
    .mesa-form-container {
        padding: 1rem;
    }
    
    .form-title {
        font-size: 2rem;
    }
}
</style>
@endpush
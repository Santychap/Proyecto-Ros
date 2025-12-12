@extends('layouts.admin')

@section('title', 'Editar Usuario - Olla y Sazón')

@section('content')
<div class="usuario-form-container">
    <div class="form-header">
        <h1 class="form-title">
            <i class="fas fa-user-edit"></i>
            Editar Usuario
        </h1>
        <p class="form-subtitle">Modifica los datos del usuario en el sistema</p>
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
        <form action="{{ route('users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-user"></i> Nombre Completo
                    </label>
                    <input type="text" class="form-input-readonly" 
                           value="{{ $user->name }}" readonly>
                    <small class="form-help">Este campo no se puede modificar</small>
                </div>
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-envelope"></i> Correo Electrónico
                    </label>
                    <input type="email" class="form-input-readonly" 
                           value="{{ $user->email }}" readonly>
                    <small class="form-help">Este campo no se puede modificar</small>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-user-tag"></i> Rol del Usuario
                </label>
                <select name="rol" class="form-input" required>
                    <option value="admin" {{ old('rol', $user->rol) == 'admin' ? 'selected' : '' }}>Administrador</option>
                    <option value="empleado" {{ old('rol', $user->rol) == 'empleado' ? 'selected' : '' }}>Empleado</option>
                    <option value="cliente" {{ old('rol', $user->rol) == 'cliente' ? 'selected' : '' }}>Cliente</option>
                </select>
                <small class="form-help">
                    <strong>Admin:</strong> Acceso completo | 
                    <strong>Empleado:</strong> Gestión de pedidos | 
                    <strong>Cliente:</strong> Realizar pedidos
                </small>
            </div>

            <div class="form-actions">
                <a href="{{ route('users.index') }}" class="btn-secondary">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Actualizar Rol
                </button>
            </div>
        </form>
    </div>

    <!-- Sección de Estado del Usuario -->
    <div class="form-card" style="margin-top: 2rem;">
        <div class="status-section">
            <h3 class="status-title">
                <i class="fas fa-toggle-on"></i> Estado del Usuario
            </h3>
            <p class="status-description">
                Usuario actualmente: 
                <span class="status-badge {{ $user->estado ? 'status-active' : 'status-inactive' }}">
                    {{ $user->estado ? 'Activo' : 'Inactivo' }}
                </span>
            </p>
            
            <form method="POST" action="{{ $user->estado ? route('users.deactivate', $user->id) : route('users.activate', $user->id) }}">
                @csrf
                @method('PATCH')
                <button type="submit" class="btn-status {{ $user->estado ? 'btn-deactivate' : 'btn-activate' }}">
                    <i class="fas {{ $user->estado ? 'fa-user-slash' : 'fa-user-check' }}"></i>
                    {{ $user->estado ? 'Desactivar Usuario' : 'Activar Usuario' }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.usuario-form-container {
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
}

.form-input:focus {
    outline: none;
    border-color: var(--color-primary);
    background: rgba(255, 255, 255, 0.15);
    box-shadow: 0 0 0 3px rgba(255, 215, 0, 0.2);
}

.form-input-readonly {
    width: 100%;
    padding: 1rem;
    border: 2px solid #666;
    border-radius: 10px;
    background: rgba(128, 128, 128, 0.3);
    color: #ccc;
    font-size: 1rem;
    cursor: not-allowed;
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

.status-section {
    text-align: center;
}

.status-title {
    color: #ffd700;
    font-size: 1.5rem;
    margin-bottom: 1rem;
    font-weight: 600;
}

.status-description {
    color: var(--text-light);
    font-size: 1.1rem;
    margin-bottom: 1.5rem;
}

.status-badge {
    padding: 0.5rem 1rem;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.9rem;
}

.status-active {
    background: #28a745;
    color: #fff;
}

.status-inactive {
    background: #dc3545;
    color: #fff;
}

.btn-status {
    padding: 1rem 2rem;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-activate {
    background: #28a745;
    color: #fff;
}

.btn-activate:hover {
    background: #218838;
    transform: translateY(-2px);
}

.btn-deactivate {
    background: #dc3545;
    color: #fff;
}

.btn-deactivate:hover {
    background: #c82333;
    transform: translateY(-2px);
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
    
    .usuario-form-container {
        padding: 1rem;
    }
    
    .form-title {
        font-size: 2rem;
    }
}
</style>
@endpush

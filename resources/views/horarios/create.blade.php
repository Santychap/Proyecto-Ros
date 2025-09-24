@extends('layouts.admin')

@section('title', 'Crear Horario - Olla y Sazón')

@section('content')
<div class="horario-form-container">
    <div class="form-header">
        <h1 class="form-title">
            <i class="fas fa-plus-circle"></i>
            Crear Nuevo Horario
        </h1>
        <p class="form-subtitle">Asigna un horario de trabajo a un empleado</p>
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
        <form action="{{ route('horarios.store') }}" method="POST">
            @csrf

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-user"></i> Empleado
                    </label>
                    <select name="user_id" class="form-input" required>
                        <option value="">-- Selecciona un empleado --</option>
                        @foreach($usuarios as $usuario)
                            <option value="{{ $usuario->id }}" 
                                {{ $usuario->id == old('user_id') ? 'selected' : '' }}>
                                {{ $usuario->name }} ({{ $usuario->email }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-calendar"></i> Día de la Semana
                    </label>
                    <select name="dia" class="form-input" required>
                        <option value="">-- Selecciona un día --</option>
                        <option value="lunes" {{ old('dia') == 'lunes' ? 'selected' : '' }}>Lunes</option>
                        <option value="martes" {{ old('dia') == 'martes' ? 'selected' : '' }}>Martes</option>
                        <option value="miercoles" {{ old('dia') == 'miercoles' ? 'selected' : '' }}>Miércoles</option>
                        <option value="jueves" {{ old('dia') == 'jueves' ? 'selected' : '' }}>Jueves</option>
                        <option value="viernes" {{ old('dia') == 'viernes' ? 'selected' : '' }}>Viernes</option>
                        <option value="sabado" {{ old('dia') == 'sabado' ? 'selected' : '' }}>Sábado</option>
                        <option value="domingo" {{ old('dia') == 'domingo' ? 'selected' : '' }}>Domingo</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-sign-in-alt"></i> Hora de Entrada
                    </label>
                    <input type="time" name="hora_entrada" class="form-input" 
                           value="{{ old('hora_entrada', '08:00') }}" required>
                </div>
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-sign-out-alt"></i> Hora de Salida
                    </label>
                    <input type="time" name="hora_salida" class="form-input" 
                           value="{{ old('hora_salida', '17:00') }}" required>
                </div>
            </div>

            <div class="form-help-section">
                <div class="help-card">
                    <i class="fas fa-info-circle"></i>
                    <div class="help-content">
                        <h4>Consejos para crear horarios:</h4>
                        <ul>
                            <li>Asegúrate de que las horas no se solapen con otros horarios del mismo empleado</li>
                            <li>Verifica que la hora de salida sea posterior a la hora de entrada</li>
                            <li>Los horarios típicos del restaurante son de 8:00 AM a 5:00 PM</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('horarios.index') }}" class="btn-secondary">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Crear Horario
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
.horario-form-container {
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

.form-input option {
    background: #ffffff;
    color: #000000;
    padding: 0.5rem;
}

.form-input:focus {
    outline: none;
    border-color: var(--color-primary);
    background: rgba(255, 255, 255, 0.15);
    box-shadow: 0 0 0 3px rgba(255, 215, 0, 0.2);
}

.form-help-section {
    margin: 2rem 0;
}

.help-card {
    background: rgba(255, 215, 0, 0.1);
    border: 2px solid rgba(255, 215, 0, 0.3);
    border-radius: 15px;
    padding: 1.5rem;
    display: flex;
    gap: 1rem;
}

.help-card i {
    color: var(--color-primary);
    font-size: 1.5rem;
    margin-top: 0.25rem;
}

.help-content h4 {
    color: var(--color-primary);
    margin-bottom: 0.5rem;
    font-size: 1.1rem;
}

.help-content ul {
    color: var(--text-light);
    padding-left: 1.5rem;
    line-height: 1.6;
}

.help-content li {
    margin-bottom: 0.5rem;
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
    
    .horario-form-container {
        padding: 1rem;
    }
    
    .form-title {
        font-size: 2rem;
    }
    
    .help-card {
        flex-direction: column;
        text-align: center;
    }
}
</style>
@endpush
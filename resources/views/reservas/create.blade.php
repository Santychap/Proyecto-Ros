@extends('layouts.admin')

@section('title', 'Nueva Reserva - Olla y Sazón')

@section('content')
<div class="reserva-form-container">
    <div class="form-header">
        <h1 class="form-title">
            <i class="fas fa-calendar-plus"></i>
            Nueva Reserva
        </h1>
        <p class="form-subtitle">Completa los datos para crear una nueva reserva</p>
    </div>

    @if(session('error'))
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    <div class="form-card">
        <form action="{{ route('reservas.store') }}" method="POST">
            @csrf

            @if(Auth::user()->rol === 'admin')
                <div class="form-row">
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-user"></i> Seleccionar Cliente
                        </label>
                        <select name="user_id" class="form-input">
                            <option value="">-- Selecciona un cliente --</option>
                            @foreach ($clientes as $cliente)
                                <option value="{{ $cliente->id }}">
                                    {{ $cliente->name }} ({{ $cliente->email }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="form-label">
                            <i class="fas fa-table"></i> Seleccionar Mesa
                        </label>
                        <select name="mesas" class="form-input">
                            <option value="">-- Asignación automática --</option>
                            @foreach ($mesas as $mesa)
                                <option value="{{ $mesa->id }}">
                                    Mesa {{ $mesa->codigo ?? $mesa->id }} ({{ $mesa->capacidad }} personas)
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endif

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-calendar"></i> Fecha
                    </label>
                    <input type="date" name="fecha" class="form-input" required value="{{ old('fecha') }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}">
                </div>
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-clock"></i> Hora
                    </label>
                    <input type="time" name="hora" class="form-input" required value="{{ old('hora') }}">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-users"></i> Cantidad de Personas
                    </label>
                    <input type="number" name="personas" class="form-input" min="1" max="12" required value="{{ old('personas') }}">
                </div>
                <div class="form-group">
                    <label class="form-label">
                        <i class="fas fa-heart"></i> Motivo de la Reserva
                    </label>
                    <select name="motivo" class="form-input">
                        <option value="">Selecciona una opción</option>
                        <option value="Cumpleaños" {{ old('motivo') == 'Cumpleaños' ? 'selected' : '' }}>Cumpleaños</option>
                        <option value="Aniversario" {{ old('motivo') == 'Aniversario' ? 'selected' : '' }}>Aniversario</option>
                        <option value="Cena de negocios" {{ old('motivo') == 'Cena de negocios' ? 'selected' : '' }}>Cena de negocios</option>
                        <option value="Otro" {{ old('motivo') == 'Otro' ? 'selected' : '' }}>Otro</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-sticky-note"></i> Nota Especial (opcional)
                </label>
                <textarea name="nota" class="form-input" rows="4" placeholder="Ej: mesa cerca de la ventana, decoración especial, etc.">{{ old('nota') }}</textarea>
            </div>

            <div class="form-actions">
                <a href="{{ route('reservas.index') }}" class="btn-secondary">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Guardar Reserva
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
.reserva-form-container {
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

.form-input::placeholder {
    color: rgba(255, 255, 255, 0.6);
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
    align-items: center;
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
    
    .reserva-form-container {
        padding: 1rem;
    }
}
</style>
@endpush

@extends('layouts.empleado')

@section('title', 'Mis Horarios - Empleado')

@section('content')
<div class="horarios-container">
    <div class="horarios-header">
        <h1 class="horarios-title">
            <i class="fas fa-clock"></i>
            Mis Horarios - <span style="color: #000000 !important;">Olla y Sazón</span>
        </h1>
        <p class="horarios-subtitle" style="color: #000000 !important;">
            Consulta tus horarios de trabajo asignados
        </p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif

    <div class="horarios-grid">
        @forelse($horarios as $horario)
            <div class="horario-card">
                <div class="horario-header">
                    <div class="horario-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="horario-day">
                        {{ ucfirst($horario->dia) }}
                    </div>
                </div>
                
                <div class="horario-content">
                    <div class="horario-times">
                        <div class="time-block entrada">
                            <i class="fas fa-sign-in-alt"></i>
                            <div class="time-info">
                                <span class="time-label">Entrada</span>
                                <span class="time-value">{{ $horario->hora_entrada }}</span>
                            </div>
                        </div>
                        
                        <div class="time-separator">
                            <i class="fas fa-arrow-right"></i>
                        </div>
                        
                        <div class="time-block salida">
                            <i class="fas fa-sign-out-alt"></i>
                            <div class="time-info">
                                <span class="time-label">Salida</span>
                                <span class="time-value">{{ $horario->hora_salida }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="horario-meta">
                        <span class="meta-item">
                            <i class="fas fa-hashtag"></i>
                            ID: {{ $horario->id }}
                        </span>
                        @php
                            $entrada = \Carbon\Carbon::parse($horario->hora_entrada);
                            $salida = \Carbon\Carbon::parse($horario->hora_salida);
                            $duracion = $entrada->diffInHours($salida);
                        @endphp
                        <span class="meta-item">
                            <i class="fas fa-hourglass-half"></i>
                            {{ $duracion }} horas
                        </span>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <i class="fas fa-clock empty-icon"></i>
                <h3 class="empty-title">No hay horarios</h3>
                <p class="empty-description">
                    No tienes horarios asignados.
                </p>
            </div>
        @endforelse
    </div>
</div>
@endsection

@push('styles')
<style>
.horarios-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 2rem;
}

.horarios-header {
    text-align: center;
    margin-bottom: 2rem;
    padding: 2rem;
    background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
    border-radius: 20px;
    border: 2px solid var(--color-primary);
}

.horarios-title {
    font-size: 2.5rem;
    color: #000000 !important;
    margin-bottom: 0.5rem;
    font-weight: bold;
}

.horarios-subtitle {
    font-size: 1.1rem;
    color: #000000 !important;
}

.horarios-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 2rem;
}

.horario-card {
    background: #000000 !important;
    border: 2px solid var(--color-primary);
    border-radius: 15px;
    padding: 1.5rem;
    transition: all 0.3s ease;
}

.horario-card:hover {
    border-color: var(--color-primary-light);
    box-shadow: 0 8px 25px rgba(255, 215, 0, 0.3);
    transform: translateY(-5px);
}

.horario-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.horario-icon {
    width: 60px;
    height: 60px;
    background: transparent !important;
    border: 2px solid #ffffff !important;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffffff !important;
    font-size: 1.5rem;
}

.horario-day {
    background: rgba(255, 215, 0, 0.1);
    color: var(--color-primary);
    padding: 0.5rem 1rem;
    border-radius: 15px;
    font-weight: 600;
    font-size: 1.1rem;
}

.horario-times {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.5rem;
    padding: 1rem;
    background: rgba(255, 215, 0, 0.05);
    border-radius: 15px;
}

.time-block {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.time-block i {
    color: var(--color-primary);
    font-size: 1.2rem;
}

.time-info {
    display: flex;
    flex-direction: column;
}

.time-label {
    color: var(--text-muted);
    font-size: 0.8rem;
    font-weight: 600;
}

.time-value {
    color: #ffffff !important;
    font-size: 1.1rem;
    font-weight: bold;
}

.time-separator {
    color: var(--color-primary);
    font-size: 1.5rem;
}

.horario-meta {
    display: flex;
    justify-content: center;
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.3rem;
    color: var(--text-muted);
    font-size: 0.9rem;
}

.meta-item i {
    color: var(--color-primary);
    width: 16px;
}

.empty-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 4rem 2rem;
    background: #000000 !important;
    border: 2px solid var(--color-primary);
    border-radius: 15px;
}

.empty-icon {
    font-size: 5rem;
    color: var(--color-primary);
    margin-bottom: 1rem;
}

.empty-title {
    color: var(--color-primary);
    font-size: 2rem;
    margin-bottom: 0.5rem;
}

.empty-description {
    color: var(--text-muted);
    font-size: 1.1rem;
    margin-bottom: 2rem;
}

.alert {
    padding: 1rem;
    border-radius: 10px;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.alert-success {
    background: rgba(81, 207, 102, 0.1);
    border: 2px solid #51cf66;
    color: #51cf66;
}

.alert-error {
    background: rgba(255, 71, 87, 0.1);
    border: 2px solid #ff4757;
    color: #ff4757;
}

@media (max-width: 768px) {
    .horarios-grid {
        grid-template-columns: 1fr;
    }
    
    .horarios-container {
        padding: 1rem;
    }
    
    .horarios-title {
        font-size: 2rem;
    }
    
    .horario-times {
        flex-direction: column;
        gap: 1rem;
    }
    
    .time-separator {
        transform: rotate(90deg);
    }
}
</style>
@endpush
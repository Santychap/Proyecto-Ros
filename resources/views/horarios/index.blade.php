@extends('layouts.admin')

@section('title', 'Gestión de Horarios - Olla y Sazón')

@section('content')
<div class="horarios-container">
    <div class="horarios-header">
        <h1 class="horarios-title">
            <i class="fas fa-clock"></i>
            Gestión de Horarios - <span style="color: #000000 !important;">Olla y Sazón</span>
        </h1>
        <p class="horarios-subtitle" style="color: #000000 !important;">
            Administra los horarios de trabajo del personal
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

    @if(auth()->user()->rol === 'admin')
        <div class="actions-container">
            <a href="{{ route('horarios.create') }}" class="btn-add-horario">
                <i class="fas fa-plus"></i> Crear Nuevo Horario
            </a>
        </div>

        <!-- Barra de búsqueda -->
        <div class="search-container">
            <form action="{{ route('horarios.index') }}" method="GET" class="search-form">
                <div class="search-input-group">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" name="busqueda" class="search-input" 
                           placeholder="Buscar por empleado o día..." 
                           value="{{ request('busqueda') }}">
                    <button type="submit" class="search-btn">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                </div>
            </form>
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
                    @if(auth()->user()->rol === 'admin')
                        <div class="empleado-info">
                            <h3 class="empleado-nombre">{{ $horario->user->name }}</h3>
                            <p class="empleado-email">{{ $horario->user->email }}</p>
                        </div>
                    @endif
                    
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
                
                @if(auth()->user()->rol === 'admin')
                    <div class="horario-actions">
                        <a href="{{ route('horarios.edit', $horario) }}" class="btn-edit">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <form action="{{ route('horarios.destroy', $horario) }}" method="POST" class="inline-form" 
                              onsubmit="return confirm('¿Seguro que quieres eliminar este horario?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </form>
                    </div>
                @endif
            </div>
        @empty
            <div class="empty-state">
                <i class="fas fa-clock empty-icon"></i>
                <h3 class="empty-title">No hay horarios</h3>
                <p class="empty-description">
                    @if(auth()->user()->rol === 'admin')
                        Aún no has creado horarios para los empleados.
                    @else
                        No tienes horarios asignados.
                    @endif
                </p>
                @if(auth()->user()->rol === 'admin')
                    <a href="{{ route('horarios.create') }}" class="btn-add-horario">
                        <i class="fas fa-plus"></i> Crear Primer Horario
                    </a>
                @endif
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

.actions-container {
    text-align: center;
    margin-bottom: 2rem;
}

.btn-add-horario {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 1rem 2rem;
    background: var(--color-primary);
    color: #000;
    text-decoration: none;
    border-radius: 15px;
    font-weight: 600;
    font-size: 1.1rem;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(255, 215, 0, 0.3);
}

.btn-add-horario:hover {
    background: var(--color-primary-light);
    color: #000;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 215, 0, 0.4);
}

.search-container {
    margin-bottom: 2rem;
}

.search-form {
    max-width: 600px;
    margin: 0 auto;
}

.search-input-group {
    display: flex;
    align-items: center;
    background: var(--bg-glass);
    border: 2px solid var(--color-primary);
    border-radius: 15px;
    overflow: hidden;
}

.search-icon {
    color: var(--color-primary);
    padding: 1rem;
    font-size: 1.2rem;
}

.search-input {
    flex: 1;
    padding: 1rem;
    border: none;
    background: transparent;
    color: var(--text-light);
    font-size: 1rem;
}

.search-input:focus {
    outline: none;
}

.search-input::placeholder {
    color: var(--text-muted);
}

.search-btn {
    padding: 1rem 1.5rem;
    background: var(--color-primary);
    color: #000;
    border: none;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.search-btn:hover {
    background: var(--color-primary-light);
}

.horarios-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 2rem;
}

.horario-card {
    background: #000000 !important;
    border: 2px solid var(--color-primary) !important;
    border-radius: 15px;
    padding: 1.5rem;
    transition: all 0.3s ease;
}

.horario-card:hover {
    border-color: var(--color-primary-light) !important;
    box-shadow: 0 8px 25px rgba(255, 215, 0, 0.3) !important;
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

.empleado-info {
    margin-bottom: 1.5rem;
    text-align: center;
}

.empleado-nombre {
    color: #ffffff !important;
    font-size: 1.3rem;
    font-weight: bold;
    margin-bottom: 0.25rem;
}

.empleado-email {
    color: #cccccc !important;
    font-size: 0.9rem;
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

.horario-actions {
    display: flex;
    gap: 0.5rem;
    width: 100%;
}

.inline-form {
    display: inline;
    flex: 1;
}

.btn-edit, .btn-delete {
    flex: 1;
    padding: 0.8rem 1rem;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.3rem;
    font-size: 0.9rem;
    transition: all 0.3s ease;
}

.btn-edit {
    background: #ffa500;
    color: #000;
}

.btn-edit:hover {
    background: #ff8c00;
    color: #000;
    transform: translateY(-1px);
}

.btn-delete {
    background: #ff4757;
    color: #fff;
}

.btn-delete:hover {
    background: #ff3742;
    transform: translateY(-1px);
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
    
    .horario-actions {
        flex-direction: column;
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
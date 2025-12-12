@extends('layouts.cliente')

@section('title', 'Mis Reservas - Cliente')

@section('content')
<div class="reservas-container">
    <div class="reservas-header">
        <h1 class="reservas-title">
            <i class="fas fa-calendar-check"></i>
            Mis Reservas
        </h1>
        <p class="reservas-subtitle" style="color: #000000 !important;">
            Consulta y gestiona tus reservas
        </p>
    </div>

    {{-- Mensajes flash --}}
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

    {{-- Botón para hacer reserva --}}
    <div class="admin-actions">
        <a href="{{ route('reservas.create') }}" class="btn-primary">
            <i class="fas fa-calendar-plus"></i> Hacer Nueva Reserva
        </a>
    </div>

    {{-- Grid de reservas --}}
    <div class="reservas-grid">
        @forelse ($reservas as $reserva)
            <div class="reserva-card">
                <div class="reserva-header">
                    <div class="reserva-id">#{{ str_pad($reserva->id, 4, '0', STR_PAD_LEFT) }}</div>
                    <div class="reserva-status status-confirmada">
                        Confirmada
                    </div>
                </div>

                <div class="reserva-info">
                    <div class="info-row">
                        <i class="fas fa-calendar info-icon"></i>
                        <span class="info-label">Fecha:</span>
                        <span>{{ $reserva->fecha ? \Carbon\Carbon::parse($reserva->fecha)->format('d/m/Y') : 'N/A' }}</span>
                    </div>

                    <div class="info-row">
                        <i class="fas fa-clock info-icon"></i>
                        <span class="info-label">Hora:</span>
                        <span>{{ $reserva->hora ?? 'N/A' }}</span>
                    </div>

                    <div class="info-row">
                        <i class="fas fa-users info-icon"></i>
                        <span class="info-label">Personas:</span>
                        <span>{{ $reserva->personas ?? 'N/A' }}</span>
                    </div>

                    @if($reserva->mesa_id)
                        <div class="info-row">
                            <i class="fas fa-chair info-icon"></i>
                            <span class="info-label">Mesa:</span>
                            <span>Mesa {{ $reserva->mesa_id }}</span>
                        </div>
                    @endif

                    @if($reserva->comentarios)
                        <div class="info-row">
                            <i class="fas fa-comment info-icon"></i>
                            <span class="info-label">Comentarios:</span>
                            <span>{{ $reserva->comentarios }}</span>
                        </div>
                    @endif

                    <div class="info-row">
                        <i class="fas fa-calendar-plus info-icon"></i>
                        <span class="info-label">Creada:</span>
                        <span>{{ $reserva->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <i class="fas fa-calendar-alt empty-icon"></i>
                <h3 class="empty-title">No hay reservas</h3>
                <p class="empty-description">No has realizado reservas aún.</p>
                <a href="{{ route('reservas.create') }}" class="btn-primary">
                    <i class="fas fa-calendar-plus"></i> Hacer Primera Reserva
                </a>
            </div>
        @endforelse
    </div>
</div>
@endsection

@push('styles')
<style>
.reservas-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
}

.reservas-header {
    text-align: center;
    margin-bottom: 2rem;
    padding: 2rem;
    background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
    border-radius: 20px;
    border: 2px solid var(--color-primary);
}

.reservas-title {
    font-size: 2.5rem;
    color: #000000 !important;
    margin-bottom: 0.5rem;
    font-weight: bold;
}

.reservas-subtitle {
    font-size: 1.1rem;
    color: #000000 !important;
}

.admin-actions {
    margin-bottom: 2rem;
    text-align: center;
}

.btn-primary {
    padding: 1rem 2rem;
    background: var(--color-primary);
    color: #000;
    text-decoration: none;
    border-radius: 10px;
    font-weight: 600;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.reservas-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 2rem;
}

.reserva-card {
    background: #000000 !important;
    border: 2px solid var(--color-primary);
    border-radius: 15px;
    padding: 1.5rem;
    transition: all 0.3s ease;
}

.reserva-card:hover {
    border-color: var(--color-primary-light);
    box-shadow: 0 8px 25px rgba(255, 215, 0, 0.3);
}

.reserva-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid rgba(255, 215, 0, 0.3);
}

.reserva-id {
    font-weight: bold;
    color: var(--color-primary);
    font-size: 1.1rem;
}

.reserva-status {
    padding: 0.3rem 0.8rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: bold;
    text-transform: uppercase;
}

.status-confirmada {
    background: #51cf66;
    color: #000;
}

.info-row {
    display: flex;
    align-items: center;
    margin-bottom: 0.5rem;
    gap: 0.5rem;
}

.info-icon {
    color: var(--color-primary);
    width: 16px;
    text-align: center;
}

.info-label {
    font-weight: 600;
    color: var(--text-light);
    min-width: 80px;
}

.empty-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 3rem;
    background: #000000 !important;
    border: 2px solid var(--color-primary);
    border-radius: 15px;
}

.empty-icon {
    font-size: 4rem;
    color: var(--color-primary);
    margin-bottom: 1rem;
}

.empty-title {
    color: var(--color-primary);
    font-size: 1.5rem;
    margin-bottom: 0.5rem;
}

.empty-description {
    color: var(--text-muted);
    margin-bottom: 1.5rem;
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
    .reservas-grid {
        grid-template-columns: 1fr;
    }
    
    .reservas-container {
        padding: 1rem;
    }
}
</style>
@endpush
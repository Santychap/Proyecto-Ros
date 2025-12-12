@extends('layouts.admin')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/reservas.css') }}">
@endpush

@section('content')
<div class="reservas-container">
    <div class="reservas-header">
        <h1 class="reservas-title">
            <i class="fas fa-calendar-alt"></i>
            @if(Auth::user()->rol === 'admin')
                Gestión de Reservas - <span style="color: #000000 !important;">Olla y Sazón</span>
            @else
                Mis Reservas
            @endif
        </h1>
        <p class="reservas-subtitle" style="color: #000000 !important;">{{ Auth::user()->rol === 'admin' ? 'Administra todas las reservas del restaurante' : 'Gestiona tus reservas de manera eficiente' }}</p>
        @if(Auth::user()->rol === 'admin')
            <div class="stats-quick">
                <div class="stat-item">
                    <span class="stat-number" style="color: #000000 !important;">{{ $reservas->total() }}</span>
                    <span class="stat-label" style="color: #000000 !important;">Total Reservas</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number" style="color: #000000 !important;">{{ $reservas->where('estado', 'Pendiente')->count() }}</span>
                    <span class="stat-label" style="color: #000000 !important;">Pendientes</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number" style="color: #000000 !important;">{{ $reservas->where('estado', 'Confirmada')->count() }}</span>
                    <span class="stat-label" style="color: #000000 !important;">Confirmadas</span>
                </div>
            </div>
        @endif
    </div>

    {{-- Mensaje de éxito --}}
    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    {{-- Filtros y acciones --}}
    <div class="filters-container">
        <div class="filters-grid">
            <div class="filter-group">
                <label class="form-label">Buscar reservas</label>
                <input type="text" class="form-control" placeholder="Buscar por nombre, fecha..." id="searchReservas">
            </div>
            <div class="filter-group">
                <label class="form-label">Estado</label>
                <select class="form-control" id="filterEstado">
                    <option value="">Todos los estados</option>
                    <option value="pendiente">Pendiente</option>
                    <option value="confirmada">Confirmada</option>
                    <option value="cancelada">Cancelada</option>
                </select>
            </div>
            @if(in_array(Auth::user()->rol, ['admin', 'cliente']))
            <div class="filter-group">
                <a href="{{ route('reservas.create') }}" class="btn-reserva btn-primary">
                    <i class="fas fa-plus"></i> Nueva Reserva
                </a>
            </div>
            @endif
        </div>
    </div>

    {{-- Listado de reservas --}}
    <div class="reservas-grid">
        @forelse ($reservas as $reserva)
            <div class="reserva-card">
                <div class="reserva-header">
                    <div class="reserva-id">#{{ str_pad($reserva->id, 4, '0', STR_PAD_LEFT) }}</div>
                    <div class="reserva-status status-{{ $reserva->estado }}">
                        {{ ucfirst($reserva->estado) }}
                    </div>
                </div>
                
                <div class="reserva-info">
                    @if(Auth::user()->rol === 'admin')
                        <div class="info-row">
                            <i class="fas fa-user info-icon"></i>
                            <span class="info-label">Cliente:</span>
                            <span>{{ $reserva->user->name }}</span>
                        </div>
                        <div class="info-row">
                            <i class="fas fa-envelope info-icon"></i>
                            <span class="info-label">Email:</span>
                            <span>{{ $reserva->user->email }}</span>
                        </div>
                    @endif
                    
                    <div class="info-row">
                        <i class="fas fa-calendar info-icon"></i>
                        <span class="info-label">Fecha:</span>
                        <span>{{ \Carbon\Carbon::parse($reserva->fecha)->format('d/m/Y') }}</span>
                    </div>
                    
                    <div class="info-row">
                        <i class="fas fa-clock info-icon"></i>
                        <span class="info-label">Hora:</span>
                        <span>{{ $reserva->hora }}</span>
                    </div>
                    
                    <div class="info-row">
                        <i class="fas fa-users info-icon"></i>
                        <span class="info-label">Personas:</span>
                        <span>{{ $reserva->personas }}</span>
                    </div>
                    
                    <div class="info-row">
                        <i class="fas fa-table info-icon"></i>
                        <span class="info-label">Mesa:</span>
                        <span>
                            @if ($reserva->mesa)
                                {{ $reserva->mesa->codigo ?? 'Mesa ' . $reserva->mesa->id }} ({{ $reserva->mesa->capacidad }} personas)
                            @else
                                No asignada
                            @endif
                        </span>
                    </div>
                    
                    @if($reserva->motivo)
                        <div class="info-row">
                            <i class="fas fa-heart info-icon"></i>
                            <span class="info-label">Motivo:</span>
                            <span>{{ $reserva->motivo }}</span>
                        </div>
                    @endif
                    
                    @if($reserva->nota)
                        <div class="info-row">
                            <i class="fas fa-sticky-note info-icon"></i>
                            <span class="info-label">Nota:</span>
                            <span>{{ $reserva->nota }}</span>
                        </div>
                    @endif
                </div>
                
                <div class="reserva-actions">
                    @can('update', $reserva)
                        <a href="{{ route('reservas.edit', $reserva) }}" class="btn-reserva btn-primary">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                    @endcan
                    
                    @can('delete', $reserva)
                        <form action="{{ route('reservas.destroy', $reserva) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Seguro que deseas eliminar esta reserva?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-reserva btn-danger">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </form>
                    @endcan
                </div>
            </div>
        @empty
            <div class="empty-state" style="grid-column: 1 / -1;">
                <i class="fas fa-calendar-times empty-icon"></i>
                <h3 class="empty-title">No hay reservas</h3>
                <p class="empty-description">No tienes reservas registradas aún.</p>
                @if(in_array(Auth::user()->rol, ['admin', 'cliente']))
                    <a href="{{ route('reservas.create') }}" class="btn-reserva btn-primary">
                        <i class="fas fa-plus"></i> Crear Primera Reserva
                    </a>
                @endif
            </div>
        @endforelse
    </div>

    {{-- Paginación --}}
    @if($reservas->hasPages())
        <div class="pagination-container">
            <div class="pagination">
                {{-- Botón anterior --}}
                @if ($reservas->onFirstPage())
                    <span class="page-link disabled"><i class="fas fa-chevron-left"></i></span>
                @else
                    <a href="{{ $reservas->previousPageUrl() }}" class="page-link"><i class="fas fa-chevron-left"></i></a>
                @endif
                
                {{-- Números de página --}}
                @foreach ($reservas->getUrlRange(1, $reservas->lastPage()) as $page => $url)
                    @if ($page == $reservas->currentPage())
                        <span class="page-link active">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="page-link">{{ $page }}</a>
                    @endif
                @endforeach
                
                {{-- Botón siguiente --}}
                @if ($reservas->hasMorePages())
                    <a href="{{ $reservas->nextPageUrl() }}" class="page-link"><i class="fas fa-chevron-right"></i></a>
                @else
                    <span class="page-link disabled"><i class="fas fa-chevron-right"></i></span>
                @endif
            </div>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchReservas');
    const filterEstado = document.getElementById('filterEstado');
    const reservaCards = document.querySelectorAll('.reserva-card');

    function filterReservas() {
        const searchTerm = searchInput.value.toLowerCase();
        const estadoFilter = filterEstado.value.toLowerCase();

        reservaCards.forEach(card => {
            const cardText = card.textContent.toLowerCase();
            const cardStatus = card.querySelector('.reserva-status').textContent.toLowerCase();
            
            const matchesSearch = searchTerm === '' || cardText.includes(searchTerm);
            const matchesEstado = estadoFilter === '' || cardStatus.includes(estadoFilter);
            
            if (matchesSearch && matchesEstado) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    }

    searchInput.addEventListener('input', filterReservas);
    filterEstado.addEventListener('change', filterReservas);
});
</script>
<style>
.stats-quick {
    display: flex;
    gap: 2rem;
    margin-top: 1rem;
    justify-content: center;
}

.stat-item {
    text-align: center;
    background: rgba(255, 215, 0, 0.1);
    padding: 1rem;
    border-radius: 10px;
    border: 2px solid var(--color-primary);
    min-width: 120px;
}

.stat-number {
    display: block;
    font-size: 2rem;
    font-weight: bold;
    color: var(--color-primary);
}

.stat-label {
    display: block;
    font-size: 0.9rem;
    color: var(--text-light);
    margin-top: 0.5rem;
}

.reserva-card {
    background: #000000 !important;
    border: 3px solid #ffd700 !important;
    border-radius: 15px;
    padding: 1.5rem;
    transition: all 0.3s ease;
    box-shadow: 0 0 20px rgba(255, 215, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.8) inset !important;
}

.reserva-card:hover {
    border-color: #ffd700 !important;
    box-shadow: 0 0 30px rgba(255, 215, 0, 0.5), 0 0 40px rgba(0, 0, 0, 0.8) inset !important;
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
    color: #ffffff !important;
    font-size: 1.1rem;
}

.reserva-status {
    padding: 0.3rem 0.8rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: bold;
    text-transform: uppercase;
}

.status-Pendiente {
    background: #ffa500;
    color: #000;
}

.status-Confirmada {
    background: #51cf66;
    color: #000;
}

.status-Cancelada {
    background: #ff4757;
    color: #fff;
}

.info-row {
    display: flex;
    align-items: center;
    margin-bottom: 0.5rem;
    gap: 0.5rem;
    color: #cccccc !important;
}

.info-icon {
    color: var(--color-primary);
    width: 16px;
    text-align: center;
}

.info-label {
    font-weight: 600;
    color: #cccccc !important;
    min-width: 80px;
}

.reserva-actions {
    display: flex;
    gap: 0.5rem;
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid rgba(255, 215, 0, 0.3);
}

.btn-reserva {
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 8px;
    text-decoration: none;
    font-weight: 600;
    font-size: 0.9rem;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-primary {
    background: var(--color-primary);
    color: #000;
}

.btn-primary:hover {
    background: var(--color-primary-light);
    color: #000;
}

.btn-danger {
    background: #ff4757;
    color: #fff;
}

.btn-danger:hover {
    background: #ff3742;
    color: #fff;
}

/* Botón Nueva Reserva especial */
.filter-group .btn-reserva.btn-primary {
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-light) 100%);
    color: #000000;
    padding: 0.8rem 1.5rem;
    font-size: 1rem;
    font-weight: bold;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(255, 215, 0, 0.3);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
}

.filter-group .btn-reserva.btn-primary:hover {
    background: linear-gradient(135deg, var(--color-primary-light) 0%, #fff 100%);
    color: #000000;
    box-shadow: 0 6px 20px rgba(255, 215, 0, 0.4);
    transform: translateY(-2px);
}

.filter-group .btn-reserva.btn-primary i {
    margin-right: 0.5rem;
    font-size: 1.1rem;
}
</style>
@endpush

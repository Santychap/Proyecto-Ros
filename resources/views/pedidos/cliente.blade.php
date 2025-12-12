@extends('layouts.cliente')

@section('title', 'Mis Pedidos - Cliente')

@section('content')
<div class="pedidos-container">
    <div class="pedidos-header">
        <h1 class="pedidos-title">
            <i class="fas fa-clipboard-list"></i>
            Mis Pedidos
        </h1>
        <p class="pedidos-subtitle" style="color: #000000 !important;">
            Revisa el estado de tus pedidos
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

    {{-- Botón para hacer pedido --}}
    <div class="admin-actions">
        <a href="{{ route('menu.index') }}" class="btn-primary">
            <i class="fas fa-utensils"></i> Ir al menú y hacer pedido
        </a>
    </div>

    {{-- Grid de pedidos --}}
    <div class="pedidos-grid">
        @forelse ($pedidos as $pedido)
            <div class="pedido-card">
                <div class="pedido-header">
                    <div class="pedido-id">#{{ str_pad($pedido->id, 4, '0', STR_PAD_LEFT) }}</div>
                    <div class="pedido-status status-{{ strtolower($pedido->estado) }}">
                        {{ $pedido->estado }}
                    </div>
                </div>

                <div class="pedido-info">
                    <div class="info-row">
                        <i class="fas fa-clock info-icon"></i>
                        <span class="info-label">Fecha:</span>
                        <span>{{ $pedido->created_at->format('d/m/Y H:i') }}</span>
                    </div>

                    @if($pedido->empleado)
                        <div class="info-row">
                            <i class="fas fa-user-tie info-icon"></i>
                            <span class="info-label">Empleado:</span>
                            <span>{{ $pedido->empleado->name }}</span>
                        </div>
                    @endif

                    @if($pedido->comentario)
                        <div class="info-row">
                            <i class="fas fa-comment info-icon"></i>
                            <span class="info-label">Comentario:</span>
                            <span>{{ $pedido->comentario }}</span>
                        </div>
                    @endif

                    <div class="pedido-productos">
                        <h4><i class="fas fa-utensils"></i> Productos:</h4>
                        @foreach ($pedido->detalles as $detalle)
                            <div class="producto-item">
                                <span class="producto-nombre">{{ $detalle->producto->nombre }}</span>
                                <span class="producto-cantidad">x{{ $detalle->cantidad }}</span>
                                <span class="producto-precio">${{ number_format($detalle->producto->precio * $detalle->cantidad, 2) }}</span>
                            </div>
                        @endforeach
                        <div class="total-pedido">
                            <strong>Total: ${{ number_format($pedido->detalles->sum(fn($d) => $d->producto->precio * $d->cantidad), 2) }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <i class="fas fa-clipboard-list empty-icon"></i>
                <h3 class="empty-title">No hay pedidos</h3>
                <p class="empty-description">No has realizado pedidos aún.</p>
                <a href="{{ route('menu.index') }}" class="btn-primary">
                    <i class="fas fa-utensils"></i> Ver Menú
                </a>
            </div>
        @endforelse
    </div>
</div>
@endsection

@push('styles')
<style>
.pedidos-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
}

.pedidos-header {
    text-align: center;
    margin-bottom: 2rem;
    padding: 2rem;
    background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
    border-radius: 20px;
    border: 2px solid var(--color-primary);
}

.pedidos-title {
    font-size: 2.5rem;
    color: #000000 !important;
    margin-bottom: 0.5rem;
    font-weight: bold;
}

.pedidos-subtitle {
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

.pedidos-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 2rem;
}

.pedido-card {
    background: #000000 !important;
    border: 2px solid var(--color-primary);
    border-radius: 15px;
    padding: 1.5rem;
    transition: all 0.3s ease;
}

.pedido-card:hover {
    border-color: var(--color-primary-light);
    box-shadow: 0 8px 25px rgba(255, 215, 0, 0.3);
}

.pedido-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid rgba(255, 215, 0, 0.3);
}

.pedido-id {
    font-weight: bold;
    color: var(--color-primary);
    font-size: 1.1rem;
}

.pedido-status {
    padding: 0.3rem 0.8rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: bold;
    text-transform: uppercase;
}

.status-pendiente {
    background: #ffa500;
    color: #000;
}

.status-pagado {
    background: #51cf66;
    color: #000;
}

.status-cancelado {
    background: #ff4757;
    color: #fff;
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

.pedido-productos {
    margin: 1rem 0;
    padding: 1rem;
    background: rgba(255, 215, 0, 0.1);
    border-radius: 10px;
}

.pedido-productos h4 {
    color: var(--color-primary);
    margin-bottom: 0.5rem;
}

.producto-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.3rem 0;
    border-bottom: 1px solid rgba(255, 215, 0, 0.2);
}

.producto-nombre {
    flex: 1;
    color: var(--text-light);
}

.producto-cantidad {
    color: var(--color-primary);
    font-weight: 600;
    margin: 0 1rem;
}

.producto-precio {
    color: var(--text-light);
    font-weight: 600;
}

.total-pedido {
    text-align: right;
    margin-top: 0.5rem;
    padding-top: 0.5rem;
    border-top: 2px solid var(--color-primary);
    color: var(--color-primary);
    font-size: 1.1rem;
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
    .pedidos-grid {
        grid-template-columns: 1fr;
    }
    
    .pedidos-container {
        padding: 1rem;
    }
}
</style>
@endpush
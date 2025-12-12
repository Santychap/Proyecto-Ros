@extends('layouts.admin')

@section('title', 'Gestión de Pedidos - Olla y Sazón')

@section('content')
<div class="pedidos-container">
    <div class="pedidos-header">
        <h1 class="pedidos-title">
            <i class="fas fa-clipboard-list"></i>
            {{ Auth::user()->rol === 'admin' ? 'Gestión de Pedidos - ' : 'Mis Pedidos' }}
            @if(Auth::user()->rol === 'admin')
                <span style="color: #000000 !important;">Olla y Sazón</span>
            @endif
        </h1>
        <p class="pedidos-subtitle" style="color: #000000 !important;">
            {{ Auth::user()->rol === 'admin' ? 'Administra todos los pedidos del restaurante' : 'Revisa el estado de tus pedidos' }}
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

    {{-- Barra de búsqueda solo para admin --}}
    @if(auth()->user()->rol === 'admin')
        <div class="filters-container">
            <form method="GET" action="{{ route('pedidos.index') }}" class="search-form">
                <div class="search-group">
                    <input type="text" name="search" placeholder="Buscar por cliente, estado..." 
                           value="{{ request('search') }}" class="search-input">
                    <button type="submit" class="btn-search">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                </div>
            </form>
        </div>
    @endif

    {{-- Botón para hacer pedido (cliente) --}}
    @if(auth()->user()->rol === 'cliente')
        <div class="admin-actions">
            <a href="{{ route('menu.index') }}" class="btn-primary">
                <i class="fas fa-utensils"></i> Ir al menú y hacer pedido
            </a>
        </div>
    @endif

    {{-- Grid de pedidos --}}
    <div class="pedidos-grid">
        @forelse ($pedidos as $pedido)
            <div class="pedido-card">
                <div class="pedido-header">
                    <div class="pedido-id">#{{ str_pad($pedido->id, 4, '0', STR_PAD_LEFT) }}</div>
                    <div class="pedido-status status-{{ $pedido->estado === 'Cancelado' ? 'cancelado' : ($pedido->pago && $pedido->pago->estado === 'pagado' ? 'pagado' : 'pendiente') }}">
                        {{ $pedido->estado === 'Cancelado' ? 'CANCELADO' : ($pedido->pago && $pedido->pago->estado === 'pagado' ? 'PAGADO' : 'PENDIENTE') }}
                    </div>
                </div>

                <div class="pedido-info">
                    @if(Auth::user()->rol !== 'cliente')
                        <div class="info-row">
                            <i class="fas fa-user info-icon"></i>
                            <span class="info-label">Cliente:</span>
                            <span>{{ $pedido->user->name }}</span>
                        </div>
                    @endif

                    @if(Auth::user()->rol === 'admin' || Auth::user()->rol === 'empleado')
                        <div class="info-row">
                            <i class="fas fa-user-tie info-icon"></i>
                            <span class="info-label">Empleado:</span>
                            <span>{{ $pedido->empleado ? $pedido->empleado->name : 'Sin asignar' }}</span>
                        </div>
                    @endif

                    <div class="info-row">
                        <i class="fas fa-clock info-icon"></i>
                        <span class="info-label">Fecha:</span>
                        <span>{{ $pedido->created_at->format('d/m/Y H:i') }}</span>
                    </div>

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
                            <strong>Total: ${{ number_format($pedido->total, 2) }}</strong>
                        </div>
                    </div>
                </div>

                {{-- Acciones (para admin o empleado) --}}
                @if(Auth::user()->rol !== 'cliente' && $pedido->estado !== 'Cancelado' && (!$pedido->pago || $pedido->pago->estado !== 'pagado'))
                    <div class="pedido-actions">
                        {{-- Dropdown para cambiar estado de pago --}}
                        @if(!$pedido->pago)
                            {{-- Crear pago en efectivo y cambiar estado --}}
                            <form action="{{ route('pagos.store', $pedido) }}" method="POST" class="inline-form">
                                @csrf
                                <input type="hidden" name="metodo" value="efectivo">
                                <select name="estado_pago" onchange="this.form.submit()" class="status-select">
                                    <option value="pendiente" selected>Pendiente</option>
                                    <option value="pagado">Pagado</option>
                                </select>
                            </form>
                        @else
                            {{-- Cambiar estado de pago existente --}}
                            <form action="{{ route('pagos.cambiarEstado', $pedido->pago) }}" method="POST" class="inline-form">
                                @csrf
                                @method('PUT')
                                <select name="estado" onchange="this.form.submit()" class="status-select">
                                    <option value="pendiente" {{ $pedido->pago->estado === 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="pagado" {{ $pedido->pago->estado === 'pagado' ? 'selected' : '' }}>Pagado</option>
                                </select>
                            </form>
                        @endif

                        {{-- Botón cancelar (solo admin) --}}
                        @if(Auth::user()->rol === 'admin')
                            <form action="{{ route('pedidos.adminCancelar', $pedido) }}" method="POST" class="inline-form"
                                  onsubmit="return confirm('¿Seguro que quieres cancelar este pedido?');">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn-danger">
                                    <i class="fas fa-ban"></i> Cancelar
                                </button>
                            </form>
                        @endif
                    </div>
                @endif
            </div>
        @empty
            <div class="empty-state">
                <i class="fas fa-clipboard-list empty-icon"></i>
                <h3 class="empty-title">No hay pedidos</h3>
                <p class="empty-description">No se encontraron pedidos para mostrar.</p>
                @if(auth()->user()->rol === 'cliente')
                    <a href="{{ route('menu.index') }}" class="btn-primary">
                        <i class="fas fa-utensils"></i> Ver Menú
                    </a>
                @endif
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

.filters-container {
    background: var(--bg-glass);
    border: 2px solid var(--color-primary);
    border-radius: 15px;
    padding: 1.5rem;
    margin-bottom: 2rem;
}

.search-form {
    display: flex;
    justify-content: center;
}

.search-group {
    display: flex;
    gap: 1rem;
    max-width: 500px;
    width: 100%;
}

.search-input {
    flex: 1;
    padding: 1rem;
    border: 2px solid rgba(255, 215, 0, 0.3);
    border-radius: 10px;
    background: rgba(255, 255, 255, 0.1);
    color: var(--text-light);
}

.btn-search {
    padding: 1rem 1.5rem;
    background: var(--color-primary);
    color: #000;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
}

.pedidos-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
    gap: 2rem;
}

.pedido-card {
    background: #000000 !important;
    border: 3px solid #ffd700 !important;
    border-radius: 15px;
    padding: 1.5rem;
    transition: all 0.3s ease;
    box-shadow: 0 0 20px rgba(255, 215, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.8) inset !important;
}

.pedido-card:hover {
    border-color: #ffd700 !important;
    box-shadow: 0 0 30px rgba(255, 215, 0, 0.5), 0 0 40px rgba(0, 0, 0, 0.8) inset !important;
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
    color: #ffffff !important;
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

.status-cancelado {
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
    color: #cccccc !important;
}

.producto-cantidad {
    color: var(--color-primary);
    font-weight: 600;
    margin: 0 1rem;
}

.producto-precio {
    color: #cccccc !important;
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

.pedido-actions {
    display: flex;
    gap: 0.5rem;
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid rgba(255, 215, 0, 0.3);
}

.inline-form {
    display: inline;
}

.status-select {
    padding: 0.5rem;
    border: 2px solid var(--color-primary);
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.1);
    color: var(--text-light);
}

.btn-danger {
    padding: 0.5rem 1rem;
    background: #ff4757;
    color: #fff;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
}

.btn-danger:hover {
    background: #ff3742;
}

.admin-actions {
    margin-top: 1rem;
    text-align: center;
}

.btn-danger-large {
    padding: 1rem 2rem;
    background: #ff4757;
    color: #fff;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 1rem;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
}

.btn-danger-large:hover {
    background: #ff3742;
    transform: translateY(-2px);
    box-shadow: 0 4px 15px rgba(255, 71, 87, 0.4);
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

.empty-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 3rem;
    background: var(--bg-glass);
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
    
    .search-group {
        flex-direction: column;
    }
    
    .pedidos-container {
        padding: 1rem;
    }
}
</style>
@endpush

@extends('layouts.admin')

@section('title', 'Inventario de Productos - Olla y Sazón')

@section('content')
<div class="inventario-container">
    <div class="inventario-header">
        <h1 class="inventario-title">
            <i class="fas fa-boxes"></i>
            Inventario de Productos - <span style="color: #000000 !important;">Olla y Sazón</span>
        </h1>
        <p class="inventario-subtitle" style="color: #000000 !important;">
            Control completo de ingredientes e insumos del restaurante
        </p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="actions-container">
        <a href="{{ route('inventario.productos.create') }}" class="btn-add-product">
            <i class="fas fa-plus"></i> Agregar Producto
        </a>
        <a href="{{ route('inventario.movimientos.create') }}" class="btn-add-movement">
            <i class="fas fa-exchange-alt"></i> Registrar Movimiento
        </a>
        <a href="{{ route('inventario.movimientos.index') }}" class="btn-view-movements">
            <i class="fas fa-history"></i> Ver Movimientos
        </a>
    </div>

    <!-- Estadísticas rápidas -->
    <div class="stats-grid">
        <div class="stat-card agotado">
            <i class="fas fa-exclamation-triangle"></i>
            <div>
                <h3>{{ $stats['agotados'] }}</h3>
                <p>Productos Agotados</p>
            </div>
        </div>
        <div class="stat-card bajo-stock">
            <i class="fas fa-exclamation-circle"></i>
            <div>
                <h3>{{ $stats['bajo_stock'] }}</h3>
                <p>Stock Bajo</p>
            </div>
        </div>
        <div class="stat-card sobre-stock">
            <i class="fas fa-arrow-up"></i>
            <div>
                <h3>{{ $stats['sobre_stock'] }}</h3>
                <p>Sobre Stock</p>
            </div>
        </div>
        <div class="stat-card por-vencer">
            <i class="fas fa-clock"></i>
            <div>
                <h3>{{ $stats['por_vencer'] }}</h3>
                <p>Por Vencer</p>
            </div>
        </div>
        <div class="stat-card total">
            <i class="fas fa-boxes"></i>
            <div>
                <h3>{{ $stats['total'] }}</h3>
                <p>Total Productos</p>
            </div>
        </div>
    </div>

    <!-- Filtros -->
    <div class="filters-container">
        <form method="GET" class="filters-form">
            <div class="filter-group">
                <input type="text" name="codigo" placeholder="Buscar por código..." value="{{ request('codigo') }}">
            </div>
            <div class="filter-group">
                <input type="text" name="nombre" placeholder="Buscar por nombre..." value="{{ request('nombre') }}">
            </div>
            <div class="filter-group">
                <select name="categoria">
                    <option value="">Todas las categorías</option>
                    <option value="proteina" {{ request('categoria') == 'proteina' ? 'selected' : '' }}>Proteína</option>
                    <option value="verdura" {{ request('categoria') == 'verdura' ? 'selected' : '' }}>Verdura</option>
                    <option value="condimento" {{ request('categoria') == 'condimento' ? 'selected' : '' }}>Condimento</option>
                    <option value="lacteo" {{ request('categoria') == 'lacteo' ? 'selected' : '' }}>Lácteo</option>
                    <option value="cereal" {{ request('categoria') == 'cereal' ? 'selected' : '' }}>Cereal</option>
                    <option value="bebida" {{ request('categoria') == 'bebida' ? 'selected' : '' }}>Bebida</option>
                    <option value="limpieza" {{ request('categoria') == 'limpieza' ? 'selected' : '' }}>Limpieza</option>
                    <option value="otro" {{ request('categoria') == 'otro' ? 'selected' : '' }}>Otro</option>
                </select>
            </div>
            <div class="filter-group">
                <select name="estado_stock">
                    <option value="">Todos los estados</option>
                    <option value="agotado" {{ request('estado_stock') == 'agotado' ? 'selected' : '' }}>Agotado</option>
                    <option value="bajo_stock" {{ request('estado_stock') == 'bajo_stock' ? 'selected' : '' }}>Stock Bajo</option>
                    <option value="sobre_stock" {{ request('estado_stock') == 'sobre_stock' ? 'selected' : '' }}>Sobre Stock</option>
                </select>
            </div>
            <div class="filter-actions">
                <button type="submit" class="btn-filter">Filtrar</button>
                <a href="{{ route('inventario.productos.index') }}" class="btn-clear">Limpiar</a>
            </div>
        </form>
    </div>

    <div class="productos-grid">
        @forelse($productos as $producto)
            <div class="producto-card {{ $producto->estado_stock }}">
                <div class="producto-header">
                    <div class="producto-codigo">{{ $producto->codigo }}</div>
                    <div class="categoria-badge" style="background-color: {{ $producto->categoria_color }};">
                        {{ ucfirst($producto->categoria) }}
                    </div>
                </div>
                
                <div class="producto-content">
                    <h3 class="producto-nombre">{{ $producto->nombre }}</h3>
                    @if($producto->descripcion)
                        <p class="producto-descripcion">{{ $producto->descripcion }}</p>
                    @endif
                    
                    <div class="stock-info">
                        <div class="stock-actual">
                            <span class="label">Stock Actual:</span>
                            <span class="value" style="color: {{ $producto->color_estado }};">
                                {{ $producto->stock_actual }} {{ $producto->unidad_medida }}
                            </span>
                        </div>
                        <div class="stock-range">
                            <span class="min">Min: {{ $producto->stock_minimo }}</span>
                            <span class="max">Max: {{ $producto->stock_maximo }}</span>
                        </div>
                    </div>
                    
                    <div class="producto-meta">
                        <div class="meta-item">
                            <i class="fas fa-dollar-sign"></i>
                            <span>${{ number_format($producto->precio_unitario, 2) }}/{{ $producto->unidad_medida }}</span>
                        </div>
                        <div class="meta-item">
                            <i class="fas fa-calculator"></i>
                            <span>Valor: ${{ number_format($producto->valor_total_stock, 2) }}</span>
                        </div>
                        @if($producto->proveedor)
                            <div class="meta-item">
                                <i class="fas fa-truck"></i>
                                <span>{{ $producto->proveedor }}</span>
                            </div>
                        @endif
                        @if($producto->fecha_vencimiento)
                            <div class="meta-item">
                                <i class="fas fa-calendar-alt"></i>
                                <span>Vence: {{ $producto->fecha_vencimiento->format('d/m/Y') }}</span>
                            </div>
                        @endif
                    </div>
                </div>
                
                <div class="producto-actions">
                    <a href="{{ route('inventario.productos.show', $producto) }}" class="btn-view">
                        <i class="fas fa-eye"></i> Ver
                    </a>
                    <a href="{{ route('inventario.productos.edit', $producto) }}" class="btn-edit">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <button class="btn-movement" onclick="openMovementModal({{ $producto->id }}, '{{ $producto->nombre }}', {{ $producto->stock_actual }}, '{{ $producto->unidad_medida }}')">
                        <i class="fas fa-exchange-alt"></i> Movimiento
                    </button>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <i class="fas fa-boxes empty-icon"></i>
                <h3 class="empty-title">No hay productos en el inventario</h3>
                <p class="empty-description">Comienza agregando productos para llevar el control de stock.</p>
                <a href="{{ route('inventario.productos.create') }}" class="btn-add-product">
                    <i class="fas fa-plus"></i> Agregar Primer Producto
                </a>
            </div>
        @endforelse
    </div>

    {{ $productos->links() }}
</div>
@endsection

@push('styles')
<style>
.inventario-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 2rem;
}

.inventario-header {
    text-align: center;
    margin-bottom: 2rem;
    padding: 2rem;
    background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
    border-radius: 20px;
    border: 2px solid var(--color-primary);
}

.inventario-title {
    font-size: 2.5rem;
    color: #000000 !important;
    margin-bottom: 0.5rem;
    font-weight: bold;
    text-shadow: 1px 1px 2px rgba(255,255,255,0.3);
}

.inventario-title i {
    color: #000000 !important;
}

.inventario-subtitle {
    font-size: 1.1rem;
    color: #000000 !important;
    font-weight: 600;
    text-shadow: 1px 1px 2px rgba(255,255,255,0.3);
}

.actions-container {
    display: flex;
    justify-content: center;
    gap: 1rem;
    margin-bottom: 2rem;
    flex-wrap: wrap;
}

.btn-add-product, .btn-add-movement, .btn-view-movements {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 1rem 1.5rem;
    border-radius: 15px;
    font-weight: 600;
    font-size: 1rem;
    transition: all 0.3s ease;
    text-decoration: none;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
}

.btn-add-product {
    background: var(--color-primary);
    color: #000;
}

.btn-add-movement {
    background: #2196f3;
    color: #fff;
}

.btn-view-movements {
    background: #9c27b0;
    color: #fff;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 2rem;
}

.stat-card {
    background: #000000 !important;
    border: 3px solid;
    border-radius: 15px;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    box-shadow: 0 0 20px rgba(255, 215, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.8) inset !important;
}

.stat-card.agotado { border-color: #ff4757; }
.stat-card.bajo-stock { border-color: #ffa502; }
.stat-card.sobre-stock { border-color: #3742fa; }
.stat-card.por-vencer { border-color: #ff6b6b; }
.stat-card.total { border-color: var(--color-primary); }

.stat-card i {
    font-size: 2rem;
}

.stat-card.agotado i { color: #ff4757; }
.stat-card.bajo-stock i { color: #ffa502; }
.stat-card.sobre-stock i { color: #3742fa; }
.stat-card.por-vencer i { color: #ff6b6b; }
.stat-card.total i { color: var(--color-primary); }

.stat-card h3 {
    font-size: 1.8rem;
    font-weight: bold;
    margin: 0;
    color: #ffffff !important;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.8);
}

.stat-card p {
    margin: 0;
    color: #ffffff !important;
    font-size: 0.9rem;
    font-weight: 700;
    text-shadow: 2px 2px 4px rgba(0,0,0,0.8);
}

.filters-container {
    background: #000000 !important;
    border: 3px solid #ffd700 !important;
    border-radius: 15px;
    padding: 1.5rem;
    margin-bottom: 2rem;
    box-shadow: 0 0 20px rgba(255, 215, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.8) inset !important;
}

.filters-form {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    align-items: end;
}

.filter-group input,
.filter-group select {
    width: 100%;
    padding: 0.75rem;
    border: 2px solid #ffd700;
    border-radius: 8px;
    background: #1a1a1a !important;
    color: #ffffff !important;
    font-weight: 600;
    font-size: 0.9rem;
}

.filter-group input::placeholder {
    color: #cccccc !important;
}

.filter-actions {
    display: flex;
    gap: 0.5rem;
}

.btn-filter, .btn-clear {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    font-size: 0.9rem;
}

.btn-filter {
    background: #ffd700;
    color: #000000;
}

.btn-clear {
    background: #6c757d;
    color: #ffffff;
}

.productos-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 2rem;
}

.producto-card {
    background: #000000 !important;
    border: 3px solid #ffd700 !important;
    border-radius: 20px;
    padding: 1.5rem;
    transition: all 0.3s ease;
    box-shadow: 0 0 20px rgba(255, 215, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.8) inset !important;
}

.producto-card.agotado { border-color: #ff4757 !important; }
.producto-card.bajo_stock { border-color: #ffa502 !important; }
.producto-card.sobre_stock { border-color: #3742fa !important; }

.producto-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.producto-codigo {
    background: rgba(255, 215, 0, 0.2);
    color: #ffd700;
    padding: 0.3rem 0.8rem;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
}

.categoria-badge {
    color: #ffffff;
    padding: 0.3rem 0.8rem;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
}

.producto-nombre {
    color: #ffffff !important;
    font-size: 1.4rem;
    font-weight: bold;
    margin-bottom: 0.5rem;
}

.producto-descripcion {
    color: #cccccc !important;
    margin-bottom: 1rem;
    line-height: 1.4;
}

.stock-info {
    background: rgba(255, 215, 0, 0.1);
    padding: 1rem;
    border-radius: 10px;
    margin-bottom: 1rem;
}

.stock-actual {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.5rem;
}

.stock-actual .label {
    color: #cccccc !important;
    font-weight: 600;
}

.stock-actual .value {
    font-weight: 700;
    font-size: 1.1rem;
}

.stock-range {
    display: flex;
    justify-content: space-between;
    font-size: 0.9rem;
    color: #cccccc !important;
}

.producto-meta {
    display: grid;
    gap: 0.5rem;
    margin-bottom: 1rem;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #cccccc !important;
    font-size: 0.9rem;
}

.meta-item i {
    color: var(--color-primary);
    width: 16px;
}

.producto-actions {
    display: flex;
    gap: 0.5rem;
}

.btn-view, .btn-edit, .btn-movement {
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
    font-size: 0.85rem;
    transition: all 0.3s ease;
}

.btn-view {
    background: #17a2b8;
    color: #fff;
}

.btn-edit {
    background: #ffa500;
    color: #000;
}

.btn-movement {
    background: #28a745;
    color: #fff;
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
    background: rgba(76, 175, 80, 0.1);
    border: 2px solid #4caf50;
    color: #4caf50;
}

.empty-state {
    grid-column: 1 / -1;
    text-align: center;
    padding: 4rem 2rem;
    background: var(--bg-glass);
    border: 2px solid var(--color-primary);
    border-radius: 20px;
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

@media (max-width: 768px) {
    .productos-grid {
        grid-template-columns: 1fr;
    }
    
    .inventario-container {
        padding: 1rem;
    }
    
    .inventario-title {
        font-size: 2rem;
    }
    
    .actions-container {
        flex-direction: column;
        align-items: center;
    }
    
    .producto-actions {
        flex-direction: column;
    }
}
</style>
@endpush
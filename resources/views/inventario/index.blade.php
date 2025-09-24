@extends('layouts.admin')

@section('title', 'Gestión de Inventario - Olla y Sazón')

@section('content')
<div class="inventario-container">
    <div class="inventario-header">
        <h1 class="inventario-title">
            <i class="fas fa-boxes"></i>
            Gestión de Inventario
        </h1>
        <p class="inventario-subtitle">
            Control de stock y productos del restaurante
        </p>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div class="actions-container">
        <a href="{{ route('inventario.create') }}" class="btn-add-product">
            <i class="fas fa-plus"></i> Agregar Ingrediente
        </a>
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
                <a href="{{ route('inventario.index') }}" class="btn-clear">Limpiar</a>
            </div>
        </form>
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
                <p>Bajo Stock</p>
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
                <p>Total Ingredientes</p>
            </div>
        </div>
    </div>

    <div class="inventario-table-container">
        @forelse($productos as $item)
            <div class="inventario-card {{ $item->estado }}">
                <div class="item-header">
                    <h3>{{ $item->nombre }}</h3>
                    <span class="estado-badge estado-{{ $item->estado }}">
                        @if($item->estado == 'agotado')
                            <i class="fas fa-times"></i> Agotado
                        @elseif($item->estado == 'por_vencer')
                            <i class="fas fa-clock"></i> Por Vencer
                        @else
                            <i class="fas fa-check"></i> Disponible
                        @endif
                    </span>
                </div>
                
                <div class="item-content">
                    <div class="item-info">
                        <div class="info-row">
                            <span class="label">Código:</span>
                            <span class="value">{{ $item->codigo }}</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Categoría:</span>
                            <span class="tipo-badge" style="background-color: {{ $item->categoria_color }}; color: #ffffff; padding: 2px 8px; border-radius: 10px; font-size: 0.8rem; font-weight: 600;">
                                {{ ucfirst($item->categoria) }}
                            </span>
                        </div>
                        <div class="info-row">
                            <span class="label">Stock Actual:</span>
                            <span class="value" style="color: {{ $item->color_estado }};">{{ $item->stock_actual }} {{ $item->unidad_medida }}</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Stock Mínimo:</span>
                            <span class="value">{{ $item->stock_minimo }} {{ $item->unidad_medida }}</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Stock Máximo:</span>
                            <span class="value">{{ $item->stock_maximo }} {{ $item->unidad_medida }}</span>
                        </div>
                        <div class="info-row">
                            <span class="label">Precio Unitario:</span>
                            <span class="value">${{ number_format($item->precio_unitario, 0) }}</span>
                        </div>
                        @if($item->fecha_vencimiento)
                            <div class="info-row">
                                <span class="label">Vencimiento:</span>
                                <span class="value">{{ $item->fecha_vencimiento->format('d/m/Y') }}</span>
                            </div>
                        @endif
                        @if($item->proveedor)
                            <div class="info-row">
                                <span class="label">Proveedor:</span>
                                <span class="value">{{ $item->proveedor }}</span>
                            </div>
                        @endif
                    </div>
                    
                    <div class="item-actions">
                        <a href="{{ route('inventario.edit', $item) }}" class="btn-edit">
                            <i class="fas fa-edit"></i> Editar
                        </a>
                        <button class="btn-stock" onclick="openStockModal({{ $item->id }}, '{{ $item->nombre }}')">
                            <i class="fas fa-plus-minus"></i> Ajustar Stock
                        </button>
                        <form action="{{ route('inventario.destroy', $item) }}" method="POST" class="inline-form" 
                              onsubmit="return confirm('¿Seguro que quieres eliminar este producto del inventario?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-delete">
                                <i class="fas fa-trash"></i> Eliminar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <i class="fas fa-boxes empty-icon"></i>
                <h3 class="empty-title">No hay ingredientes en el inventario</h3>
                <p class="empty-description">Comienza agregando ingredientes para llevar el control de stock.</p>
                <a href="{{ route('inventario.create') }}" class="btn-add-product">
                    <i class="fas fa-plus"></i> Agregar Primer Ingrediente
                </a>
            </div>
        @endforelse
    </div>

    {{ $productos->links() }}
</div>

<!-- Modal para ajustar stock -->
<div id="stockModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Ajustar Stock</h3>
            <span class="close-modal">&times;</span>
        </div>
        <form id="stockForm" method="POST">
            @csrf
            <div class="modal-body">
                <p id="stockProductName"></p>
                <div class="form-group">
                    <label>Tipo de Movimiento:</label>
                    <select name="tipo" required>
                        <option value="entrada">Entrada (Agregar stock)</option>
                        <option value="salida">Salida (Reducir stock)</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Cantidad:</label>
                    <input type="number" name="cantidad" min="1" required>
                </div>
                <div class="form-group">
                    <label>Motivo:</label>
                    <input type="text" name="motivo" placeholder="Ej: Compra, Venta, Merma, etc." required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn-secondary close-modal">Cancelar</button>
                <button type="submit" class="btn-primary">Ajustar Stock</button>
            </div>
        </form>
    </div>
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
    text-align: center;
    margin-bottom: 2rem;
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

.checkbox-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #ffffff !important;
    font-weight: 600;
    cursor: pointer;
}

.checkbox-label input[type="checkbox"] {
    width: auto;
    margin: 0;
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

.btn-add-product {
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
.stat-card.por-vencer { border-color: #ff6b6b; }
.stat-card.total { border-color: var(--color-primary); }

.stat-card i {
    font-size: 2rem;
}

.stat-card.agotado i { color: #ff4757; }
.stat-card.bajo-stock i { color: #ffa502; }
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

.inventario-table-container {
    display: grid;
    gap: 1.5rem;
}

.inventario-card {
    background: #000000 !important;
    border: 3px solid #ffd700 !important;
    border-radius: 15px;
    padding: 1.5rem;
    transition: all 0.3s ease;
    box-shadow: 0 0 20px rgba(255, 215, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.8) inset !important;
}

.inventario-card.agotado { border-color: #ff4757; }
.inventario-card.por_vencer { border-color: #ff6b6b; }

.item-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.item-header h3 {
    color: #ffffff !important;
    font-size: 1.3rem;
    margin: 0;
}

.estado-badge {
    padding: 0.3rem 0.8rem;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
}

.estado-agotado { background: rgba(255, 71, 87, 0.2); color: #ff4757; }
.estado-por_vencer { background: rgba(255, 107, 107, 0.2); color: #ff6b6b; }
.estado-disponible { background: rgba(76, 175, 80, 0.2); color: #4caf50; }

.item-content {
    display: grid;
    grid-template-columns: 1fr auto;
    gap: 2rem;
    align-items: start;
}

.info-row {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.5rem;
}

.info-row .label {
    color: #cccccc !important;
    font-weight: 600;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.8);
}

.info-row .value {
    color: #ffffff !important;
    font-weight: 700;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.8);
}

.item-actions {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.btn-edit, .btn-stock, .btn-delete {
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.3rem;
    font-size: 0.85rem;
    transition: all 0.3s ease;
    white-space: nowrap;
}

.btn-edit {
    background: #ffa500;
    color: #000000;
    font-weight: 700;
    text-shadow: 1px 1px 2px rgba(255,255,255,0.3);
}

.btn-stock {
    background: #2196f3;
    color: #ffffff;
    font-weight: 700;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
}

.btn-delete {
    background: #ff4757;
    color: #ffffff;
    font-weight: 700;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
}

.modal {
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.8);
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-content {
    background: var(--bg-glass);
    border-radius: 15px;
    max-width: 500px;
    width: 90%;
    box-shadow: 0 8px 25px rgba(255, 215, 0, 0.3);
    border: 2px solid var(--color-primary);
}

.modal-header {
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-light) 100%);
    color: #000;
    padding: 1rem 1.5rem;
    border-radius: 13px 13px 0 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-body {
    padding: 1.5rem;
}

.form-group {
    margin-bottom: 1rem;
}

.form-group label {
    display: block;
    color: var(--color-primary);
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.form-group input,
.form-group select {
    width: 100%;
    padding: 0.75rem;
    border: 2px solid rgba(255, 215, 0, 0.3);
    border-radius: 8px;
    background: rgba(255, 255, 255, 0.95);
    color: #000000;
    font-weight: 600;
}

.modal-footer {
    padding: 1rem 1.5rem;
    display: flex;
    gap: 1rem;
    justify-content: flex-end;
}

.btn-primary, .btn-secondary {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.btn-primary {
    background: var(--color-primary);
    color: #000;
}

.btn-secondary {
    background: rgba(255, 255, 255, 0.2);
    color: #ffffff;
    border: 2px solid rgba(255, 215, 0, 0.5);
    font-weight: 700;
    text-shadow: 1px 1px 2px rgba(0,0,0,0.5);
}

.close-modal {
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    color: #000;
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

@media (max-width: 768px) {
    .item-content {
        grid-template-columns: 1fr;
    }
    
    .item-actions {
        flex-direction: row;
        flex-wrap: wrap;
    }
}
</style>
@endpush

@push('scripts')
<script>
function openStockModal(id, nombre) {
    document.getElementById('stockProductName').textContent = 'Producto: ' + nombre;
    document.getElementById('stockForm').action = '/inventario/' + id + '/ajustar-stock';
    document.getElementById('stockModal').style.display = 'flex';
}

document.querySelectorAll('.close-modal').forEach(btn => {
    btn.addEventListener('click', function() {
        document.getElementById('stockModal').style.display = 'none';
    });
});

window.addEventListener('click', function(e) {
    const modal = document.getElementById('stockModal');
    if (e.target === modal) {
        modal.style.display = 'none';
    }
});
</script>
@endpush
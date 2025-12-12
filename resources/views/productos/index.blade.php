@extends('layouts.admin')

@section('title', 'Gestión de Productos - Olla y Sazón')

@section('content')
<div class="productos-container">
    <div class="productos-header">
        <h1 class="productos-title">
            <i class="fas fa-utensils"></i>
            Gestión de Productos - <span style="color: #000000 !important;">Olla y Sazón</span>
        </h1>
        <p class="productos-subtitle" style="color: #000000 !important;">
            Administra todos los productos del menú
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

    <div class="actions-container">
        <a href="{{ route('productos.create') }}" class="btn-add-product">
            <i class="fas fa-plus"></i> Agregar Nuevo Producto
        </a>
    </div>

    <div class="productos-grid">
        @forelse($productos as $producto)
            <div class="producto-card">
                <div class="producto-image">
                    @if($producto->hasImage())
                        <img src="{{ $producto->image_url }}" alt="{{ $producto->nombre }}" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div class="no-image" style="display: none;">
                            <i class="fas fa-image"></i>
                            <span>Imagen no encontrada</span>
                        </div>
                    @else
                        <div class="no-image">
                            <i class="fas fa-image"></i>
                            <span>Sin imagen</span>
                        </div>
                    @endif
                    <div class="producto-category">
                        {{ $producto->categoria->nombre ?? 'Sin categoría' }}
                    </div>
                </div>
                
                <div class="producto-content">
                    <h3 class="producto-nombre">{{ $producto->nombre }}</h3>
                    <p class="producto-descripcion">{{ $producto->descripcion }}</p>
                    
                    @if($producto->ingredientes)
                        <div class="producto-ingredientes">
                            <i class="fas fa-list"></i>
                            <strong>Ingredientes:</strong> {{ $producto->ingredientes }}
                        </div>
                    @endif
                    
                    <div class="producto-info">
                        <div class="info-item">
                            <i class="fas fa-dollar-sign"></i>
                            <span class="precio">${{ number_format($producto->precio, 2) }}</span>
                        </div>
                        <div class="info-item">
                            <i class="fas fa-boxes"></i>
                            <span>Stock: {{ $producto->stock }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="producto-actions">
                    <a href="{{ route('productos.edit', $producto) }}" class="btn-edit">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <form action="{{ route('productos.destroy', $producto) }}" method="POST" class="inline-form" 
                          onsubmit="return confirm('¿Seguro que quieres eliminar este producto?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete">
                            <i class="fas fa-trash"></i> Eliminar
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="empty-state">
                <i class="fas fa-utensils empty-icon"></i>
                <h3 class="empty-title">No hay productos</h3>
                <p class="empty-description">Aún no has agregado productos al menú.</p>
                <a href="{{ route('productos.create') }}" class="btn-add-product">
                    <i class="fas fa-plus"></i> Agregar Primer Producto
                </a>
            </div>
        @endforelse
    </div>
</div>
@endsection

@push('styles')
<style>
.productos-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 2rem;
}

.productos-header {
    text-align: center;
    margin-bottom: 2rem;
    padding: 2rem;
    background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
    border-radius: 20px;
    border: 2px solid var(--color-primary);
}

.productos-title {
    font-size: 2.5rem;
    color: #000000 !important;
    margin-bottom: 0.5rem;
    font-weight: bold;
}

.productos-subtitle {
    font-size: 1.1rem;
    color: #000000 !important;
}

.actions-container {
    text-align: center;
    margin-bottom: 2rem;
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

.btn-add-product:hover {
    background: var(--color-primary-light);
    color: #000;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 215, 0, 0.4);
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
    overflow: hidden;
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
    box-shadow: 0 0 20px rgba(255, 215, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.8) inset !important;
}

.producto-card:hover {
    border-color: #ffd700 !important;
    box-shadow: 0 0 30px rgba(255, 215, 0, 0.5), 0 0 40px rgba(0, 0, 0, 0.8) inset !important;
    transform: translateY(-5px);
}

.producto-image {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.producto-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.producto-card:hover .producto-image img {
    transform: scale(1.05);
}

.no-image {
    width: 100%;
    height: 100%;
    background: rgba(255, 215, 0, 0.1);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: var(--color-primary);
    font-size: 1.2rem;
    text-align: center;
    padding: 1rem;
}

.no-image small {
    font-size: 0.7rem;
    color: var(--text-muted);
    margin-top: 0.5rem;
    word-break: break-all;
    max-width: 100%;
}

.no-image i {
    font-size: 3rem;
    margin-bottom: 0.5rem;
}

.producto-category {
    position: absolute;
    top: 10px;
    right: 10px;
    background: var(--color-primary);
    color: #000;
    padding: 0.3rem 0.8rem;
    border-radius: 15px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
}

.producto-content {
    padding: 1.5rem;
    flex: 1;
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
    line-height: 1.5;
}

.producto-ingredientes {
    background: rgba(255, 215, 0, 0.1);
    padding: 0.8rem;
    border-radius: 10px;
    margin-bottom: 1rem;
    color: var(--text-light);
    font-size: 0.9rem;
    line-height: 1.4;
}

.producto-ingredientes i {
    color: var(--color-primary);
    margin-right: 0.5rem;
}

.producto-info {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.info-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: #cccccc !important;
}

.info-item i {
    color: var(--color-primary);
}

.precio {
    font-size: 1.3rem;
    font-weight: bold;
    color: #ffd700 !important;
}

.producto-actions {
    padding: 1rem 1.5rem;
    border-top: 1px solid rgba(255, 215, 0, 0.3);
    display: flex;
    gap: 0.5rem;
}

.inline-form {
    display: inline;
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
    .productos-grid {
        grid-template-columns: 1fr;
    }
    
    .productos-container {
        padding: 1rem;
    }
    
    .productos-title {
        font-size: 2rem;
    }
    
    .producto-info {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
}
</style>
@endpush

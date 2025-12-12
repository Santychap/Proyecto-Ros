@extends('layouts.admin')

@section('title', 'Gestión de Categorías - Olla y Sazón')

@section('content')
<div class="categorias-container">
    <div class="categorias-header">
        <h1 class="categorias-title">
            <i class="fas fa-tags"></i>
            Gestión de Categorías - <span style="color: #000000 !important;">Olla y Sazón</span>
        </h1>
        <p class="categorias-subtitle" style="color: #000000 !important;">
            Administra las categorías de productos del menú
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
        <a href="{{ route('categorias.create') }}" class="btn-add-categoria">
            <i class="fas fa-plus"></i> Crear Nueva Categoría
        </a>
    </div>

    <div class="categorias-grid">
        @forelse($categorias as $categoria)
            <div class="categoria-card">
                <div class="categoria-icon">
                    <i class="fas fa-tag"></i>
                </div>
                
                <div class="categoria-content">
                    <h3 class="categoria-nombre">{{ $categoria->nombre }}</h3>
                    
                    <div class="categoria-meta">
                        <span class="meta-item">
                            <i class="fas fa-hashtag"></i>
                            ID: {{ $categoria->id }}
                        </span>
                        <span class="meta-item">
                            <i class="fas fa-utensils"></i>
                            {{ $categoria->productos_count ?? 0 }} productos
                        </span>
                    </div>
                </div>
                
                <div class="categoria-actions">
                    <a href="{{ route('categorias.edit', $categoria) }}" class="btn-edit">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <form action="{{ route('categorias.destroy', $categoria) }}" method="POST" class="inline-form" 
                          onsubmit="return confirm('¿Seguro que quieres eliminar esta categoría?');">
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
                <i class="fas fa-tags empty-icon"></i>
                <h3 class="empty-title">No hay categorías</h3>
                <p class="empty-description">Aún no has creado categorías para organizar tus productos.</p>
                <a href="{{ route('categorias.create') }}" class="btn-add-categoria">
                    <i class="fas fa-plus"></i> Crear Primera Categoría
                </a>
            </div>
        @endforelse
    </div>
</div>
@endsection

@push('styles')
<style>
.categorias-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
}

.categorias-header {
    text-align: center;
    margin-bottom: 2rem;
    padding: 2rem;
    background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
    border-radius: 20px;
    border: 2px solid var(--color-primary);
}

.categorias-title {
    font-size: 2.5rem;
    color: #000000 !important;
    margin-bottom: 0.5rem;
    font-weight: bold;
}

.categorias-subtitle {
    font-size: 1.1rem;
    color: #000000 !important;
}

.actions-container {
    text-align: center;
    margin-bottom: 2rem;
}

.btn-add-categoria {
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

.btn-add-categoria:hover {
    background: var(--color-primary-light);
    color: #000;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 215, 0, 0.4);
}

.categorias-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
}

.categoria-card {
    background: #000000 !important;
    border: 3px solid #ffd700 !important;
    border-radius: 20px;
    padding: 1.5rem;
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
    align-items: center;
    text-align: center;
    box-shadow: 0 0 20px rgba(255, 215, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.8) inset !important;
}

.categoria-card:hover {
    border-color: #ffd700 !important;
    box-shadow: 0 0 30px rgba(255, 215, 0, 0.5), 0 0 40px rgba(0, 0, 0, 0.8) inset !important;
    transform: translateY(-5px);
}

.categoria-icon {
    width: 80px;
    height: 80px;
    background: transparent !important;
    border: 2px solid #ffffff !important;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffffff !important;
    font-size: 2.5rem;
    margin-bottom: 1rem;
}

.categoria-content {
    flex: 1;
    margin-bottom: 1.5rem;
}

.categoria-nombre {
    color: #ffffff !important;
    font-size: 1.5rem;
    font-weight: bold;
    margin-bottom: 1rem;
}

.categoria-meta {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    align-items: center;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.3rem;
    color: #cccccc !important;
    font-size: 0.9rem;
}

.meta-item i {
    color: var(--color-primary);
    width: 16px;
}

.categoria-actions {
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
    .categorias-grid {
        grid-template-columns: 1fr;
    }
    
    .categorias-container {
        padding: 1rem;
    }
    
    .categorias-title {
        font-size: 2rem;
    }
    
    .categoria-actions {
        flex-direction: column;
    }
}
</style>
@endpush
@extends('layouts.admin')

@section('title', 'Gestión de Mesas - Olla y Sazón')

@section('content')
<div class="mesas-container">
    <div class="mesas-header">
        <h1 class="mesas-title">
            <i class="fas fa-chair"></i>
            Gestión de Mesas - <span style="color: #000000 !important;">Olla y Sazón</span>
        </h1>
        <p class="mesas-subtitle" style="color: #000000 !important;">
            Administra todas las mesas del restaurante
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
        <a href="{{ route('mesas.create') }}" class="btn-add-mesa">
            <i class="fas fa-plus"></i> Agregar Nueva Mesa
        </a>
    </div>

    <div class="mesas-grid">
        @forelse($mesas as $mesa)
            <div class="mesa-card">
                <div class="mesa-icon">
                    <i class="fas fa-chair"></i>
                </div>
                
                <div class="mesa-info">
                    <h3 class="mesa-codigo">Mesa {{ $mesa->codigo }}</h3>
                    
                    <div class="info-row">
                        <i class="fas fa-users info-icon"></i>
                        <span>Capacidad: {{ $mesa->capacidad }} personas</span>
                    </div>
                    
                    <div class="info-row">
                        <i class="fas fa-info-circle info-icon"></i>
                        <span>Estado: Disponible</span>
                    </div>
                    
                    @if($mesa->descripcion)
                        <div class="info-row">
                            <i class="fas fa-comment info-icon"></i>
                            <span>{{ $mesa->descripcion }}</span>
                        </div>
                    @endif
                </div>
                
                <div class="mesa-actions">
                    <a href="{{ route('mesas.edit', $mesa) }}" class="btn-edit">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <form action="{{ route('mesas.destroy', $mesa) }}" method="POST" class="inline-form" 
                          onsubmit="return confirm('¿Seguro que quieres eliminar esta mesa?');">
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
                <i class="fas fa-chair empty-icon"></i>
                <h3 class="empty-title">No hay mesas</h3>
                <p class="empty-description">Aún no has agregado mesas al restaurante.</p>
                <a href="{{ route('mesas.create') }}" class="btn-add-mesa">
                    <i class="fas fa-plus"></i> Agregar Primera Mesa
                </a>
            </div>
        @endforelse
    </div>

    @if($mesas->hasPages())
        <div class="pagination-container">
            {{ $mesas->links() }}
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
.mesas-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
}

.mesas-header {
    text-align: center;
    margin-bottom: 2rem;
    padding: 2rem;
    background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
    border-radius: 20px;
    border: 2px solid var(--color-primary);
}

.mesas-title {
    font-size: 2.5rem;
    color: #000000 !important;
    margin-bottom: 0.5rem;
    font-weight: bold;
}

.mesas-subtitle {
    font-size: 1.1rem;
    color: #000000 !important;
}

.actions-container {
    text-align: center;
    margin-bottom: 2rem;
}

.btn-add-mesa {
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

.btn-add-mesa:hover {
    background: var(--color-primary-light);
    color: #000;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 215, 0, 0.4);
}

.mesas-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
    gap: 2rem;
}

.mesa-card {
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

.mesa-card:hover {
    border-color: #ffd700 !important;
    box-shadow: 0 0 30px rgba(255, 215, 0, 0.5), 0 0 40px rgba(0, 0, 0, 0.8) inset !important;
    transform: translateY(-5px);
}

.mesa-icon {
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

.mesa-info {
    flex: 1;
    margin-bottom: 1.5rem;
}

.mesa-codigo {
    color: #ffffff !important;
    font-size: 1.5rem;
    font-weight: bold;
    margin-bottom: 1rem;
}

.info-row {
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 0.5rem;
    gap: 0.5rem;
    color: #cccccc !important;
}

.info-icon {
    color: var(--color-primary);
    width: 16px;
    text-align: center;
}

.mesa-actions {
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

.pagination-container {
    display: flex;
    justify-content: center;
    margin-top: 2rem;
}

@media (max-width: 768px) {
    .mesas-grid {
        grid-template-columns: 1fr;
    }
    
    .mesas-container {
        padding: 1rem;
    }
    
    .mesas-title {
        font-size: 2rem;
    }
    
    .mesa-actions {
        flex-direction: column;
    }
}
</style>
@endpush
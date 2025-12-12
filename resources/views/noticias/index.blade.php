@extends('layouts.admin')

@section('title', 'Gestión de Noticias - Olla y Sazón')

@section('content')
<div class="noticias-container">
    <div class="noticias-header">
        <h1 class="noticias-title">
            <i class="fas fa-newspaper"></i>
            Gestión de Noticias - <span style="color: #000000 !important;">Olla y Sazón</span>
        </h1>
        <p class="noticias-subtitle" style="color: #000000 !important;">
            Administra todas las noticias y anuncios del restaurante
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
        <a href="{{ route('noticias.create') }}" class="btn-add-noticia">
            <i class="fas fa-plus"></i> Crear Nueva Noticia
        </a>
    </div>

    <div class="noticias-grid">
        @forelse($noticias as $noticia)
            <div class="noticia-card">
                <div class="noticia-header">
                    <div class="noticia-icon">
                        <i class="fas fa-newspaper"></i>
                    </div>
                    <div class="noticia-date">
                        {{ $noticia->created_at->format('d/m/Y') }}
                    </div>
                </div>
                
                <div class="noticia-content">
                    <h3 class="noticia-titulo">{{ $noticia->titulo }}</h3>
                    <p class="noticia-contenido">{{ Str::limit($noticia->contenido, 120) }}</p>
                    
                    <div class="noticia-meta">
                        <span class="meta-item">
                            <i class="fas fa-calendar"></i>
                            {{ $noticia->created_at->diffForHumans() }}
                        </span>
                        <span class="meta-item">
                            <i class="fas fa-eye"></i>
                            Publicada
                        </span>
                    </div>
                </div>
                
                <div class="noticia-actions">
                    <a href="{{ route('noticias.edit', $noticia) }}" class="btn-edit">
                        <i class="fas fa-edit"></i> Editar
                    </a>
                    <form action="{{ route('noticias.destroy', $noticia) }}" method="POST" class="inline-form" 
                          onsubmit="return confirm('¿Seguro que quieres eliminar esta noticia?');">
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
                <i class="fas fa-newspaper empty-icon"></i>
                <h3 class="empty-title">No hay noticias</h3>
                <p class="empty-description">Aún no has creado noticias para el restaurante.</p>
                <a href="{{ route('noticias.create') }}" class="btn-add-noticia">
                    <i class="fas fa-plus"></i> Crear Primera Noticia
                </a>
            </div>
        @endforelse
    </div>

    @if($noticias->hasPages())
        <div class="pagination-container">
            {{ $noticias->links() }}
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
.noticias-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
}

.noticias-header {
    text-align: center;
    margin-bottom: 2rem;
    padding: 2rem;
    background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
    border-radius: 20px;
    border: 2px solid var(--color-primary);
}

.noticias-title {
    font-size: 2.5rem;
    color: #000000 !important;
    margin-bottom: 0.5rem;
    font-weight: bold;
}

.noticias-subtitle {
    font-size: 1.1rem;
    color: #000000 !important;
}

.actions-container {
    text-align: center;
    margin-bottom: 2rem;
}

.btn-add-noticia {
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

.btn-add-noticia:hover {
    background: var(--color-primary-light);
    color: #000;
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(255, 215, 0, 0.4);
}

.noticias-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 2rem;
}

.noticia-card {
    background: #000000 !important;
    border: 3px solid #ffd700 !important;
    border-radius: 20px;
    padding: 1.5rem;
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
    box-shadow: 0 0 20px rgba(255, 215, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.8) inset !important;
}

.noticia-card:hover {
    border-color: #ffd700 !important;
    box-shadow: 0 0 30px rgba(255, 215, 0, 0.5), 0 0 40px rgba(0, 0, 0, 0.8) inset !important;
    transform: translateY(-5px);
}

.noticia-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.noticia-icon {
    width: 50px;
    height: 50px;
    background: transparent !important;
    border: 2px solid #ffffff !important;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffffff !important;
    font-size: 1.2rem;
}

.noticia-date {
    background: rgba(255, 215, 0, 0.1);
    color: var(--color-primary);
    padding: 0.3rem 0.8rem;
    border-radius: 15px;
    font-size: 0.9rem;
    font-weight: 600;
}

.noticia-content {
    flex: 1;
    margin-bottom: 1.5rem;
}

.noticia-titulo {
    color: #ffffff !important;
    font-size: 1.3rem;
    font-weight: bold;
    margin-bottom: 0.8rem;
    line-height: 1.3;
}

.noticia-contenido {
    color: #cccccc !important;
    line-height: 1.6;
    margin-bottom: 1rem;
}

.noticia-meta {
    display: flex;
    gap: 1rem;
    flex-wrap: wrap;
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
}

.noticia-actions {
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
    .noticias-grid {
        grid-template-columns: 1fr;
    }
    
    .noticias-container {
        padding: 1rem;
    }
    
    .noticias-title {
        font-size: 2rem;
    }
    
    .noticia-actions {
        flex-direction: column;
    }
    
    .noticia-meta {
        justify-content: center;
    }
}
</style>
@endpush
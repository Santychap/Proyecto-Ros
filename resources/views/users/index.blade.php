@extends('layouts.admin')

@section('title', 'Gestión de Usuarios - Olla y Sazón')

@section('content')
<div class="usuarios-container">
    <div class="usuarios-header">
        <h1 class="usuarios-title">
            <i class="fas fa-users"></i>
            Gestión de Usuarios - <span style="color: #000000 !important;">Olla y Sazón</span>
        </h1>
        <p class="usuarios-subtitle" style="color: #000000 !important;">
            Administra todos los usuarios del sistema
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

    <div class="filters-container">
        <div class="actions-row">
            <a href="{{ route('users.create') }}" class="btn-primary">
                <i class="fas fa-user-plus"></i> Crear Usuario
            </a>

            <form method="GET" action="{{ route('users.index') }}" class="search-form">
                <div class="search-group">
                    <input type="text" name="search" placeholder="Buscar por nombre o correo..."
                        value="{{ request('search') }}" class="search-input">
                    <button type="submit" class="btn-search">
                        <i class="fas fa-search"></i> Buscar
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="usuarios-grid">
        @forelse ($users as $user)
            <div class="usuario-card">
                <div class="usuario-header">
                    <div class="usuario-avatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="usuario-rol rol-{{ strtolower($user->rol) }}">
                        {{ ucfirst($user->rol) }}
                    </div>
                </div>

                <div class="usuario-info">
                    <h3 class="usuario-nombre">{{ $user->name }}</h3>
                    <div class="info-row">
                        <i class="fas fa-envelope info-icon"></i>
                        <span>{{ $user->email }}</span>
                    </div>
                    <div class="info-row">
                        <i class="fas fa-id-badge info-icon"></i>
                        <span>ID: {{ $user->id }}</span>
                    </div>
                    <div class="info-row">
                        <i class="fas fa-calendar info-icon"></i>
                        <span>Registrado: {{ $user->created_at->format('d/m/Y') }}</span>
                    </div>
                    <div class="info-row">
                        <i class="fas fa-user-check info-icon"></i>
                        @if ($user->estado)
                            <span class="badge bg-success">Activo</span>
                        @else
                            <span class="badge bg-secondary">Inhabilitado</span>
                        @endif
                    </div>
                </div>

                <div class="usuario-actions">
                    <a href="{{ route('users.edit', $user) }}" class="btn-edit">
                        <i class="fas fa-edit"></i> Editar
                    </a>

                    {{-- Activar / Inhabilitar --}}
                    @if ($user->estado)
                        <form action="{{ route('users.deactivate', $user->id) }}" method="POST" class="inline-form"
                            onsubmit="return confirm('¿Inhabilitar este usuario?');">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn-delete">
                                <i class="fas fa-user-slash"></i> Inhabilitar
                            </button>
                        </form>
                    @else
                        <form action="{{ route('users.activate', $user->id) }}" method="POST" class="inline-form"
                            onsubmit="return confirm('¿Activar este usuario?');">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn-edit" style="background:#2ed573;color:#fff;">
                                <i class="fas fa-user-check"></i> Activar
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        @empty
            <div class="empty-state">
                <i class="fas fa-users empty-icon"></i>
                <h3 class="empty-title">No hay usuarios</h3>
                <p class="empty-description">No se encontraron usuarios para mostrar.</p>
                <a href="{{ route('users.create') }}" class="btn-primary">
                    <i class="fas fa-user-plus"></i> Crear Primer Usuario
                </a>
            </div>
        @endforelse
    </div>

    @if($users->hasPages())
        <div class="pagination-container">
            {{ $users->withQueryString()->links() }}
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
.usuarios-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem;
}

.usuarios-header {
    text-align: center;
    margin-bottom: 2rem;
    padding: 2rem;
    background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
    border-radius: 20px;
    border: 2px solid var(--color-primary);
}

.usuarios-title {
    font-size: 2.5rem;
    color: #000000 !important;
    margin-bottom: 0.5rem;
    font-weight: bold;
}

.usuarios-subtitle {
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

.actions-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 2rem;
}

.search-form {
    flex: 1;
    max-width: 400px;
}

.search-group {
    display: flex;
    gap: 1rem;
}

.search-input {
    flex: 1;
    padding: 1rem;
    border: 2px solid rgba(255, 215, 0, 0.3);
    border-radius: 10px;
    background: rgba(255, 255, 255, 0.1);
    color: var(--text-light);
}

.btn-search, .btn-primary {
    padding: 1rem 1.5rem;
    background: var(--color-primary);
    color: #000;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
}

.btn-search:hover, .btn-primary:hover {
    background: var(--color-primary-light);
    color: #000;
}

.usuarios-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 2rem;
}

.usuario-card {
    background: #000000 !important;
    border: 3px solid #ffd700 !important;
    border-radius: 15px;
    padding: 1.5rem;
    transition: all 0.3s ease;
    box-shadow: 0 0 20px rgba(255, 215, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.8) inset !important;
}

.usuario-card:hover {
    border-color: #ffd700 !important;
    box-shadow: 0 0 30px rgba(255, 215, 0, 0.5), 0 0 40px rgba(0, 0, 0, 0.8) inset !important;
}

.usuario-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 1px solid rgba(255, 215, 0, 0.3);
}

.usuario-avatar {
    width: 50px;
    height: 50px;
    background: transparent !important;
    border: 2px solid #ffffff !important;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffffff !important;
    font-size: 1.5rem;
}

.usuario-rol {
    padding: 0.3rem 0.8rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: bold;
    text-transform: uppercase;
}

.rol-admin {
    background: #ff4757;
    color: #fff;
}

.rol-empleado {
    background: #3742fa;
    color: #fff;
}

.rol-cliente {
    background: #2ed573;
    color: #fff;
}

.usuario-nombre {
    color: #ffffff !important;
    font-size: 1.3rem;
    margin-bottom: 1rem;
    font-weight: bold;
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

.usuario-actions {
    display: flex;
    gap: 0.5rem;
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid rgba(255, 215, 0, 0.3);
}

.inline-form {
    display: inline;
}

.btn-edit, .btn-delete {
    padding: 0.5rem 1rem;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
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
}

.btn-delete {
    background: #ff4757;
    color: #fff;
}

.btn-delete:hover {
    background: #ff3742;
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

.pagination-container {
    display: flex;
    justify-content: center;
    margin-top: 2rem;
}

@media (max-width: 768px) {
    .usuarios-grid {
        grid-template-columns: 1fr;
    }
    
    .actions-row {
        flex-direction: column;
        gap: 1rem;
    }
    
    .search-form {
        max-width: 100%;
    }
    
    .search-group {
        flex-direction: column;
    }
    
    .usuarios-container {
        padding: 1rem;
    }
}
</style>
@endpush

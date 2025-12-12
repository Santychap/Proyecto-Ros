@extends('layouts.admin')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
@endpush

@section('content')
<div class="dashboard-main" style="padding: 30px; width: 100%;">
    <!-- Header -->
    <div style="margin-bottom: 30px;">
        <h1 class="title-primary" style="display: flex; align-items: center; gap: 15px; margin-bottom: 10px;">
            <i class="fas fa-tags"></i>
            Gestión de Promociones
        </h1>
        <p style="color: #000000; font-size: 1.1rem; margin: 0;">
            Administra todas las promociones del restaurante
        </p>
    </div>

    @if(session('success'))
        <div style="background: rgba(76, 175, 80, 0.2); border: 1px solid #4caf50; color: #4caf50; padding: 15px; border-radius: 8px; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
            <i class="fas fa-check-circle"></i>{{ session('success') }}
        </div>
    @endif

    <!-- Botón Crear -->
    <div style="margin-bottom: 30px;">
        <a href="{{ route('promociones.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i>Crear Promoción
        </a>
    </div>

    @if($promociones->count() > 0)
        <!-- Grid de Promociones -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 25px; margin-bottom: 30px;">
            @foreach ($promociones as $promocion)
                <div class="promo-card">
                    <div class="promo-header">
                        <h3 class="promo-title">{{ $promocion->titulo }}</h3>
                        <div class="promo-discount">{{ $promocion->descuento ?? 0 }}%</div>
                    </div>
                    <div class="promo-content">
                        <div class="promo-dates">
                            <div class="promo-date">
                                <i class="fas fa-calendar-alt"></i>
                                <span>Inicio: {{ $promocion->fecha_inicio->format('d/m/Y') }}</span>
                            </div>
                            <div class="promo-date">
                                <i class="fas fa-calendar-times"></i>
                                <span>Fin: {{ $promocion->fecha_fin->format('d/m/Y') }}</span>
                            </div>
                        </div>
                        @if($promocion->descripcion)
                            <p class="promo-description">{{ $promocion->descripcion }}</p>
                        @endif
                    </div>
                    <div class="promo-actions">
                        <a href="{{ route('promociones.edit', $promocion) }}" class="btn-action btn-edit" title="Editar">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('promociones.destroy', $promocion) }}" method="POST" style="display: inline;" onsubmit="return confirm('¿Eliminar promoción?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-action btn-delete" title="Eliminar">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <!-- Estado vacío -->
        <div class="chart-container" style="text-align: center; padding: 60px 40px;">
            <div class="empty-state">
                <i class="fas fa-tags"></i>
                <h3>No hay promociones registradas</h3>
                <p style="margin-bottom: 30px;">Crea tu primera promoción para atraer más clientes</p>
                <a href="{{ route('promociones.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i>Crear Primera Promoción
                </a>
            </div>
        </div>
    @endif

    <!-- Paginación -->
    <div style="margin-top: 30px; display: flex; justify-content: center;">
        {{ $promociones->links() }}
    </div>
</div>
<style>
.promo-card {
    background: #000000 !important;
    border: 3px solid #ffd700 !important;
    border-radius: 15px;
    padding: 20px;
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
    min-height: 200px;
    box-shadow: 0 0 20px rgba(255, 215, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.8) inset;
}

.promo-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(255, 215, 0, 0.3);
    border-color: #ffd700 !important;
}

.promo-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 15px;
}

.promo-title {
    color: #ffffff !important;
    font-size: 1.2rem;
    font-weight: 600;
    margin: 0;
    flex: 1;
    margin-right: 15px;
}

.promo-discount {
    background: #ffd700 !important;
    color: #000 !important;
    padding: 8px 12px;
    border-radius: 20px;
    font-weight: 700;
    font-size: 1.1rem;
    min-width: 60px;
    text-align: center;
}

.promo-content {
    flex: 1;
    margin-bottom: 15px;
}

.promo-dates {
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin-bottom: 10px;
}

.promo-date {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #cccccc !important;
    font-size: 0.9rem;
}

.promo-date i {
    color: #ffd700 !important;
    width: 16px;
}

.promo-description {
    color: #cccccc !important;
    font-size: 0.9rem;
    line-height: 1.4;
    margin: 10px 0 0 0;
}

.promo-actions {
    display: flex;
    gap: 10px;
    justify-content: flex-end;
    margin-top: auto;
}

.btn-action {
    width: 40px;
    height: 40px;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
    text-decoration: none;
}

.btn-edit {
    background: rgba(33, 150, 243, 0.2) !important;
    color: #2196f3 !important;
}

.btn-edit:hover {
    background: #2196f3 !important;
    color: #fff !important;
}

.btn-delete {
    background: rgba(244, 67, 54, 0.2) !important;
    color: #f44336 !important;
}

.btn-delete:hover {
    background: #f44336 !important;
    color: #fff !important;
}
</style>
@endsection

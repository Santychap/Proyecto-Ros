@extends('layouts.app')

@section('title', 'Dashboard Cliente')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard-premium.css') }}">
@endpush

@section('content')
<div class="dashboard-container">
    <!-- Header -->
    <header class="dashboard-header">
        <div class="header-content">
            <div class="header-title">
                <i class="fas fa-user"></i>
                <h1>Mi Panel Personal</h1>
            </div>
            <div class="user-info">
                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <span>{{ auth()->user()->name }}</span>
                <form method="POST" action="{{ route('logout') }}" style="display: inline; margin-left: var(--spacing-sm);">
                    @csrf
                    <button type="submit" class="btn btn-secondary btn-small" title="Cerrar Sesión">
                        <i class="fas fa-sign-out-alt"></i>
                    </button>
                </form>
            </div>
        </div>
    </header>

    <!-- Sidebar -->
    <aside class="dashboard-sidebar">
        <ul class="sidebar-menu">
            <li>
                <a href="#overview" class="sidebar-link active" data-section="overview">
                    <i class="fas fa-home"></i>
                    <span>Inicio</span>
                </a>
            </li>
            <li>
                <a href="#reservas" class="sidebar-link" data-section="reservas">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Mis Reservas</span>
                </a>
            </li>
            <li>
                <a href="#pedidos" class="sidebar-link" data-section="pedidos">
                    <i class="fas fa-shopping-bag"></i>
                    <span>Mis Pedidos</span>
                </a>
            </li>
            <li>
                <a href="#perfil" class="sidebar-link" data-section="perfil">
                    <i class="fas fa-user-cog"></i>
                    <span>Mi Perfil</span>
                </a>
            </li>
        </ul>
    </aside>

    <!-- Contenido Principal -->
    <main class="dashboard-main">
        <!-- Sección: Resumen Personal -->
        <section id="overview" class="dashboard-section active">
            <h2 class="section-title">¡Hola, {{ auth()->user()->name }}!</h2>
            
            <!-- KPIs del Cliente -->
            <div class="kpi-grid">
                <div class="kpi-card">
                    <div class="kpi-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div class="kpi-content">
                        <h3>Mis Reservas</h3>
                        <div class="kpi-value">{{ $totalReservas ?? 0 }}</div>
                        <div class="kpi-change">
                            <i class="fas fa-calendar"></i>
                            Total realizadas
                        </div>
                    </div>
                </div>

                <div class="kpi-card">
                    <div class="kpi-icon">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <div class="kpi-content">
                        <h3>Mis Pedidos</h3>
                        <div class="kpi-value">{{ $totalPedidos ?? 0 }}</div>
                        <div class="kpi-change positive">
                            <i class="fas fa-utensils"></i>
                            Órdenes completadas
                        </div>
                    </div>
                </div>

                <div class="kpi-card">
                    <div class="kpi-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="kpi-content">
                        <h3>Puntos</h3>
                        <div class="kpi-value">250</div>
                        <div class="kpi-change positive">
                            <i class="fas fa-gift"></i>
                            Programa fidelidad
                        </div>
                    </div>
                </div>

                <div class="kpi-card">
                    <div class="kpi-icon">
                        <i class="fas fa-heart"></i>
                    </div>
                    <div class="kpi-content">
                        <h3>Favoritos</h3>
                        <div class="kpi-value">8</div>
                        <div class="kpi-change">
                            <i class="fas fa-bookmark"></i>
                            Platos guardados
                        </div>
                    </div>
                </div>
            </div>

            <!-- Accesos Rápidos -->
            <div class="grid grid-2">
                <div class="card text-center">
                    <i class="fas fa-calendar-plus" style="font-size: 3rem; color: var(--color-primary); margin-bottom: var(--spacing-md);"></i>
                    <h3 class="title-secondary">Nueva Reserva</h3>
                    <p class="mb-lg">Reserva tu mesa para una experiencia gastronómica única.</p>
                    <a href="{{ route('reservas.publicIndex') }}" class="btn btn-primary">
                        <i class="fas fa-calendar-plus"></i> Reservar Mesa
                    </a>
                </div>

                <div class="card text-center">
                    <i class="fas fa-utensils" style="font-size: 3rem; color: var(--color-primary); margin-bottom: var(--spacing-md);"></i>
                    <h3 class="title-secondary">Explorar Menú</h3>
                    <p class="mb-lg">Descubre nuestros deliciosos platos y especialidades.</p>
                    <a href="{{ route('menu.index') }}" class="btn btn-primary">
                        <i class="fas fa-utensils"></i> Ver Menú
                    </a>
                </div>
            </div>

            <!-- Actividad Reciente -->
            <div class="grid grid-2">
                <div class="chart-container">
                    <div class="chart-header">
                        <h3 class="chart-title">Mis Reservas Recientes</h3>
                        <a href="{{ route('reservas.index') }}" class="btn btn-primary btn-small">Ver Todas</a>
                    </div>
                    @if(isset($misReservas) && count($misReservas) > 0)
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Personas</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($misReservas as $reserva)
                                <tr>
                                    <td>{{ $reserva->fecha ? \Carbon\Carbon::parse($reserva->fecha)->format('d/m/Y') : 'N/A' }}</td>
                                    <td>{{ $reserva->hora ?? 'N/A' }}</td>
                                    <td>{{ $reserva->personas ?? 'N/A' }}</td>
                                    <td>
                                        <span class="status-badge status-confirmed">Confirmada</span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-calendar-alt"></i>
                            <h3>No tienes reservas</h3>
                            <p>¡Haz tu primera reserva!</p>
                            <a href="{{ route('reservas.publicIndex') }}" class="btn btn-primary btn-small">
                                Reservar Ahora
                            </a>
                        </div>
                    @endif
                </div>

                <div class="chart-container">
                    <div class="chart-header">
                        <h3 class="chart-title">Mis Pedidos Recientes</h3>
                        <a href="{{ route('pedidos.historial') }}" class="btn btn-primary btn-small">Ver Historial</a>
                    </div>
                    @if(isset($misPedidos) && count($misPedidos) > 0)
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($misPedidos as $pedido)
                                <tr>
                                    <td>{{ $pedido->created_at ? $pedido->created_at->format('d/m/Y') : 'N/A' }}</td>
                                    <td>${{ number_format($pedido->total ?? 0, 2) }}</td>
                                    <td>
                                        <span class="status-badge status-{{ $pedido->estado ?? 'pending' }}">
                                            {{ ucfirst($pedido->estado ?? 'Pendiente') }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-shopping-bag"></i>
                            <h3>No tienes pedidos</h3>
                            <p>¡Explora nuestro menú!</p>
                            <a href="{{ route('menu.index') }}" class="btn btn-primary btn-small">
                                Ver Menú
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </section>

        <!-- Sección: Reservas -->
        <section id="reservas" class="dashboard-section">
            <h2 class="section-title">Mis Reservas</h2>
            <div class="text-center p-xl">
                <i class="fas fa-calendar-alt" style="font-size: 4rem; color: var(--color-primary); margin-bottom: var(--spacing-md);"></i>
                <h3>Gestiona tus Reservas</h3>
                <p class="mb-lg">Consulta, modifica o cancela tus reservas existentes.</p>
                <div style="display: flex; gap: var(--spacing-md); justify-content: center; flex-wrap: wrap;">
                    <a href="{{ route('reservas.publicIndex') }}" class="btn btn-primary">
                        <i class="fas fa-calendar-plus"></i> Nueva Reserva
                    </a>
                    <a href="{{ route('reservas.index') }}" class="btn btn-secondary">
                        <i class="fas fa-list"></i> Ver Todas
                    </a>
                </div>
            </div>
        </section>

        <!-- Sección: Pedidos -->
        <section id="pedidos" class="dashboard-section">
            <h2 class="section-title">Mis Pedidos</h2>
            <div class="text-center p-xl">
                <i class="fas fa-shopping-bag" style="font-size: 4rem; color: var(--color-primary); margin-bottom: var(--spacing-md);"></i>
                <h3>Historial de Pedidos</h3>
                <p class="mb-lg">Revisa tus pedidos anteriores y realiza nuevos pedidos.</p>
                <div style="display: flex; gap: var(--spacing-md); justify-content: center; flex-wrap: wrap;">
                    <a href="{{ route('menu.index') }}" class="btn btn-primary">
                        <i class="fas fa-utensils"></i> Hacer Pedido
                    </a>
                    <a href="{{ route('pedidos.historial') }}" class="btn btn-secondary">
                        <i class="fas fa-history"></i> Ver Historial
                    </a>
                </div>
            </div>
        </section>

        <!-- Sección: Perfil -->
        <section id="perfil" class="dashboard-section">
            <h2 class="section-title">Mi Perfil</h2>
            <div class="text-center p-xl">
                <i class="fas fa-user-cog" style="font-size: 4rem; color: var(--color-primary); margin-bottom: var(--spacing-md);"></i>
                <h3>Configuración de Cuenta</h3>
                <p class="mb-lg">Actualiza tu información personal y preferencias.</p>
                <a href="{{ route('profile') }}" class="btn btn-primary btn-large">
                    <i class="fas fa-user-cog"></i> Editar Perfil
                </a>
            </div>
        </section>
    </main>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Navegación del sidebar
    const sidebarLinks = document.querySelectorAll('.sidebar-link');
    const sections = document.querySelectorAll('.dashboard-section');

    sidebarLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetSection = this.dataset.section;
            
            // Actualizar enlaces activos
            sidebarLinks.forEach(l => l.classList.remove('active'));
            this.classList.add('active');
            
            // Mostrar sección correspondiente
            sections.forEach(section => {
                section.classList.remove('active');
                if (section.id === targetSection) {
                    section.classList.add('active');
                }
            });
        });
    });

    // Animaciones de entrada para las KPI cards
    const kpiCards = document.querySelectorAll('.kpi-card');
    kpiCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275)';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
});
</script>
@endpush
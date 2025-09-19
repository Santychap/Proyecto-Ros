@extends('layouts.app')

@section('title', 'Dashboard Administrador')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard-premium.css') }}">
@endpush

@section('content')
<div class="dashboard-container">
    <!-- Header -->
    <header class="dashboard-header">
        <div class="header-content">
            <div class="header-title">
                <i class="fas fa-crown"></i>
                <h1>Panel de Administración</h1>
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
                    <i class="fas fa-chart-line"></i>
                    <span>Resumen General</span>
                </a>
            </li>
            <li>
                <a href="#reservas" class="sidebar-link" data-section="reservas">
                    <i class="fas fa-calendar-alt"></i>
                    <span>Reservas</span>
                </a>
            </li>
            <li>
                <a href="#pedidos" class="sidebar-link" data-section="pedidos">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Pedidos</span>
                </a>
            </li>
            <li>
                <a href="#usuarios" class="sidebar-link" data-section="usuarios">
                    <i class="fas fa-users"></i>
                    <span>Usuarios</span>
                </a>
            </li>
            <li>
                <a href="#productos" class="sidebar-link" data-section="productos">
                    <i class="fas fa-utensils"></i>
                    <span>Productos</span>
                </a>
            </li>
            <li>
                <a href="#mesas" class="sidebar-link" data-section="mesas">
                    <i class="fas fa-chair"></i>
                    <span>Mesas</span>
                </a>
            </li>
            <li>
                <a href="#noticias" class="sidebar-link" data-section="noticias">
                    <i class="fas fa-newspaper"></i>
                    <span>Noticias</span>
                </a>
            </li>
            <li>
                <a href="#pagos" class="sidebar-link" data-section="pagos">
                    <i class="fas fa-credit-card"></i>
                    <span>Pagos</span>
                </a>
            </li>
            <li>
                <a href="#promociones" class="sidebar-link" data-section="promociones">
                    <i class="fas fa-tags"></i>
                    <span>Promociones</span>
                </a>
            </li>
            <li>
                <a href="#reportes" class="sidebar-link" data-section="reportes">
                    <i class="fas fa-chart-bar"></i>
                    <span>Reportes</span>
                </a>
            </li>
        </ul>
    </aside>

    <!-- Contenido Principal -->
    <main class="dashboard-main">
        <!-- Sección: Resumen General -->
        <section id="overview" class="dashboard-section active">
            <h2 class="section-title">Resumen General</h2>
            
            <!-- KPIs -->
            <div class="kpi-grid">
                <div class="kpi-card">
                    <div class="kpi-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div class="kpi-content">
                        <h3>Reservas Hoy</h3>
                        <div class="kpi-value">{{ $totalReservasHoy ?? 0 }}</div>
                        <div class="kpi-change positive">
                            <i class="fas fa-arrow-up"></i>
                            +12% vs ayer
                        </div>
                    </div>
                </div>

                <div class="kpi-card">
                    <div class="kpi-icon">
                        <i class="fas fa-shopping-bag"></i>
                    </div>
                    <div class="kpi-content">
                        <h3>Pedidos Hoy</h3>
                        <div class="kpi-value">{{ $totalPedidosHoy ?? 0 }}</div>
                        <div class="kpi-change positive">
                            <i class="fas fa-arrow-up"></i>
                            +8% vs ayer
                        </div>
                    </div>
                </div>

                <div class="kpi-card">
                    <div class="kpi-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="kpi-content">
                        <h3>Clientes Registrados</h3>
                        <div class="kpi-value">{{ $totalClientes ?? 0 }}</div>
                        <div class="kpi-change positive">
                            <i class="fas fa-arrow-up"></i>
                            +5% esta semana
                        </div>
                    </div>
                </div>

                <div class="kpi-card">
                    <div class="kpi-icon">
                        <i class="fas fa-chair"></i>
                    </div>
                    <div class="kpi-content">
                        <h3>Mesas Disponibles</h3>
                        <div class="kpi-value">{{ $mesasDisponibles ?? 0 }}</div>
                        <div class="kpi-change">
                            <i class="fas fa-minus"></i>
                            Sin cambios
                        </div>
                    </div>
                </div>
            </div>

            <!-- Gráfico Pequeño -->
            <div class="grid grid-4">
                <div class="chart-container" style="max-width: 300px;">
                    <div class="chart-header">
                        <h4 style="font-size: 14px; margin: 0;">Reservas - 7 días</h4>
                    </div>
                    <canvas id="reservasChart" height="20" style="max-height: 150px;"></canvas>
                </div>
                <div></div>
                <div></div>
                <div></div>
            </div>

            <!-- Actividad Reciente -->
            <div class="grid grid-2">
                <div class="chart-container">
                    <div class="chart-header">
                        <h3 class="chart-title">Reservas Recientes</h3>
                        <a href="{{ route('reservas.index') }}" class="btn btn-primary btn-small">Ver Todas</a>
                    </div>
                    @if(isset($reservasRecientes) && count($reservasRecientes) > 0)
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Fecha</th>
                                    <th>Personas</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reservasRecientes as $reserva)
                                <tr>
                                    <td>{{ $reserva->nombre ?? 'N/A' }}</td>
                                    <td>{{ $reserva->fecha ? \Carbon\Carbon::parse($reserva->fecha)->format('d/m/Y') : 'N/A' }}</td>
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
                            <h3>No hay reservas recientes</h3>
                            <p>Las nuevas reservas aparecerán aquí</p>
                        </div>
                    @endif
                </div>

                <div class="chart-container">
                    <div class="chart-header">
                        <h3 class="chart-title">Pedidos Recientes</h3>
                        <a href="{{ route('pedidos.index') }}" class="btn btn-primary btn-small">Ver Todos</a>
                    </div>
                    @if(isset($pedidosRecientes) && count($pedidosRecientes) > 0)
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Cliente</th>
                                    <th>Total</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pedidosRecientes as $pedido)
                                <tr>
                                    <td>{{ $pedido->user->name ?? 'N/A' }}</td>
                                    <td>${{ number_format($pedido->total ?? 0, 2) }}</td>
                                    <td>
                                        <span class="status-badge status-{{ $pedido->estado ?? 'pending' }}">
                                            {{ ucfirst($pedido->estado ?? 'Pendiente') }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <button class="btn-action btn-edit">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-shopping-bag"></i>
                            <h3>No hay pedidos recientes</h3>
                            <p>Los nuevos pedidos aparecerán aquí</p>
                        </div>
                    @endif
                </div>
            </div>
        </section>

        <!-- Otras secciones (ocultas por defecto) -->
        <section id="reservas" class="dashboard-section">
            <h2 class="section-title">Gestión de Reservas</h2>
            <div class="text-center p-xl">
                <i class="fas fa-calendar-alt" style="font-size: 4rem; color: var(--color-primary); margin-bottom: var(--spacing-md);"></i>
                <h3>Gestión de Reservas</h3>
                <p class="mb-lg">Administra todas las reservas del restaurante desde aquí.</p>
                <a href="{{ route('reservas.index') }}" class="btn btn-primary btn-large">
                    <i class="fas fa-calendar-alt"></i> Ir a Reservas
                </a>
            </div>
        </section>

        <section id="pedidos" class="dashboard-section">
            <h2 class="section-title">Gestión de Pedidos</h2>
            <div class="text-center p-xl">
                <i class="fas fa-clipboard-list" style="font-size: 4rem; color: var(--color-primary); margin-bottom: var(--spacing-md);"></i>
                <h3>Gestión de Pedidos</h3>
                <p class="mb-lg">Controla todos los pedidos y su estado de preparación.</p>
                <a href="{{ route('pedidos.index') }}" class="btn btn-primary btn-large">
                    <i class="fas fa-clipboard-list"></i> Ir a Pedidos
                </a>
            </div>
        </section>

        <section id="usuarios" class="dashboard-section">
            <h2 class="section-title">Gestión de Usuarios</h2>
            <div class="text-center p-xl">
                <i class="fas fa-users" style="font-size: 4rem; color: var(--color-primary); margin-bottom: var(--spacing-md);"></i>
                <h3>Gestión de Usuarios</h3>
                <p class="mb-lg">Administra clientes, empleados y otros usuarios del sistema.</p>
                <a href="{{ route('users.index') }}" class="btn btn-primary btn-large">
                    <i class="fas fa-users"></i> Ir a Usuarios
                </a>
            </div>
        </section>

        <section id="productos" class="dashboard-section">
            <h2 class="section-title">Gestión de Productos</h2>
            <div class="text-center p-xl">
                <i class="fas fa-utensils" style="font-size: 4rem; color: var(--color-primary); margin-bottom: var(--spacing-md);"></i>
                <h3>Gestión de Productos</h3>
                <p class="mb-lg">Administra el menú, precios y disponibilidad de productos.</p>
                <a href="{{ route('productos.index') }}" class="btn btn-primary btn-large">
                    <i class="fas fa-utensils"></i> Ir a Productos
                </a>
            </div>
        </section>

        <section id="mesas" class="dashboard-section">
            <h2 class="section-title">Gestión de Mesas</h2>
            <div class="text-center p-xl">
                <i class="fas fa-chair" style="font-size: 4rem; color: var(--color-primary); margin-bottom: var(--spacing-md);"></i>
                <h3>Gestión de Mesas</h3>
                <p class="mb-lg">Configura y administra las mesas del restaurante.</p>
                <a href="{{ route('mesas.index') }}" class="btn btn-primary btn-large">
                    <i class="fas fa-chair"></i> Ir a Mesas
                </a>
            </div>
        </section>

        <section id="noticias" class="dashboard-section">
            <h2 class="section-title">Gestión de Noticias</h2>
            <div class="text-center p-xl">
                <i class="fas fa-newspaper" style="font-size: 4rem; color: var(--color-primary); margin-bottom: var(--spacing-md);"></i>
                <h3>Gestión de Noticias</h3>
                <p class="mb-lg">Administra las noticias y anuncios del restaurante.</p>
                <a href="{{ route('noticias.index') }}" class="btn btn-primary btn-large">
                    <i class="fas fa-newspaper"></i> Ir a Noticias
                </a>
            </div>
        </section>

        <section id="pagos" class="dashboard-section">
            <h2 class="section-title">Gestión de Pagos</h2>
            <div class="text-center p-xl">
                <i class="fas fa-credit-card" style="font-size: 4rem; color: var(--color-primary); margin-bottom: var(--spacing-md);"></i>
                <h3>Gestión de Pagos</h3>
                <p class="mb-lg">Administra todos los pagos y transacciones del restaurante.</p>
                <a href="{{ route('pagos.index') }}" class="btn btn-primary btn-large">
                    <i class="fas fa-credit-card"></i> Ir a Pagos
                </a>
            </div>
        </section>

        <section id="promociones" class="dashboard-section">
            <h2 class="section-title">Gestión de Promociones</h2>
            <div class="text-center p-xl">
                <i class="fas fa-tags" style="font-size: 4rem; color: var(--color-primary); margin-bottom: var(--spacing-md);"></i>
                <h3>Gestión de Promociones</h3>
                <p class="mb-lg">Crea y administra promociones y ofertas especiales.</p>
                <a href="{{ route('promociones.index') }}" class="btn btn-primary btn-large">
                    <i class="fas fa-tags"></i> Ir a Promociones
                </a>
            </div>
        </section>

        <section id="reportes" class="dashboard-section">
            <h2 class="section-title">Reportes y Análisis</h2>
            <div class="text-center p-xl">
                <i class="fas fa-chart-bar" style="font-size: 4rem; color: var(--color-primary); margin-bottom: var(--spacing-md);"></i>
                <h3>Reportes y Análisis</h3>
                <p class="mb-lg">Genera reportes detallados sobre el rendimiento del restaurante.</p>
                <a href="{{ route('reportes.index') }}" class="btn btn-primary btn-large">
                    <i class="fas fa-chart-bar"></i> Ver Reportes
                </a>
            </div>
        </section>
    </main>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

    // Gráfica de reservas
    const ctx = document.getElementById('reservasChart');
    if (ctx) {
        const reservasChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['L', 'M', 'X', 'J', 'V', 'S', 'D'],
                datasets: [{
                    label: 'Reservas',
                    data: [5, 8, 12, 7, 15, 20, 18],
                    borderColor: '#ffd700',
                    backgroundColor: 'rgba(255, 215, 0, 0.1)',
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    }

    // Animaciones de entrada para las KPI cards
    const kpiCards = document.querySelectorAll('.kpi-card');
    kpiCards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        
        setTimeout(() => {
            card.style.transition = 'all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275)';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
});
</script>

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.dashboard-section {
    animation: fadeIn 0.4s ease-in;
}

/* Responsive adjustments */
@media (max-width: 1024px) {
    .kpi-grid {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .kpi-grid {
        grid-template-columns: 1fr;
    }
    
    .grid-2 {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush
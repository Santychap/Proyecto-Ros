@extends('layouts.admin')

@section('title', 'Dashboard Administrador')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gráfica de Pedidos - Última Semana (Gráfica de barras)
    const pedidosCtx = document.getElementById('pedidosChart').getContext('2d');
    new Chart(pedidosCtx, {
        type: 'bar',
        data: {
            labels: ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'],
            datasets: [{
                label: 'Pagados',
                data: [8, 12, 15, 10, 18, 22, 16],
                backgroundColor: '#51cf66',
                borderColor: '#51cf66',
                borderWidth: 1
            }, {
                label: 'Cancelados',
                data: [1, 2, 1, 3, 2, 1, 2],
                backgroundColor: '#ff4757',
                borderColor: '#ff4757',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                        color: '#ffd700',
                        font: { size: 10 }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { color: '#ffd700', font: { size: 10 } },
                    grid: { color: 'rgba(255, 215, 0, 0.2)' }
                },
                x: {
                    ticks: { color: '#ffd700', font: { size: 10 } },
                    grid: { color: 'rgba(255, 215, 0, 0.2)' }
                }
            }
        }
    });

    // Gráfica de Usuarios Registrados - Última Semana (Gráfica de líneas)
    const usuariosCtx = document.getElementById('usuariosChart').getContext('2d');
    new Chart(usuariosCtx, {
        type: 'line',
        data: {
            labels: ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'],
            datasets: [{
                label: 'Nuevos Usuarios',
                data: [3, 5, 2, 7, 4, 6, 8],
                borderColor: '#4a90e2',
                backgroundColor: 'rgba(74, 144, 226, 0.1)',
                borderWidth: 2,
                fill: true,
                tension: 0.4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom',
                    labels: {
                        color: '#ffd700',
                        font: { size: 10 }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { color: '#ffd700', font: { size: 10 } },
                    grid: { color: 'rgba(255, 215, 0, 0.2)' }
                },
                x: {
                    ticks: { color: '#ffd700', font: { size: 10 } },
                    grid: { color: 'rgba(255, 215, 0, 0.2)' }
                }
            }
        }
    });
});
</script>
@endpush

@section('content')
<div style="width:100%;">
    <main class="dashboard-main" style="padding:0;">
        <!-- Sección: Resumen General -->
    <section id="overview" class="dashboard-section active" style="width: 100%;">
            <h2 class="title-primary mb-lg" style="text-align: left;">Resumen General</h2>
            <!-- KPIs -->
            <div class="kpi-grid mb-lg" style="gap: 1.2rem; grid-template-columns: repeat(4, 1fr);">
                <div class="kpi-card" style="min-width: 160px; min-height: 100px; max-width: 260px; flex: 1;">
                    <div class="kpi-icon"><i class="fas fa-calendar-check"></i></div>
                    <div class="kpi-content">
                        <h3>Reservas Hoy</h3>
                        <div class="kpi-value">{{ $totalReservasHoy ?? 0 }}</div>
                        <div class="kpi-change positive"><i class="fas fa-arrow-up"></i> +12% vs ayer</div>
                    </div>
                </div>
                <div class="kpi-card" style="min-width: 160px; min-height: 100px; max-width: 260px; flex: 1;">
                    <div class="kpi-icon"><i class="fas fa-shopping-bag"></i></div>
                    <div class="kpi-content">
                        <h3>Pedidos Hoy</h3>
                        <div class="kpi-value">{{ $totalPedidosHoy ?? 0 }}</div>
                        <div class="kpi-change positive"><i class="fas fa-arrow-up"></i> +8% vs ayer</div>
                    </div>
                </div>
                <div class="kpi-card" style="min-width: 160px; min-height: 100px; max-width: 260px; flex: 1;">
                    <div class="kpi-icon"><i class="fas fa-users"></i></div>
                    <div class="kpi-content">
                        <h3>Clientes Registrados</h3>
                        <div class="kpi-value">{{ $totalClientes ?? 0 }}</div>
                        <div class="kpi-change positive"><i class="fas fa-arrow-up"></i> +5% esta semana</div>
                    </div>
                </div>
                <div class="kpi-card" style="min-width: 160px; min-height: 100px; max-width: 260px; flex: 1;">
                    <div class="kpi-icon"><i class="fas fa-chair"></i></div>
                    <div class="kpi-content">
                        <h3>Mesas Disponibles</h3>
                        <div class="kpi-value">{{ $mesasDisponibles ?? 0 }}</div>
                        <div class="kpi-change"><i class="fas fa-minus"></i> Sin cambios</div>
                    </div>
                </div>
            </div>
            <!-- Gráficos Estadísticas -->
            <div class="grid grid-3 mb-lg" style="gap: 2.5rem; grid-template-columns: repeat(3, 1fr);">
                <div class="card chart-container" style="max-width: 420px; min-width: 320px; width: 100%;">
                    <div class="chart-header">
                        <h4 style="font-size: 14px; margin: 0;">Reservas - 7 días</h4>
                    </div>
                    <canvas id="reservasChart" height="20" style="max-height: 180px;"></canvas>
                </div>
                <div class="card chart-container" style="max-width: 420px; min-width: 320px; width: 100%;">
                    <div class="chart-header">
                        <h4 style="font-size: 14px; margin: 0;">Pedidos - Última Semana</h4>
                    </div>
                    <canvas id="pedidosChart" height="20" style="max-height: 180px;"></canvas>
                </div>
                <div class="card chart-container" style="max-width: 420px; min-width: 320px; width: 100%;">
                    <div class="chart-header">
                        <h4 style="font-size: 14px; margin: 0;">Usuarios - Última Semana</h4>
                    </div>
                    <canvas id="usuariosChart" height="20" style="max-height: 180px;"></canvas>
                </div>
            </div>
            <!-- Actividad Reciente -->
            <div class="grid grid-2" style="gap: 2.5rem;">
                <div class="card chart-container" style="width: 100%; min-width: 350px;">
                    <div class="chart-header">
                        <h3 class="chart-title">Reservas Recientes</h3>
                        <a href="{{ route('reservas.index') }}" class="btn btn-primary btn-small">Ver Todas</a>
                    </div>
                    @if(isset($reservasRecientes) && count($reservasRecientes) > 0)
                        <table class="data-table" style="width: 100%;">
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
                                    <td><span class="status-badge status-confirmed">Confirmada</span></td>
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
                <div class="card chart-container" style="width: 100%; min-width: 350px;">
                    <div class="chart-header">
                        <h3 class="chart-title">Pedidos Recientes</h3>
                        <a href="{{ route('pedidos.index') }}" class="btn btn-primary btn-small">Ver Todos</a>
                    </div>
                    @if(isset($pedidosRecientes) && count($pedidosRecientes) > 0)
                        <table class="data-table" style="width: 100%;">
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
                                    <td>${{ number_format($pedido->total, 2) }}</td>
                                    <td><span class="status-badge status-{{ strtolower($pedido->estado) }}">{{ $pedido->estado }}</span></td>
                                    <td>
                                        @if($pedido->pago)
                                            @if($pedido->pago->metodo === 'efectivo' && $pedido->pago->estado === 'pendiente')
                                                <form action="{{ route('pagos.cambiarEstado', $pedido->pago) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('PUT')
                                                    <select name="estado" onchange="this.form.submit()" style="background: #333; color: #ffd700; border: 1px solid #ffd700; padding: 4px; border-radius: 4px; font-size: 12px;">
                                                        <option value="pendiente" selected>Pendiente</option>
                                                        <option value="pagado">Pagado</option>
                                                    </select>
                                                </form>
                                            @else
                                                <span style="color: #51cf66; font-size: 12px;">{{ ucfirst($pedido->pago->metodo) }} - {{ ucfirst($pedido->pago->estado) }}</span>
                                            @endif
                                        @else
                                            <span style="color: #ff6b6b; font-size: 12px;">Sin pago</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-shopping-bag"></i>
                            <h3>No hay pedidos recientes</h3>
                            <p>Los nuevos pedidos aparecerán aquí</p>/p>
                        </div>
                    @endif
                </div>
            </div>
        </section>

    <!-- Otras secciones (ocultas por defecto) -->
    <section id="reservas" class="dashboard-section">
            <h2 class="section-title">Gestión de Reservas</h2>
            <div class="card text-center p-xl">
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
            <div class="card text-center p-xl">
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
            <div class="card text-center p-xl">
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
            <div class="card text-center p-xl">
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
            <div class="card text-center p-xl">
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
            <div class="card text-center p-xl">
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
            <div class="card text-center p-xl">
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
            <div class="card text-center p-xl">
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
            <div class="card text-center p-xl">
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
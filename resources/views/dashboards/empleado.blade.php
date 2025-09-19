@extends('layouts.app')

@section('title', 'Dashboard Empleado')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard-premium.css') }}">
@endpush

@section('content')
<div class="dashboard-container">
    <!-- Header -->
    <header class="dashboard-header">
        <div class="header-content">
            <div class="header-title">
                <i class="fas fa-user-tie"></i>
                <h1>Panel de Empleado</h1>
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
                    <i class="fas fa-tachometer-alt"></i>
                    <span>Mi Panel</span>
                </a>
            </li>
            <li>
                <a href="#pedidos" class="sidebar-link" data-section="pedidos">
                    <i class="fas fa-clipboard-list"></i>
                    <span>Mis Pedidos</span>
                </a>
            </li>
            <li>
                <a href="#horarios" class="sidebar-link" data-section="horarios">
                    <i class="fas fa-clock"></i>
                    <span>Horarios</span>
                </a>
            </li>
            <li>
                <a href="#estadisticas" class="sidebar-link" data-section="estadisticas">
                    <i class="fas fa-chart-pie"></i>
                    <span>Mis Estadísticas</span>
                </a>
            </li>
        </ul>
    </aside>

    <!-- Contenido Principal -->
    <main class="dashboard-main">
        <!-- Sección: Resumen Personal -->
        <section id="overview" class="dashboard-section active">
            <h2 class="section-title">¡Bienvenido, {{ auth()->user()->name }}!</h2>
            
            <!-- KPIs del Empleado -->
            <div class="kpi-grid">
                <div class="kpi-card">
                    <div class="kpi-icon">
                        <i class="fas fa-tasks"></i>
                    </div>
                    <div class="kpi-content">
                        <h3>Pedidos Hoy</h3>
                        <div class="kpi-value">{{ $pedidosHoy ?? 0 }}</div>
                        <div class="kpi-change positive">
                            <i class="fas fa-arrow-up"></i>
                            Buen ritmo
                        </div>
                    </div>
                </div>

                <div class="kpi-card">
                    <div class="kpi-icon">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="kpi-content">
                        <h3>Completados</h3>
                        <div class="kpi-value">{{ $pedidosCompletados ?? 0 }}</div>
                        <div class="kpi-change positive">
                            <i class="fas fa-trophy"></i>
                            Total histórico
                        </div>
                    </div>
                </div>

                <div class="kpi-card">
                    <div class="kpi-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="kpi-content">
                        <h3>Turno Actual</h3>
                        <div class="kpi-value">{{ date('H:i') }}</div>
                        <div class="kpi-change">
                            <i class="fas fa-calendar"></i>
                            {{ date('d/m/Y') }}
                        </div>
                    </div>
                </div>

                <div class="kpi-card">
                    <div class="kpi-icon">
                        <i class="fas fa-star"></i>
                    </div>
                    <div class="kpi-content">
                        <h3>Rendimiento</h3>
                        <div class="kpi-value">98%</div>
                        <div class="kpi-change positive">
                            <i class="fas fa-thumbs-up"></i>
                            Excelente
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pedidos Asignados -->
            <div class="chart-container">
                <div class="chart-header">
                    <h3 class="chart-title">Mis Pedidos Pendientes</h3>
                    <a href="{{ route('pedidos.index') }}" class="btn btn-primary btn-small">Ver Todos</a>
                </div>
                
                @if(isset($pedidosAsignados) && count($pedidosAsignados) > 0)
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Cliente</th>
                                <th>Total</th>
                                <th>Estado</th>
                                <th>Tiempo</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pedidosAsignados as $pedido)
                            <tr>
                                <td>#{{ $pedido->id }}</td>
                                <td>{{ $pedido->user->name ?? 'Cliente' }}</td>
                                <td>${{ number_format($pedido->total ?? 0, 2) }}</td>
                                <td>
                                    <span class="status-badge status-{{ $pedido->estado }}">
                                        {{ ucfirst($pedido->estado) }}
                                    </span>
                                </td>
                                <td>{{ $pedido->created_at ? $pedido->created_at->diffForHumans() : 'N/A' }}</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-action btn-edit" onclick="cambiarEstado({{ $pedido->id }}, 'en_preparacion')">
                                            <i class="fas fa-play"></i>
                                        </button>
                                        <button class="btn-action btn-delete" onclick="cambiarEstado({{ $pedido->id }}, 'completado')">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="empty-state">
                        <i class="fas fa-clipboard-check"></i>
                        <h3>¡Excelente trabajo!</h3>
                        <p>No tienes pedidos pendientes en este momento.</p>
                        <button class="btn btn-primary" onclick="location.reload()">
                            <i class="fas fa-sync"></i> Actualizar
                        </button>
                    </div>
                @endif
            </div>

            <!-- Accesos Rápidos -->
            <div class="grid grid-2">
                <div class="card text-center">
                    <i class="fas fa-clipboard-list" style="font-size: 3rem; color: var(--color-primary); margin-bottom: var(--spacing-md);"></i>
                    <h3 class="title-secondary">Gestionar Pedidos</h3>
                    <p class="mb-lg">Administra todos tus pedidos asignados y actualiza su estado.</p>
                    <a href="{{ route('pedidos.index') }}" class="btn btn-primary">
                        <i class="fas fa-clipboard-list"></i> Ir a Pedidos
                    </a>
                </div>

                <div class="card text-center">
                    <i class="fas fa-clock" style="font-size: 3rem; color: var(--color-primary); margin-bottom: var(--spacing-md);"></i>
                    <h3 class="title-secondary">Ver Horarios</h3>
                    <p class="mb-lg">Consulta tus horarios de trabajo y turnos asignados.</p>
                    <a href="{{ route('horarios.index') }}" class="btn btn-primary">
                        <i class="fas fa-clock"></i> Ver Horarios
                    </a>
                </div>
            </div>
        </section>

        <!-- Sección: Pedidos -->
        <section id="pedidos" class="dashboard-section">
            <h2 class="section-title">Gestión de Pedidos</h2>
            <div class="text-center p-xl">
                <i class="fas fa-clipboard-list" style="font-size: 4rem; color: var(--color-primary); margin-bottom: var(--spacing-md);"></i>
                <h3>Mis Pedidos Asignados</h3>
                <p class="mb-lg">Administra todos los pedidos que tienes asignados y actualiza su estado.</p>
                <a href="{{ route('pedidos.index') }}" class="btn btn-primary btn-large">
                    <i class="fas fa-clipboard-list"></i> Ver Todos los Pedidos
                </a>
            </div>
        </section>

        <!-- Sección: Horarios -->
        <section id="horarios" class="dashboard-section">
            <h2 class="section-title">Mis Horarios</h2>
            <div class="text-center p-xl">
                <i class="fas fa-clock" style="font-size: 4rem; color: var(--color-primary); margin-bottom: var(--spacing-md);"></i>
                <h3>Horarios de Trabajo</h3>
                <p class="mb-lg">Consulta tus horarios, turnos y disponibilidad.</p>
                <a href="{{ route('horarios.index') }}" class="btn btn-primary btn-large">
                    <i class="fas fa-clock"></i> Ver Mis Horarios
                </a>
            </div>
        </section>

        <!-- Sección: Estadísticas -->
        <section id="estadisticas" class="dashboard-section">
            <h2 class="section-title">Mis Estadísticas</h2>
            
            <div class="grid grid-2">
                <div class="chart-container">
                    <div class="chart-header">
                        <h3 class="chart-title">Rendimiento Semanal</h3>
                    </div>
                    <canvas id="rendimientoChart" height="120"></canvas>
                </div>

                <div class="chart-container">
                    <div class="chart-header">
                        <h3 class="chart-title">Pedidos por Estado</h3>
                    </div>
                    <canvas id="estadosChart" height="120"></canvas>
                </div>
            </div>

            <!-- Logros y Reconocimientos -->
            <div class="card">
                <h3 class="title-secondary text-center mb-md">🏆 Logros</h3>
                <div class="grid grid-3">
                    <div class="achievement text-center">
                        <div class="achievement-icon">
                            <i class="fas fa-medal" style="font-size: 1.5rem; color: #ffd700;"></i>
                        </div>
                        <h4 style="font-size: var(--font-size-sm); margin: var(--spacing-xs) 0;">Empleado del Mes</h4>
                        <p style="font-size: var(--font-size-xs);">Excelente desempeño</p>
                    </div>
                    <div class="achievement text-center">
                        <div class="achievement-icon">
                            <i class="fas fa-rocket" style="font-size: 1.5rem; color: #4ecdc4;"></i>
                        </div>
                        <h4 style="font-size: var(--font-size-sm); margin: var(--spacing-xs) 0;">Velocidad</h4>
                        <p style="font-size: var(--font-size-xs);">Tiempo: 3.2 min</p>
                    </div>
                    <div class="achievement text-center">
                        <div class="achievement-icon">
                            <i class="fas fa-heart" style="font-size: 1.5rem; color: #ff6b6b;"></i>
                        </div>
                        <h4 style="font-size: var(--font-size-sm); margin: var(--spacing-xs) 0;">Satisfacción</h4>
                        <p style="font-size: var(--font-size-xs);">98% satisfechos</p>
                    </div>
                </div>
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

    // Gráfica de rendimiento
    const rendimientoCtx = document.getElementById('rendimientoChart');
    if (rendimientoCtx) {
        new Chart(rendimientoCtx, {
            type: 'line',
            data: {
                labels: ['Lun', 'Mar', 'Mié', 'Jue', 'Vie', 'Sáb', 'Dom'],
                datasets: [{
                    label: 'Pedidos Completados',
                    data: [12, 15, 18, 14, 20, 25, 22],
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
                        labels: {
                            color: '#ffd700'
                        }
                    }
                },
                scales: {
                    x: {
                        ticks: { color: '#ffd700' },
                        grid: { color: 'rgba(255, 215, 0, 0.1)' }
                    },
                    y: {
                        ticks: { color: '#ffd700' },
                        grid: { color: 'rgba(255, 215, 0, 0.1)' }
                    }
                }
            }
        });
    }

    // Gráfica de estados
    const estadosCtx = document.getElementById('estadosChart');
    if (estadosCtx) {
        new Chart(estadosCtx, {
            type: 'doughnut',
            data: {
                labels: ['Completados', 'En Preparación', 'Pendientes'],
                datasets: [{
                    data: [75, 15, 10],
                    backgroundColor: ['#51cf66', '#ffd700', '#ff6b6b'],
                    borderWidth: 2,
                    borderColor: '#000'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        labels: {
                            color: '#ffd700'
                        }
                    }
                }
            }
        });
    }

    // Actualización automática cada 30 segundos
    setInterval(() => {
        // Aquí podrías hacer una llamada AJAX para actualizar los datos
        console.log('Actualizando datos...');
    }, 30000);
});

// Función para cambiar estado de pedidos
function cambiarEstado(pedidoId, nuevoEstado) {
    if (confirm('¿Estás seguro de cambiar el estado de este pedido?')) {
        fetch(`/pedidos/${pedidoId}/estado`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                estado: nuevoEstado
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error al actualizar el pedido');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al actualizar el pedido');
        });
    }
}
</script>

<style>
.achievement {
    padding: var(--spacing-sm);
    border-radius: var(--border-radius-medium);
    background: rgba(255, 215, 0, 0.05);
    border: 1px solid rgba(255, 215, 0, 0.2);
    transition: all var(--transition-normal);
}

.achievement:hover {
    background: rgba(255, 215, 0, 0.1);
    transform: translateY(-4px);
    box-shadow: var(--shadow-small);
}

.achievement h4 {
    color: var(--color-primary);
    margin: var(--spacing-xs) 0;
    font-size: var(--font-size-sm);
}

.achievement p {
    color: var(--text-muted);
    font-size: var(--font-size-xs);
    margin: 0;
}

/* Animación de pulso para notificaciones */
@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

.kpi-card:first-child {
    animation: pulse 2s infinite;
}
</style>
@endpush
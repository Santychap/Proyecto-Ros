@extends('layouts.cliente')

@section('title', 'Dashboard Cliente')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/dashboard-premium.css') }}">
<style>
.kpi-card {
    background: #000000 !important;
    border: 3px solid #ffd700 !important;
    box-shadow: 0 0 20px rgba(255, 215, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.8) inset !important;
}
.chart-container {
    background: #000000 !important;
    border: 3px solid #ffd700 !important;
    box-shadow: 0 0 20px rgba(255, 215, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.8) inset !important;
}
.card {
    background: #000000 !important;
    border: 3px solid #ffd700 !important;
    box-shadow: 0 0 20px rgba(255, 215, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.8) inset !important;
}
.title-secondary {
    color: #ffffff !important;
}
.card p {
    color: #cccccc !important;
}
</style>
@endpush

@section('content')
        <!-- Sección: Resumen Personal -->
        <section id="overview" class="dashboard-section active">
            <h2 class="section-title">¡Bienvenido, {{ auth()->user()->name }}!</h2>
            
            <!-- KPIs del Cliente -->
            <div class="kpi-grid">
                <div class="kpi-card">
                    <div class="kpi-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <div class="kpi-content">
                        <h3>Mis Reservas</h3>
                        <div class="kpi-value">{{ $misReservas ?? 0 }}</div>
                        <div class="kpi-change positive">
                            <i class="fas fa-arrow-up"></i>
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
                        <div class="kpi-value">{{ $misPedidos ?? 0 }}</div>
                        <div class="kpi-change positive">
                            <i class="fas fa-trophy"></i>
                            Total realizados
                        </div>
                    </div>
                </div>

                <div class="kpi-card">
                    <div class="kpi-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="kpi-content">
                        <h3>Reservas Activas</h3>
                        <div class="kpi-value">{{ $reservasActivas ?? 0 }}</div>
                        <div class="kpi-change">
                            <i class="fas fa-calendar"></i>
                            Próximas
                        </div>
                    </div>
                </div>

                <div class="kpi-card">
                    <div class="kpi-icon">
                        <i class="fas fa-hourglass-half"></i>
                    </div>
                    <div class="kpi-content">
                        <h3>Pedidos Pendientes</h3>
                        <div class="kpi-value">{{ $pedidosPendientes ?? 0 }}</div>
                        <div class="kpi-change positive">
                            <i class="fas fa-spinner"></i>
                            En proceso
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mis Reservas Recientes -->
            <div class="chart-container">
                <div class="chart-header">
                    <h3 class="chart-title">Mis Reservas Recientes</h3>
                    <a href="{{ route('reservas.index') }}" class="btn btn-primary btn-small">Ver Todas</a>
                </div>
                
                @if(isset($misReservasRecientes) && count($misReservasRecientes) > 0)
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
                            @foreach($misReservasRecientes as $reserva)
                            <tr>
                                <td>{{ $reserva->fecha ? \Carbon\Carbon::parse($reserva->fecha)->format('d/m/Y') : 'N/A' }}</td>
                                <td>{{ $reserva->hora ?? 'N/A' }}</td>
                                <td>{{ $reserva->personas ?? 'N/A' }}</td>
                                <td>
                                    <span class="status-badge status-confirmed">
                                        Confirmada
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="empty-state">
                        <i class="fas fa-calendar-check"></i>
                        <h3>¡Excelente!</h3>
                        <p>No tienes reservas pendientes en este momento.</p>
                        <a href="{{ route('reservas.create') }}" class="btn btn-primary">
                            <i class="fas fa-calendar-plus"></i> Hacer Reserva
                        </a>
                    </div>
                @endif
            </div>

            <!-- Accesos Rápidos -->
            <div class="grid grid-2">
                <div class="card text-center">
                    <i class="fas fa-utensils" style="font-size: 3rem; color: var(--color-primary); margin-bottom: var(--spacing-md);"></i>
                    <h3 class="title-secondary">Ver Menú</h3>
                    <p class="mb-lg">Explora nuestros deliciosos platos y bebidas tradicionales.</p>
                    <a href="{{ route('menu.index') }}" class="btn btn-primary">
                        <i class="fas fa-utensils"></i> Ver Menú
                    </a>
                </div>

                <div class="card text-center">
                    <i class="fas fa-calendar-plus" style="font-size: 3rem; color: var(--color-primary); margin-bottom: var(--spacing-md);"></i>
                    <h3 class="title-secondary">Hacer Reserva</h3>
                    <p class="mb-lg">Reserva tu mesa y disfruta de una experiencia única.</p>
                    <a href="{{ route('reservas.create') }}" class="btn btn-primary">
                        <i class="fas fa-calendar-plus"></i> Reservar Mesa
                    </a>
                </div>
            </div>
        </section>

        <!-- Sección: Mis Reservas -->
        <section id="reservas" class="dashboard-section">
            <h2 class="section-title">Mis Reservas</h2>
            <div class="text-center p-xl">
                <i class="fas fa-calendar-check" style="font-size: 4rem; color: var(--color-primary); margin-bottom: var(--spacing-md);"></i>
                <h3>Gestionar Mis Reservas</h3>
                <p class="mb-lg">Consulta y administra todas tus reservas realizadas.</p>
                <a href="{{ route('reservas.index') }}" class="btn btn-primary btn-large">
                    <i class="fas fa-calendar-check"></i> Ver Mis Reservas
                </a>
            </div>
        </section>

        <!-- Sección: Ver Menú -->
        <section id="menu" class="dashboard-section">
            <h2 class="section-title">Nuestro Menú</h2>
            <div class="text-center p-xl">
                <i class="fas fa-utensils" style="font-size: 4rem; color: var(--color-primary); margin-bottom: var(--spacing-md);"></i>
                <h3>Explora Nuestro Menú</h3>
                <p class="mb-lg">Descubre nuestros platos tradicionales colombianos y bebidas.</p>
                <a href="{{ route('menu.index') }}" class="btn btn-primary btn-large">
                    <i class="fas fa-utensils"></i> Ver Menú Completo
                </a>
            </div>
        </section>

        <!-- Sección: Mis Pedidos -->
        <section id="pedidos" class="dashboard-section">
            <h2 class="section-title">Mis Pedidos</h2>
            <div class="text-center p-xl">
                <i class="fas fa-shopping-bag" style="font-size: 4rem; color: var(--color-primary); margin-bottom: var(--spacing-md);"></i>
                <h3>Historial de Pedidos</h3>
                <p class="mb-lg">Revisa el estado de todos tus pedidos realizados.</p>
                <a href="{{ route('pedidos.index') }}" class="btn btn-primary btn-large">
                    <i class="fas fa-shopping-bag"></i> Ver Mis Pedidos
                </a>
            </div>
        </section>

        <!-- Sección: Mi Perfil -->
        <section id="perfil" class="dashboard-section">
            <h2 class="section-title">Mi Perfil</h2>
            <div class="text-center p-xl">
                <i class="fas fa-user-cog" style="font-size: 4rem; color: var(--color-primary); margin-bottom: var(--spacing-md);"></i>
                <h3>Configuración de Perfil</h3>
                <p class="mb-lg">Actualiza tu información personal y preferencias.</p>
                <a href="{{ route('profile') }}" class="btn btn-primary btn-large">
                    <i class="fas fa-user-edit"></i> Editar Mi Perfil
                </a>
            </div>
        </section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Navegación del sidebar - copiado exactamente del empleado
    const sidebarLinks = document.querySelectorAll('.sidebar-link-admin');
    const sections = document.querySelectorAll('.dashboard-section');

    sidebarLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Solo manejar links internos del dashboard
            if (this.getAttribute('href').startsWith('#')) {
                e.preventDefault();
                
                const targetSection = this.getAttribute('href').substring(1);
                
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
            }
        });
    });

    console.log('Dashboard del cliente cargado correctamente');
});
</script>
@endpush
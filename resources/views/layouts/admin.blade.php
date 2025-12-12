<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel Admin - Olla y Sazón')</title>
    <link rel="stylesheet" href="{{ asset('css/admin-layout.css') }}">
    <link rel="stylesheet" href="{{ asset('css/contrast-fixes.css') }}">
    <link rel="stylesheet" href="{{ asset('css/global-background.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    @stack('styles')
</head>
<body class="admin-layout" style="background: linear-gradient(120deg, #fff 60%, #181828 100%); background-attachment: fixed; color: #ffffff; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; margin: 0; padding: 0;">
    <header class="admin-header" style="background: #181828; color: #ffd700; padding: 0.5rem 2rem; display: flex; align-items: center; justify-content: space-between; min-height: 56px;">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <i class="fas fa-utensils" style="font-size: 1.5rem;"></i>
            <span style="font-family: 'Playfair Display', serif; font-size: 1.3rem; font-weight: 700; letter-spacing: 1px;">Olla y Sazón</span>
            <span style="font-size: 1rem; color: #fff; opacity: 0.7; margin-left: 1rem;">Panel de Administración</span>
        </div>
        <div style="display: flex; align-items: center; gap: 1rem;">
            <span style="background: #ffd700; color: #181828; border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-weight: bold;">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span>
            <span style="color: #ffd700; font-weight: 600;">{{ auth()->user()->name }}</span>
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" title="Cerrar Sesión" style="background: none; border: none; color: #ffd700; font-size: 1.2rem; cursor: pointer;"><i class="fas fa-sign-out-alt"></i></button>
            </form>
        </div>
    </header>
    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="admin-sidebar">
            <nav>
                <ul>
                    <li>
                        <a href="/" class="sidebar-link-admin" style="background: #ffd700; color: #181828; font-weight: bold;">
                            <i class="fas fa-home"></i> Home
                        </a>
                    </li>
                    <li><a href="{{ route('dashboard') }}" class="sidebar-link-admin{{ request()->routeIs('dashboard') ? ' active' : '' }}"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li><a href="{{ route('reservas.index') }}" class="sidebar-link-admin{{ request()->routeIs('reservas.*') ? ' active' : '' }}"><i class="fas fa-calendar-alt"></i> Reservas</a></li>
                    <li><a href="{{ route('pedidos.index') }}" class="sidebar-link-admin{{ request()->routeIs('pedidos.*') ? ' active' : '' }}"><i class="fas fa-clipboard-list"></i> Pedidos</a></li>
                    <li><a href="{{ route('users.index') }}" class="sidebar-link-admin{{ request()->routeIs('users.*') ? ' active' : '' }}"><i class="fas fa-users"></i> Usuarios</a></li>
                    <li><a href="{{ route('productos.index') }}" class="sidebar-link-admin{{ request()->routeIs('productos.*') ? ' active' : '' }}"><i class="fas fa-utensils"></i> Productos</a></li>
                    <li><a href="{{ route('categorias.index') }}" class="sidebar-link-admin{{ request()->routeIs('categorias.*') ? ' active' : '' }}"><i class="fas fa-tags"></i> Categorías</a></li>
                    <li><a href="{{ route('inventario.index') }}" class="sidebar-link-admin{{ request()->routeIs('inventario.*') ? ' active' : '' }}"><i class="fas fa-boxes"></i> Inventario</a></li>
                    <li><a href="{{ route('mesas.index') }}" class="sidebar-link-admin{{ request()->routeIs('mesas.*') ? ' active' : '' }}"><i class="fas fa-chair"></i> Mesas</a></li>
                    <li><a href="{{ route('horarios.index') }}" class="sidebar-link-admin{{ request()->routeIs('horarios.*') ? ' active' : '' }}"><i class="fas fa-clock"></i> Horarios</a></li>
                    <li><a href="{{ route('noticias.index') }}" class="sidebar-link-admin{{ request()->routeIs('noticias.*') ? ' active' : '' }}"><i class="fas fa-newspaper"></i> Noticias</a></li>
                    <li><a href="{{ route('pagos.admin') }}" class="sidebar-link-admin{{ request()->routeIs('pagos.admin') ? ' active' : '' }}"><i class="fas fa-credit-card"></i> Pagos</a></li>
                    <li><a href="{{ route('promociones.index') }}" class="sidebar-link-admin{{ request()->routeIs('promociones.*') ? ' active' : '' }}"><i class="fas fa-tags"></i> Promociones</a></li>
                    <li><a href="{{ route('reportes.index') }}" class="sidebar-link-admin{{ request()->routeIs('reportes.*') ? ' active' : '' }}"><i class="fas fa-chart-bar"></i> Reportes</a></li>
                </ul>
            </nav>
        </aside>
        <!-- Main Content -->
        <main class="admin-main-content">
            @yield('content')
        </main>
    </div>
    @stack('scripts')
</body>
</html>

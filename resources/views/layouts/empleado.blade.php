<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Panel Empleado - Olla y Sazón')</title>
    <link rel="stylesheet" href="{{ asset('css/sistema-diseno.css') }}">
    <link rel="stylesheet" href="{{ asset('css/contrast-fixes.css') }}">
    <link rel="stylesheet" href="{{ asset('css/global-background.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    @stack('styles')
</head>
<body style="background: linear-gradient(120deg, #fff 60%, #181828 100%); background-attachment: fixed; min-height: 100vh;">
    <header class="admin-header" style="background: #181828; color: #ffd700; padding: 0.5rem 2rem; display: flex; align-items: center; justify-content: space-between; min-height: 56px;">
        <div style="display: flex; align-items: center; gap: 1rem;">
            <i class="fas fa-utensils" style="font-size: 1.5rem;"></i>
            <span style="font-family: 'Playfair Display', serif; font-size: 1.3rem; font-weight: 700; letter-spacing: 1px;">Olla y Sazón</span>
            <span style="font-size: 1rem; color: #fff; opacity: 0.7; margin-left: 1rem;">Panel de Empleado</span>
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
    <div style="display: flex; min-height: 100vh;">
        <!-- Sidebar -->
        <aside class="admin-sidebar" style="width: 220px; background: #181828; color: #ffd700; padding: 2rem 0 2rem 0.5rem; display: flex; flex-direction: column; gap: 1rem;">
            <nav>
                <ul style="list-style: none; padding: 0; margin: 0;">
                    <li>
                        <a href="/" class="sidebar-link-admin" style="background: #ffd700; color: #181828; font-weight: bold;">
                            <i class="fas fa-home"></i> Home
                        </a>
                    </li>
                    <li><a href="{{ route('dashboard') }}" class="sidebar-link-admin{{ request()->routeIs('dashboard') ? ' active' : '' }}"><i class="fas fa-tachometer-alt"></i> Mi Panel</a></li>
                    <li><a href="{{ route('pedidos.index') }}" class="sidebar-link-admin{{ request()->routeIs('pedidos.*') ? ' active' : '' }}"><i class="fas fa-clipboard-list"></i> Mis Pedidos</a></li>
                    <li><a href="{{ route('horarios.index') }}" class="sidebar-link-admin{{ request()->routeIs('horarios.*') ? ' active' : '' }}"><i class="fas fa-clock"></i> Horarios</a></li>
                </ul>
                <style>
                .sidebar-link-admin {
                    display: flex;
                    align-items: center;
                    gap: 0.7rem;
                    color: #ffd700;
                    text-decoration: none;
                    padding: 0.7rem 1.2rem;
                    border-radius: 8px;
                    font-weight: 500;
                    margin-bottom: 0.2rem;
                    transition: background 0.2s, color 0.2s;
                }
                .sidebar-link-admin.active, .sidebar-link-admin:hover {
                    background: #ffd700;
                    color: #181828 !important;
                }
                </style>
            </nav>
        </aside>
        <!-- Main Content -->
        <main class="admin-main-content" style="flex: 1; padding: 2rem;">
            @yield('content')
        </main>
    </div>
    @stack('scripts')
</body>
</html>

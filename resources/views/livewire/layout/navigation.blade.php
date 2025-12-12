<div>
    <nav x-data="{ open: false }" class="navbar-elegant">
        <!-- Primary Navigation Menu -->
        <div class="nav-container-elegant">
        <div class="flex items-center">
            <!-- Logo -->
            <div class="nav-logo-elegant">
                <a href="/">
                    <i class="fas fa-utensils"></i>
                    <span class="logo-text">Olla y Sazón</span>
                </a>
            </div>

            <!-- Navigation Links -->
            <div class="hidden lg:flex lg:ml-8">
                <ul class="nav-menu-elegant">
                    <li>
                        <a href="{{ route('dashboard') }}" class="nav-link-elegant {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    
                    <li>
                        <a href="/" class="nav-link-elegant">
                            <i class="fas fa-home"></i> Home
                        </a>
                    </li>

                    @auth
                        <li>
                            <a href="{{ route('reservas.index') }}" class="nav-link-elegant {{ request()->routeIs('reservas.*') ? 'active' : '' }}">
                                <i class="fas fa-calendar-alt"></i> Reservas
                            </a>
                        </li>
                    @endauth

                    @auth
                        @if(auth()->user()->rol === 'admin')
                            <li>
                                <a href="{{ route('users.index') }}" class="nav-link-elegant {{ request()->routeIs('users.*') ? 'active' : '' }}">
                                    <i class="fas fa-users"></i> Usuarios
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('mesas.index') }}" class="nav-link-elegant {{ request()->routeIs('mesas.*') ? 'active' : '' }}">
                                    <i class="fas fa-chair"></i> Mesas
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('categorias.index') }}" class="nav-link-elegant {{ request()->routeIs('categorias.*') ? 'active' : '' }}">
                                    <i class="fas fa-tags"></i> Categorías
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('productos.index') }}" class="nav-link-elegant {{ request()->routeIs('productos.*') ? 'active' : '' }}">
                                    <i class="fas fa-utensils"></i> Productos
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('horarios.index') }}" class="nav-link-elegant {{ request()->routeIs('horarios.*') ? 'active' : '' }}">
                                    <i class="fas fa-clock"></i> Horarios
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('pedidos.index') }}" class="nav-link-elegant {{ request()->routeIs('pedidos.*') ? 'active' : '' }}">
                                    <i class="fas fa-clipboard-list"></i> Pedidos
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('pagos.index') }}" class="nav-link-elegant {{ request()->routeIs('pagos.*') ? 'active' : '' }}">
                                    <i class="fas fa-credit-card"></i> Pagos
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('noticias.index') }}" class="nav-link-elegant {{ request()->routeIs('noticias.*') ? 'active' : '' }}">
                                    <i class="fas fa-newspaper"></i> Noticias
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('promociones.index') }}" class="nav-link-elegant {{ request()->routeIs('promociones.*') ? 'active' : '' }}">
                                    <i class="fas fa-percent"></i> Promociones
                                </a>
                            </li>
                        @endif

                        @if(auth()->user()->rol === 'empleado')
                            <li>
                                <a href="{{ route('pedidos.index') }}" class="nav-link-elegant {{ request()->routeIs('pedidos.index') ? 'active' : '' }}">
                                    <i class="fas fa-clipboard-list"></i> Mis Pedidos
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('horarios.index') }}" class="nav-link-elegant {{ request()->routeIs('horarios.index') ? 'active' : '' }}">
                                    <i class="fas fa-clock"></i> Mis Horarios
                                </a>
                            </li>
                        @endif

                        @if(auth()->user()->rol === 'cliente')
                            <li>
                                <a href="{{ route('pedidos.index') }}" class="nav-link-elegant {{ request()->routeIs('pedidos.index') ? 'active' : '' }}">
                                    <i class="fas fa-clipboard-list"></i> Mis Pedidos
                                </a>
                            </li>

                            <li>
                                <a href="{{ route('pagos.index') }}" class="nav-link-elegant {{ request()->routeIs('pagos.*') ? 'active' : '' }}">
                                    <i class="fas fa-credit-card"></i> Mis Pagos
                                </a>
                            </li>
                        @endif
                    @endauth
                </ul>
            </div>
        </div>

        <!-- Settings Dropdown -->
        @auth
            <div class="hidden lg:flex lg:items-center lg:ml-6">
                <div class="relative" x-data="{ open: false }">
                    <button @click="open = !open" class="user-menu-btn">
                        <i class="fas fa-user"></i>
                        <span>
                            @if(auth()->user()->name == 'Admin Restaurante')
                                Admin Olla y Sazón
                            @else
                                {{ auth()->user()->name }}
                            @endif
                        </span>
                        <i class="fas fa-chevron-down ml-1"></i>
                    </button>

                    <div x-show="open" @click.away="open = false" x-transition class="user-menu">
                        <a href="{{ route('profile') }}" class="user-menu-item">
                            <i class="fas fa-user-cog"></i> Mi Perfil
                        </a>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="user-menu-item logout-btn">
                                <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endauth

        <!-- Hamburger -->
        <div class="flex items-center lg:hidden">
            <button @click="open = !open" class="hamburger-btn">
                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                    <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden lg:hidden">
        <div class="mobile-menu">
            <a href="{{ route('dashboard') }}" class="mobile-menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            
            <a href="/" class="mobile-menu-item">
                <i class="fas fa-home"></i> Home
            </a>

            @auth
                <a href="{{ route('reservas.index') }}" class="mobile-menu-item {{ request()->routeIs('reservas.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-alt"></i> Reservas
                </a>

                @if(auth()->user()->rol === 'admin')
                    <a href="{{ route('users.index') }}" class="mobile-menu-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i> Usuarios
                    </a>

                    <a href="{{ route('mesas.index') }}" class="mobile-menu-item {{ request()->routeIs('mesas.*') ? 'active' : '' }}">
                        <i class="fas fa-chair"></i> Mesas
                    </a>

                    <a href="{{ route('categorias.index') }}" class="mobile-menu-item {{ request()->routeIs('categorias.*') ? 'active' : '' }}">
                        <i class="fas fa-tags"></i> Categorías
                    </a>

                    <a href="{{ route('productos.index') }}" class="mobile-menu-item {{ request()->routeIs('productos.*') ? 'active' : '' }}">
                        <i class="fas fa-utensils"></i> Productos
                    </a>

                    <a href="{{ route('horarios.index') }}" class="mobile-menu-item {{ request()->routeIs('horarios.*') ? 'active' : '' }}">
                        <i class="fas fa-clock"></i> Horarios
                    </a>

                    <a href="{{ route('pedidos.index') }}" class="mobile-menu-item {{ request()->routeIs('pedidos.*') ? 'active' : '' }}">
                        <i class="fas fa-clipboard-list"></i> Pedidos
                    </a>

                    <a href="{{ route('pagos.index') }}" class="mobile-menu-item {{ request()->routeIs('pagos.*') ? 'active' : '' }}">
                        <i class="fas fa-credit-card"></i> Pagos
                    </a>

                    <a href="{{ route('noticias.index') }}" class="mobile-menu-item {{ request()->routeIs('noticias.*') ? 'active' : '' }}">
                        <i class="fas fa-newspaper"></i> Noticias
                    </a>

                    <a href="{{ route('promociones.index') }}" class="mobile-menu-item {{ request()->routeIs('promociones.*') ? 'active' : '' }}">
                        <i class="fas fa-percent"></i> Promociones
                    </a>
                @endif
            @endauth

            <!-- Mobile User Menu -->
            @auth
                <div class="mobile-user-section">
                    <div class="mobile-user-info">
                        <span class="mobile-user-name">{{ auth()->user()->name }}</span>
                        <span class="mobile-user-email">{{ auth()->user()->email }}</span>
                    </div>

                    <a href="{{ route('profile') }}" class="mobile-menu-item">
                        <i class="fas fa-user-cog"></i> Mi Perfil
                    </a>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="mobile-menu-item logout-btn">
                            <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                        </button>
                    </form>
                </div>
            @endauth
        </div>
        </div>
    </nav>

    <style>
/* Navegación elegante */
.navbar-elegant {
    background: linear-gradient(135deg, rgba(0, 0, 0, 0.95) 0%, rgba(15, 15, 35, 0.95) 100%);
    backdrop-filter: blur(15px);
    border-bottom: 2px solid #ffd700;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
    position: sticky;
    top: 0;
    z-index: 1000;
}

.nav-container-elegant {
    max-width: 1400px;
    margin: 0 auto;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.8rem 2rem;
}

.nav-logo-elegant a {
    display: flex;
    align-items: center;
    gap: 0.8rem;
    text-decoration: none;
    color: #ffd700;
    font-size: 1.5rem;
    font-weight: bold;
    transition: all 0.3s ease;
}

.nav-logo-elegant a:hover {
    color: #ffed4e;
    transform: scale(1.05);
}

.nav-logo-elegant i {
    font-size: 2rem;
    background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.logo-text {
    font-family: 'Playfair Display', serif;
    font-size: 1.8rem;
    font-weight: 700;
}

.nav-menu-elegant {
    display: flex;
    list-style: none;
    margin: 0;
    padding: 0;
    gap: 0.5rem;
    align-items: center;
}

.nav-link-elegant {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.6rem 1rem;
    color: #ffffff;
    text-decoration: none;
    border-radius: 8px;
    transition: all 0.3s ease;
    font-weight: 500;
    font-size: 0.9rem;
    position: relative;
    overflow: hidden;
}

.nav-link-elegant::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, rgba(255, 215, 0, 0.2), transparent);
    transition: left 0.5s ease;
}

.nav-link-elegant:hover::before {
    left: 100%;
}

.nav-link-elegant:hover {
    color: #ffd700;
    background: rgba(255, 215, 0, 0.1);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(255, 215, 0, 0.2);
}

.nav-link-elegant.active {
    background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
    color: #000;
    font-weight: 600;
}

.nav-link-elegant i {
    font-size: 1rem;
    width: 16px;
    text-align: center;
}

.user-menu-btn {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.6rem 1rem;
    background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
    color: #000;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
}

.user-menu-btn:hover {
    background: linear-gradient(135deg, #ffed4e 0%, #ffd700 100%);
    transform: translateY(-2px);
}

.user-menu {
    position: absolute;
    right: 0;
    top: 100%;
    background: rgba(15, 15, 35, 0.95);
    border: 2px solid #ffd700;
    border-radius: 15px;
    min-width: 200px;
    backdrop-filter: blur(15px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
    margin-top: 0.5rem;
}

.user-menu-item {
    display: block;
    padding: 12px 16px;
    color: #ffffff;
    text-decoration: none;
    border-bottom: 1px solid rgba(255, 215, 0, 0.2);
    transition: all 0.3s ease;
    background: none;
    border: none;
    width: 100%;
    text-align: left;
    cursor: pointer;
    font-size: 1rem;
}

.user-menu-item:hover {
    background: rgba(255, 215, 0, 0.1);
    color: #ffd700;
}

.user-menu-item.logout-btn:hover {
    background: rgba(255, 71, 87, 0.1);
    color: #ff4757;
}

.hamburger-btn {
    background: none;
    border: none;
    color: #ffd700;
    cursor: pointer;
    padding: 0.5rem;
}

.mobile-menu {
    background: rgba(15, 15, 35, 0.98);
    border-top: 1px solid rgba(255, 215, 0, 0.3);
    padding: 1rem;
}

.mobile-menu-item {
    display: block;
    padding: 12px 16px;
    color: #ffffff;
    text-decoration: none;
    border-radius: 8px;
    margin-bottom: 0.5rem;
    transition: all 0.3s ease;
    background: none;
    border: none;
    width: 100%;
    text-align: left;
    cursor: pointer;
    font-size: 1rem;
}

.mobile-menu-item:hover {
    background: rgba(255, 215, 0, 0.1);
    color: #ffd700;
}

.mobile-menu-item.active {
    background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
    color: #000;
    font-weight: 600;
}

.mobile-user-section {
    border-top: 1px solid rgba(255, 215, 0, 0.3);
    margin-top: 1rem;
    padding-top: 1rem;
}

.mobile-user-info {
    padding: 1rem;
    text-align: center;
}

.mobile-user-name {
    display: block;
    color: #ffd700;
    font-weight: 600;
    font-size: 1.1rem;
}

.mobile-user-email {
    display: block;
    color: #e0e0e0;
    font-size: 0.9rem;
    margin-top: 0.25rem;
}

@media (max-width: 1024px) {
    .nav-menu-elegant {
        gap: 0.3rem;
    }
    
    .nav-link-elegant {
        padding: 0.5rem 0.8rem;
        font-size: 0.85rem;
    }
}
    </style>
</div>
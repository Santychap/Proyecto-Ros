<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Restaurante Elegante')</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/sistema-diseno.css') }}">
    @stack('styles')
    
    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    
    <!-- Meta -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Restaurante Elegante - La mejor experiencia culinaria">
    <meta name="keywords" content="restaurante, comida, reservas, delivery">
</head>
<body class="bg-dark-gradient particles-bg">
    <!-- Navegación Principal -->
    <nav class="navbar-elegant">
        <div class="nav-container-elegant">
            <!-- Logo -->
            @if(auth()->check() && auth()->user()->rol === 'empleado')
                <span class="nav-logo-elegant">
                    <i class="fas fa-utensils"></i> 
                    <span class="logo-text">Olla y Sazón</span>
                    <span class="logo-subtitle">Panel Empleado</span>
                </span>
            @else
                <a href="{{ url('/') }}" class="nav-logo-elegant">
                    <i class="fas fa-utensils"></i> 
                    <span class="logo-text">Olla y Sazón</span>
                </a>
            @endif

            <!-- Menú de navegación -->
            <ul class="nav-menu-elegant">
                @if(auth()->check() && auth()->user()->rol === 'admin')
                    <!-- Navegación para admin -->
                    <li><a href="{{ route('dashboard') }}" class="nav-link-elegant">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a></li>
                    <li><a href="{{ url('/') }}" class="nav-link-elegant">
                        <i class="fas fa-home"></i> Home
                    </a></li>
                    <li><a href="{{ route('reservas.index') }}" class="nav-link-elegant">
                        <i class="fas fa-calendar-alt"></i> Reservas
                    </a></li>
                    <li><a href="{{ route('users.index') }}" class="nav-link-elegant">
                        <i class="fas fa-users"></i> Usuarios
                    </a></li>
                    <li><a href="{{ route('mesas.index') }}" class="nav-link-elegant">
                        <i class="fas fa-chair"></i> Mesas
                    </a></li>
                    <li><a href="{{ route('categorias.index') }}" class="nav-link-elegant">
                        <i class="fas fa-tags"></i> Categorías
                    </a></li>
                    <li><a href="{{ route('productos.index') }}" class="nav-link-elegant">
                        <i class="fas fa-utensils"></i> Productos
                    </a></li>
                    <li><a href="{{ route('horarios.index') }}" class="nav-link-elegant">
                        <i class="fas fa-clock"></i> Horarios
                    </a></li>
                    <li><a href="{{ route('pedidos.index') }}" class="nav-link-elegant">
                        <i class="fas fa-clipboard-list"></i> Pedidos
                    </a></li>
                    <li><a href="{{ route('pagos.index') }}" class="nav-link-elegant">
                        <i class="fas fa-credit-card"></i> Pagos
                    </a></li>
                    <li><a href="{{ route('noticias.index') }}" class="nav-link-elegant">
                        <i class="fas fa-newspaper"></i> Noticias
                    </a></li>
                    <li><a href="{{ route('promociones.index') }}" class="nav-link-elegant">
                        <i class="fas fa-percent"></i> Promociones
                    </a></li>
                @elseif(auth()->check() && auth()->user()->rol === 'empleado')
                    <!-- Navegación para empleados -->
                    <li><a href="{{ route('pedidos.index') }}" class="nav-link-elegant">
                        <i class="fas fa-clipboard-list"></i> Pedidos
                    </a></li>
                    <li><a href="{{ route('horarios.index') }}" class="nav-link-elegant">
                        <i class="fas fa-clock"></i> Horarios
                    </a></li>
                @else
                    <!-- Navegación para clientes y visitantes -->
                    <li><a href="{{ url('/') }}" class="nav-link-elegant">
                        <i class="fas fa-home"></i> Inicio
                    </a></li>
                    <li><a href="{{ url('/menu') }}" class="nav-link-elegant">
                        <i class="fas fa-utensils"></i> Menú
                    </a></li>
                    <li><a href="{{ url('/reservas-web') }}" class="nav-link-elegant">
                        <i class="fas fa-calendar-alt"></i> Reservas
                    </a></li>
                    <li><a href="{{ url('/noticias-web') }}" class="nav-link-elegant">
                        <i class="fas fa-newspaper"></i> Noticias
                    </a></li>
                    <li><a href="{{ url('/promociones-web') }}" class="nav-link-elegant">
                        <i class="fas fa-tags"></i> Promociones
                    </a></li>
                @endif
            </ul>

            <!-- Acciones del usuario -->
            <div class="nav-actions">
                @auth
                    <!-- Carrito (solo para clientes) -->
                    @if(auth()->user()->rol === 'cliente')
                        <a href="{{ route('carrito.index') }}" class="btn btn-primary btn-small">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="cart-count">{{ session('carrito') ? count(session('carrito')) : 0 }}</span>
                        </a>
                    @endif
                    
                    <!-- Dashboard (solo para admin y empleados) -->
                    @if(auth()->user()->rol === 'admin' || auth()->user()->rol === 'empleado')
                        <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-small">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    @endif
                    
                    <!-- Dropdown de usuario -->
                    <div class="user-dropdown" style="position: relative; display: inline-block;">
                        <button class="btn btn-primary btn-small user-menu-btn" onclick="toggleUserMenu()" style="color: #000000;">
                            <i class="fas fa-user" style="color: #000000;"></i> 
                            @if(auth()->user()->name == 'Admin Restaurante')
                                <span style="color: #000000;">Admin Olla y Sazón</span>
                            @else
                                <span style="color: #000000;">{{ auth()->user()->name }}</span>
                            @endif
                            <i class="fas fa-chevron-down" style="margin-left: 5px; font-size: 0.8rem; color: #000000;"></i>
                        </button>
                        <div class="user-menu" id="userMenu" style="display: none; position: absolute; right: 0; top: 100%; background: var(--bg-glass); border: 2px solid var(--color-primary); border-radius: var(--border-radius-medium); min-width: 200px; z-index: 1000; backdrop-filter: blur(15px); box-shadow: var(--shadow-large);">
                            <a href="{{ route('profile') }}" style="display: block; padding: 12px 16px; color: var(--text-light); text-decoration: none; border-bottom: 1px solid rgba(255, 215, 0, 0.2); transition: all 0.3s ease;">
                                <i class="fas fa-user-cog"></i> Mi Perfil
                            </a>
                            @if(auth()->user()->rol !== 'cliente')
                                <a href="{{ route('dashboard') }}" style="display: block; padding: 12px 16px; color: var(--text-light); text-decoration: none; border-bottom: 1px solid rgba(255, 215, 0, 0.2); transition: all 0.3s ease;">
                                    <i class="fas fa-tachometer-alt"></i> Dashboard
                                </a>
                            @endif
                            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                                @csrf
                                <button type="submit" style="width: 100%; text-align: left; background: none; border: none; padding: 12px 16px; color: var(--color-error); cursor: pointer; transition: all 0.3s ease; font-size: var(--font-size-base);">
                                    <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <!-- Login/Register -->
                    <a href="{{ route('login') }}" class="btn btn-secondary btn-small">
                        <i class="fas fa-sign-in-alt"></i> Entrar
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-primary btn-small">
                        <i class="fas fa-user-plus"></i> Registro
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Contenido Principal -->
    <main class="main-content">
        <!-- Alertas -->
        @if(session('success'))
            <div class="alert alert-success mb-lg">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger mb-lg">
                <i class="fas fa-exclamation-circle"></i>
                {{ session('error') }}
            </div>
        @endif

        @if(session('warning'))
            <div class="alert alert-warning mb-lg">
                <i class="fas fa-exclamation-triangle"></i>
                {{ session('warning') }}
            </div>
        @endif

        @if(session('info'))
            <div class="alert alert-info mb-lg">
                <i class="fas fa-info-circle"></i>
                {{ session('info') }}
            </div>
        @endif

        <!-- Contenido de la página -->
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="nav-container">
            <div class="footer-content grid grid-3">
                <div class="footer-section">
                    <h3 class="title-secondary">Olla y Sazón</h3>
                    <p class="mb-md">Ofreciendo la mejor experiencia culinaria con ingredientes frescos y un ambiente acogedor desde 1995.</p>
                    <div class="social-links">
                        <a href="#" class="btn btn-secondary btn-small">
                            <i class="fab fa-facebook"></i>
                        </a>
                        <a href="#" class="btn btn-secondary btn-small">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="btn btn-secondary btn-small">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </div>
                </div>
                
                <div class="footer-section">
                    <h3 class="title-secondary">Contacto</h3>
                    <div class="contact-info">
                        <div class="contact-item mb-sm">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>Calle Principal 123, Ciudad, País</span>
                        </div>
                        <div class="contact-item mb-sm">
                            <i class="fas fa-phone"></i>
                            <span>+1 234 567 8900</span>
                        </div>
                        <div class="contact-item mb-sm">
                            <i class="fas fa-envelope"></i>
                            <span>info@restauranteelegante.com</span>
                        </div>
                    </div>
                </div>
                
                <div class="footer-section">
                    <h3 class="title-secondary">Horarios</h3>
                    <div class="schedule">
                        <p class="mb-sm"><strong>Lunes - Viernes:</strong><br>12:00 PM - 10:00 PM</p>
                        <p class="mb-sm"><strong>Sábado - Domingo:</strong><br>11:00 AM - 11:00 PM</p>
                        <p class="mb-sm"><strong>Días Festivos:</strong><br>Consultar disponibilidad</p>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom text-center p-md" style="border-top: 1px solid rgba(255, 215, 0, 0.2); margin-top: var(--spacing-lg);">
                <p>&copy; {{ date('Y') }} Olla y Sazón. Todos los derechos reservados.</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    @stack('scripts')
    
    <script>
        // Actualizar contador del carrito
        function updateCartCount() {
            fetch('/carrito/count')
                .then(response => response.json())
                .then(data => {
                    const cartCount = document.querySelector('.cart-count');
                    if (cartCount) {
                        cartCount.textContent = data.count;
                    }
                })
                .catch(error => console.log('Error updating cart count:', error));
        }

        // Menú desplegable de usuario
        function toggleUserMenu() {
            const menu = document.getElementById('userMenu');
            menu.style.display = menu.style.display === 'none' ? 'block' : 'none';
        }

        // Cerrar menú al hacer clic fuera
        document.addEventListener('click', function(e) {
            const userDropdown = document.querySelector('.user-dropdown');
            const userMenu = document.getElementById('userMenu');
            
            if (userDropdown && !userDropdown.contains(e.target)) {
                if (userMenu) {
                    userMenu.style.display = 'none';
                }
            }
        });

        // Efectos de navegación
        document.addEventListener('DOMContentLoaded', function() {
            // Resaltar enlace activo
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.nav-link');
            
            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('active');
                }
            });

            // Auto-hide alerts
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                setTimeout(() => {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-20px)';
                    setTimeout(() => alert.remove(), 300);
                }, 5000);
            });
        });
    </script>

    <style>
        /* Navegación elegante */
        .navbar-elegant {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.95) 0%, rgba(15, 15, 35, 0.95) 100%);
            backdrop-filter: blur(15px);
            border-bottom: 2px solid var(--color-primary);
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
            flex-wrap: wrap;
            gap: 1rem;
        }

        .nav-logo-elegant {
            display: flex;
            align-items: center;
            gap: 0.8rem;
            text-decoration: none;
            color: var(--color-primary);
            font-size: 1.5rem;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .nav-logo-elegant:hover {
            color: var(--color-primary-light);
            transform: scale(1.05);
        }

        .nav-logo-elegant i {
            font-size: 2rem;
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-light) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .logo-text {
            font-family: 'Playfair Display', serif;
            font-size: 1.8rem;
            font-weight: 700;
        }

        .logo-subtitle {
            font-size: 0.9rem;
            color: var(--text-muted);
            font-weight: 400;
            margin-left: 0.5rem;
        }

        .nav-menu-elegant {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
            gap: 0.5rem;
            flex-wrap: wrap;
            align-items: center;
        }

        .nav-link-elegant {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.6rem 1rem;
            color: var(--text-light);
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
            color: var(--color-primary);
            background: rgba(255, 215, 0, 0.1);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 215, 0, 0.2);
        }

        .nav-link-elegant.active {
            background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-light) 100%);
            color: #000;
            font-weight: 600;
        }

        .nav-link-elegant i {
            font-size: 1rem;
            width: 16px;
            text-align: center;
        }

        /* Estilos adicionales para el layout */
        .main-content {
            min-height: calc(100vh - 160px);
            padding-top: var(--spacing-xl);
        }

        .alert {
            max-width: 1400px;
            margin: 0 auto var(--spacing-lg);
            padding: var(--spacing-md);
            border-radius: var(--border-radius-medium);
            display: flex;
            align-items: center;
            gap: var(--spacing-sm);
            font-weight: 500;
            box-shadow: var(--shadow-small);
            transition: all var(--transition-normal);
        }

        .alert-success {
            background: linear-gradient(135deg, var(--color-success) 0%, #40c057 100%);
            color: white;
            border-left: 4px solid #2b8a3e;
        }

        .alert-danger {
            background: linear-gradient(135deg, var(--color-error) 0%, #ff3742 100%);
            color: white;
            border-left: 4px solid #c92a2a;
        }

        .alert-warning {
            background: linear-gradient(135deg, var(--color-warning) 0%, #fd7e14 100%);
            color: white;
            border-left: 4px solid #e8590c;
        }

        .alert-info {
            background: linear-gradient(135deg, var(--color-info) 0%, #26a69a 100%);
            color: white;
            border-left: 4px solid #00695c;
        }

        .footer {
            background: linear-gradient(135deg, rgba(0, 0, 0, 0.95) 0%, rgba(15, 15, 35, 0.95) 100%);
            color: var(--text-light);
            padding: var(--spacing-xl) 0 var(--spacing-md);
            margin-top: var(--spacing-xl);
            border-top: 2px solid var(--color-primary);
        }

        .footer-section h3 {
            color: var(--color-primary);
            margin-bottom: var(--spacing-md);
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: var(--spacing-sm);
            color: var(--text-muted);
        }

        .contact-item i {
            color: var(--color-primary);
            width: 20px;
        }

        .social-links {
            display: flex;
            gap: var(--spacing-sm);
            margin-top: var(--spacing-md);
        }

        .cart-count {
            background: linear-gradient(135deg, var(--color-error) 0%, #ff3742 100%);
            color: white;
            font-size: var(--font-size-xs);
            padding: 4px 8px;
            border-radius: 50%;
            min-width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            box-shadow: 0 2px 8px rgba(255, 71, 87, 0.4);
            animation: pulse 2s infinite;
        }

        /* Menú desplegable de usuario */
        .user-menu-btn {
            position: relative;
        }

        .user-menu a:hover,
        .user-menu button:hover {
            background: rgba(255, 215, 0, 0.1);
            color: var(--color-primary) !important;
        }

        .user-menu button[type="submit"]:hover {
            background: rgba(255, 71, 87, 0.1);
            color: var(--color-error) !important;
        }

        /* Animación del menú */
        .user-menu {
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 1200px) {
            .nav-menu-elegant {
                gap: 0.3rem;
            }
            
            .nav-link-elegant {
                padding: 0.5rem 0.8rem;
                font-size: 0.85rem;
            }
        }

        @media (max-width: 768px) {
            .nav-container-elegant {
                flex-direction: column;
                gap: 1rem;
                padding: 1rem;
            }

            .nav-menu-elegant {
                justify-content: center;
                gap: 0.5rem;
            }

            .nav-link-elegant {
                padding: 0.5rem 0.8rem;
                font-size: 0.8rem;
            }

            .logo-text {
                font-size: 1.5rem;
            }

            .nav-actions {
                flex-wrap: wrap;
                justify-content: center;
                gap: var(--spacing-sm);
            }

            .footer-content {
                grid-template-columns: 1fr;
                gap: var(--spacing-lg);
                text-align: center;
            }
        }
    </style>
</body>
</html>
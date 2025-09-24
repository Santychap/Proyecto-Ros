<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Restaurante Elegante')</title>
    
    <!-- CSS -->
    <link rel="stylesheet" href="{{ asset('css/sistema-diseno.css') }}">
    <link rel="stylesheet" href="{{ asset('css/global-background.css') }}">
    @stack('styles')
    
    <!-- Fonts -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
    
    <!-- Meta -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Restaurante Elegante - La mejor experiencia culinaria">
    <meta name="keywords" content="restaurante, comida, reservas, delivery">
</head>
<body style="background: linear-gradient(120deg, #fff 60%, #181828 100%); color: #181828;">

    <!-- Header Elegante como Welcome -->
    <header class="header" style="background: #fff; box-shadow: 0 2px 16px rgba(24,24,40,0.06); padding: 1.2rem 0 1.2rem 0; display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #d4af37;">
        <div style="display: flex; align-items: center; margin-left: 2.5rem;">
            <span style="font-family: 'Playfair Display', serif; font-size: 1.5rem; font-weight: 700; color: #d4af37; letter-spacing: 1px; display: flex; align-items: center;"><i class="fas fa-utensils" style="margin-right: 0.5rem;"></i>Olla y Sazón</span>
        </div>
        <nav class="header-nav" style="display: flex; gap: 2.5rem; margin-right: 2.5rem; align-items: center;">
            <a href="{{ url('/') }}" style="color: #181828; text-decoration: none; font-family: 'Playfair Display', serif; font-weight: 700; font-size: 1.15rem; letter-spacing: 1px; padding: 0.3rem 0.7rem; border-radius: 8px; transition: background 0.2s, color 0.2s;">Inicio</a>
            <a href="{{ route('menu.index') }}" style="color: #181828; text-decoration: none; font-family: 'Playfair Display', serif; font-weight: 700; font-size: 1.15rem; letter-spacing: 1px; padding: 0.3rem 0.7rem; border-radius: 8px; transition: background 0.2s, color 0.2s;">Menú</a>
            <a href="{{ route('reservas.publicCreate') }}" style="color: #181828; text-decoration: none; font-family: 'Playfair Display', serif; font-weight: 700; font-size: 1.15rem; letter-spacing: 1px; padding: 0.3rem 0.7rem; border-radius: 8px; transition: background 0.2s, color 0.2s;">Reservas</a>
            <a href="{{ route('promociones.publicIndex') }}" style="color: #181828; text-decoration: none; font-family: 'Playfair Display', serif; font-weight: 700; font-size: 1.15rem; letter-spacing: 1px; padding: 0.3rem 0.7rem; border-radius: 8px; transition: background 0.2s, color 0.2s;">Promociones</a>
            <a href="{{ route('noticias.publicIndex') }}" style="color: #181828; text-decoration: none; font-family: 'Playfair Display', serif; font-weight: 700; font-size: 1.15rem; letter-spacing: 1px; padding: 0.3rem 0.7rem; border-radius: 8px; transition: background 0.2s, color 0.2s;">Noticias</a>
            
            @if(request()->routeIs('menu.index') || request()->routeIs('reservas.publicCreate'))
                <!-- Carrito solo en menú -->
                @if(request()->routeIs('menu.index'))
                    <a href="{{ route('carrito.mostrar') }}" style="position: relative; display: flex; align-items: center; margin-left: 1rem;">
                        <i class="fas fa-shopping-cart" style="font-size: 1.5rem; color: #d4af37;"></i>
                        <span class="cart-count" style="position: absolute; top: -8px; right: -10px; background: #d4af37; color: #181828; border-radius: 50%; padding: 2px 7px; font-size: 0.9rem; font-weight: bold; min-width: 22px; text-align: center;">{{ session('carrito') ? count(session('carrito')) : 0 }}</span>
                    </a>
                @endif
                
                <!-- Login/Registro en menú y reservas -->
                @auth
                    <div class="user-dropdown" style="position: relative; display: inline-block; margin-left: 1rem;">
                        <button onclick="toggleUserMenu()" style="background: linear-gradient(135deg, #d4af37 0%, #ffed4e 100%); color: #000; border: none; padding: 0.5rem 1rem; border-radius: 8px; font-family: 'Playfair Display', serif; font-weight: 700; cursor: pointer;">
                            <i class="fas fa-user"></i> {{ auth()->user()->name }}
                            <i class="fas fa-chevron-down" style="margin-left: 5px; font-size: 0.8rem;"></i>
                        </button>
                        <div class="user-menu" id="userMenu" style="display: none; position: absolute; right: 0; top: 100%; background: #fff; border: 2px solid #d4af37; border-radius: 8px; min-width: 200px; z-index: 1000; box-shadow: 0 4px 20px rgba(0,0,0,0.1); margin-top: 5px;">
                            <a href="{{ route('profile') }}" style="display: block; padding: 12px 16px; color: #181828; text-decoration: none; border-bottom: 1px solid rgba(212, 175, 55, 0.2); transition: all 0.3s ease;">
                                <i class="fas fa-user-cog"></i> Mi Perfil
                            </a>
                            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                                @csrf
                                <button type="submit" style="width: 100%; text-align: left; background: none; border: none; padding: 12px 16px; color: #dc3545; cursor: pointer; transition: all 0.3s ease; font-size: 1rem;">
                                    <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                                </button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" style="background: #181828; color: #d4af37; text-decoration: none; font-family: 'Playfair Display', serif; font-weight: 700; font-size: 1rem; padding: 0.5rem 1rem; border-radius: 8px; margin-left: 1rem; transition: all 0.2s;">Entrar</a>
                    <a href="{{ route('register') }}" style="background: linear-gradient(135deg, #d4af37 0%, #ffed4e 100%); color: #000; text-decoration: none; font-family: 'Playfair Display', serif; font-weight: 700; font-size: 1rem; padding: 0.5rem 1rem; border-radius: 8px; margin-left: 0.5rem; transition: all 0.2s;">Registro</a>
                @endauth
            @endif
        </nav>
    </header>

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
        /* Header elegante como welcome */
        .header {
            position: sticky;
            top: 0;
            z-index: 1000;
        }
        
        .header-nav a:hover {
            background: #d4af37;
            color: #fff;
        }
        
        .cart-count {
            background: linear-gradient(135deg, #ff4757 0%, #ff3742 100%);
            color: white;
            font-size: 0.75rem;
            padding: 4px 8px;
            border-radius: 50%;
            min-width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            box-shadow: 0 2px 8px rgba(255, 71, 87, 0.4);
        }
        
        .user-menu a:hover,
        .user-menu button:hover {
            background: rgba(212, 175, 55, 0.1);
            color: #d4af37 !important;
        }
        
        .user-menu button[type="submit"]:hover {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545 !important;
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

        @media (max-width: 768px) {
            .header {
                flex-direction: column;
                gap: 1rem;
                padding: 1rem 0;
            }
            
            .header-nav {
                flex-wrap: wrap;
                justify-content: center;
                gap: 1rem;
                margin-right: 0;
            }
            
            .header-nav a {
                font-size: 1rem;
                padding: 0.5rem;
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
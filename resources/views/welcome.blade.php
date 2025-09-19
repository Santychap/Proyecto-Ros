<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Olla y Sazón - Bienvenidos</title>
    <link rel="stylesheet" href="{{ asset('css/home.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body class="particles-bg">
    <!-- Header -->
    <header class="home-header">
        <div class="nav-brand">
            <h2 style="color: #000000; font-family: var(--font-family-display); margin: 0;">
                <i class="fas fa-utensils"></i> Olla y Sazón
            </h2>
        </div>
        
        <nav class="home-nav">
            @auth
                @if(auth()->user()->rol !== 'empleado')
                    <a href="{{ url('/') }}" class="home-nav-link">
                        <i class="fas fa-home"></i> Inicio
                    </a>
                    <a href="{{ url('/menu') }}" class="home-nav-link">
                        <i class="fas fa-utensils"></i> Menú
                    </a>
                    <a href="{{ url('/reservas-web') }}" class="home-nav-link">
                        <i class="fas fa-calendar-alt"></i> Reservas
                    </a>
                    <a href="{{ url('/noticias-web') }}" class="home-nav-link">
                        <i class="fas fa-newspaper"></i> Noticias
                    </a>
                    <a href="{{ url('/promociones-web') }}" class="home-nav-link">
                        <i class="fas fa-tags"></i> Promociones
                    </a>
                @endif
                @if(auth()->user()->rol !== 'cliente')
                    <a href="{{ route('dashboard') }}" class="home-nav-link">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                @endif
                <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                    @csrf
                    <button type="submit" class="home-nav-link" style="background: none; border: none; cursor: pointer;">
                        <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="home-nav-link">
                    <i class="fas fa-sign-in-alt"></i> Iniciar Sesión
                </a>
                <a href="{{ route('register') }}" class="home-nav-link">
                    <i class="fas fa-user-plus"></i> Registrarse
                </a>
            @endauth
        </nav>
    </header>

    <!-- Contenido Principal -->
    <main class="circulos-principales">
        <!-- Círculo izquierdo -->
        <div class="circulo small" onclick="window.location.href='{{ url('/menu') }}'">
            <img src="{{ asset('storage/imagenes/menu-circle.jpg') }}" alt="Nuestro Menú" onerror="this.src='https://images.unsplash.com/photo-1546833999-b9f581a1996d?w=400&h=400&fit=crop'">
            <span>Nuestro<br>Exquisito<br>Menú</span>
        </div>

        <!-- Círculo central -->
        <div class="circulo central" onclick="window.location.href='{{ url('/reservas-web') }}'">
            <img src="{{ asset('storage/imagenes/restaurant-main.jpg') }}" alt="Restaurante Principal" onerror="this.src='https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?w=600&h=600&fit=crop'">
            <span>Bienvenidos<br>a<br>Olla y Sazón</span>
        </div>

        <!-- Círculo derecho -->
        <div class="circulo small" onclick="window.location.href='{{ url('/promociones-web') }}'">
            <img src="{{ asset('storage/imagenes/promociones-circle.jpg') }}" alt="Promociones Especiales" onerror="this.src='https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=400&h=400&fit=crop'">
            <span>Promociones<br>Especiales<br>Diarias</span>
        </div>
    </main>

    <!-- Scripts -->
    <script>
        // Efecto de parallax suave
        document.addEventListener('mousemove', (e) => {
            const circles = document.querySelectorAll('.circulo');
            const x = e.clientX / window.innerWidth;
            const y = e.clientY / window.innerHeight;
            
            circles.forEach((circle, index) => {
                const speed = (index + 1) * 0.5;
                const xPos = (x - 0.5) * speed;
                const yPos = (y - 0.5) * speed;
                
                circle.style.transform += ` translate(${xPos}px, ${yPos}px)`;
            });
        });

        // Animación de entrada
        document.addEventListener('DOMContentLoaded', () => {
            const circles = document.querySelectorAll('.circulo');
            circles.forEach((circle, index) => {
                circle.style.opacity = '0';
                circle.style.transform = 'scale(0.8) translateY(50px)';
                
                setTimeout(() => {
                    circle.style.transition = 'all 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275)';
                    circle.style.opacity = '1';
                    circle.style.transform = 'scale(1) translateY(0)';
                }, index * 200);
            });
        });
    </script>
</body>
</html>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Olla y Sazón - Restaurante</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/home-original.css') }}">
</head>
<body>
    <!-- Header superior -->
    <div class="top-header">
        <div class="left">
            <span>Anuncios</span>
        </div>
        <div class="center">
            <span>Buzón de reseñas</span>
        </div>
        <div class="right">
            <a href="{{ route('dashboard') }}" class="stats-btn">Ver Estadísticas</a>
        </div>
    </div>

    <!-- Contenedor principal -->
    <div class="main-container">
        <!-- Círculo izquierdo -->
        <div class="side-circle left-circle">
            <span>PLATO DEL DÍA</span>
        </div>

        <!-- Círculo central -->
        <div class="center-circle">
            <div>OLLA</div>
            <div>Y</div>
            <div>SAZÓN</div>
        </div>

        <!-- Círculo derecho -->
        <div class="side-circle right-circle">
            <span>PROMOCIÓN DEL DÍA</span>
        </div>
    </div>

    <!-- Secciones inferiores -->
    <div class="bottom-sections">
        <a href="{{ route('menu.index') }}" class="section menu-section">
            <span>Menú</span>
        </a>
        <a href="{{ route('reservas.publicIndex') }}" class="section reservas-section">
            <span>Reservas</span>
        </a>
        <a href="{{ route('noticias.publicIndex') }}" class="section noticias-section">
            <span>Noticias</span>
        </a>
    </div>

    <!-- Botón flotante del carrito -->
    <a href="{{ route('carrito.index') }}" style="position: fixed; bottom: 30px; right: 30px; background: #f1c40f; color: #2c3e50; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 1.5rem; text-decoration: none; box-shadow: 0 5px 15px rgba(0,0,0,0.3); z-index: 1000; transition: all 0.3s ease;">
        <i class="fas fa-shopping-cart"></i>
        @if(session()->has('carrito') && count(session('carrito')) > 0)
            <span style="position: absolute; top: -5px; right: -5px; background: #e74c3c; color: white; border-radius: 50%; width: 20px; height: 20px; font-size: 0.8rem; display: flex; align-items: center; justify-content: center;">{{ count(session('carrito')) }}</span>
        @endif
    </a>
</body>
</html>
<!DOCTYPE html>
<html>
<head>
    <title>Test Reservas</title>
    <style>
        body { font-family: Arial; padding: 20px; background: #f0f0f0; }
        .container { max-width: 800px; margin: 0 auto; background: white; padding: 30px; border-radius: 10px; }
        h1 { color: #333; text-align: center; }
        .nav { margin-bottom: 30px; text-align: center; }
        .nav a { margin: 0 15px; padding: 10px 20px; background: #ffd700; color: #000; text-decoration: none; border-radius: 5px; }
        .nav a:hover { background: #ffed4e; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🍽️ Test de Navegación</h1>
        
        <div class="nav">
            <a href="{{ url('/') }}">Inicio</a>
            <a href="{{ url('/menu') }}">Menú</a>
            <a href="{{ url('/reservas-web') }}">Reservas</a>
            <a href="{{ url('/noticias-web') }}">Noticias</a>
            <a href="{{ url('/promociones-web') }}">Promociones</a>
        </div>
        
        <h2>✅ Página de Test - Reservas</h2>
        <p>Si puedes ver esta página, significa que la ruta <strong>/reservas-web</strong> está funcionando correctamente.</p>
        
        <div style="background: #e8f5e8; padding: 15px; border-radius: 5px; margin: 20px 0;">
            <h3>🔗 Enlaces de prueba:</h3>
            <ul>
                <li><a href="{{ url('/') }}">Ir a Inicio</a></li>
                <li><a href="{{ url('/menu') }}">Ir a Menú</a></li>
                <li><a href="{{ url('/carrito') }}">Ir a Carrito</a></li>
            </ul>
        </div>
        
        <p><strong>URL actual:</strong> {{ request()->url() }}</p>
        <p><strong>Ruta actual:</strong> {{ request()->path() }}</p>
    </div>
</body>
</html>
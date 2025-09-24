<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prueba del Carrito</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }
        .btn {
            background: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin: 5px;
        }
        .btn:hover {
            background: #0056b3;
        }
        .btn-success {
            background: #28a745;
        }
        .btn-success:hover {
            background: #1e7e34;
        }
        .btn-warning {
            background: #ffc107;
            color: #212529;
        }
        .btn-warning:hover {
            background: #e0a800;
        }
    </style>
</head>
<body>
    <div class="card">
        <h1>🛒 Prueba del Carrito de Compras</h1>
        <p>Usa estos botones para probar la funcionalidad del carrito:</p>
        
        <h3>1. Agregar productos de prueba:</h3>
        <a href="{{ route('carrito.test') }}" class="btn btn-success">
            ➕ Llenar carrito con productos de prueba
        </a>
        
        <h3>2. Ver el carrito:</h3>
        <a href="{{ route('carrito.index') }}" class="btn">
            👁️ Ver carrito
        </a>
        
        <h3>3. Limpiar carrito:</h3>
        <form method="POST" action="{{ route('carrito.eliminar') }}" style="display: inline;">
            @csrf
            <input type="hidden" name="clear_all" value="true">
            <button type="submit" class="btn btn-warning" onclick="return confirm('¿Seguro que quieres limpiar el carrito?')">
                🗑️ Limpiar carrito
            </button>
        </form>
        
        <hr>
        
        <h3>Estado actual del carrito:</h3>
        @php
            $carrito = session()->get('carrito', []);
            $total = 0;
            foreach($carrito as $item) {
                $total += $item['precio'] * $item['cantidad'];
            }
        @endphp
        
        @if(count($carrito) > 0)
            <p><strong>Productos en el carrito: {{ count($carrito) }}</strong></p>
            <p><strong>Total: ${{ number_format($total, 2) }}</strong></p>
            <ul>
                @foreach($carrito as $id => $item)
                    <li>{{ $item['nombre'] }} - Cantidad: {{ $item['cantidad'] }} - Precio: ${{ number_format($item['precio'] * $item['cantidad'], 2) }}</li>
                @endforeach
            </ul>
        @else
            <p><em>El carrito está vacío</em></p>
        @endif
        
        @if(session('success'))
            <div style="background: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-top: 10px;">
                ✅ {{ session('success') }}
            </div>
        @endif
    </div>
</body>
</html>
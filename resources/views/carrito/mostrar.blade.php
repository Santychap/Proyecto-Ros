@extends('layouts.menu')

@section('content')
<div class="container carrito-wrapper">
    <h1>Carrito de Compras</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(count($carrito) > 0)
        <div class="carrito tabla-contenedor">
            <table class="table carrito-tabla">
                <thead>
                    <tr>
                        <th>Producto</th>
                        <th>Precio Unitario</th>
                        <th>Cantidad</th>
                        <th>Subtotal</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @php $total = 0; @endphp
                    @foreach($carrito as $id => $item)
                        @php $subtotal = $item['precio'] * $item['cantidad']; @endphp
                        <tr class="carrito-fila">
                            <td class="carrito-producto">{{ $item['nombre'] }}</td>
                            <td class="carrito-precio">${{ number_format($item['precio'], 2) }}</td>
                            <td class="carrito-cantidad">
                                <div class="cantidad-controls" style="display: flex; align-items: center; gap: 10px;">
                                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="cambiarCantidad({{ $id }}, -1)" style="width: 30px; height: 30px; padding: 0; display: flex; align-items: center; justify-content: center;">-</button>
                                    <span class="cantidad-display" id="cantidad-{{ $id }}" style="min-width: 30px; text-align: center; font-weight: bold;">{{ $item['cantidad'] }}</span>
                                    <button type="button" class="btn btn-sm btn-outline-secondary" onclick="cambiarCantidad({{ $id }}, 1)" style="width: 30px; height: 30px; padding: 0; display: flex; align-items: center; justify-content: center;">+</button>
                                </div>
                            </td>
                            <td class="carrito-subtotal">${{ number_format($subtotal, 2) }}</td>
                            <td class="carrito-acciones">
                                <form action="{{ route('carrito.eliminar') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $id }}">
                                    <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('¿Eliminar este producto del carrito?')">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @php $total += $subtotal; @endphp
                    @endforeach
                    <tr class="carrito-total">
                        <td colspan="3"><strong>Total</strong></td>
                        <td colspan="2"><strong>${{ number_format($total, 2) }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="carrito-confirmacion mt-3">
            <form method="POST" action="{{ route('pedidos.store') }}">
                @csrf
                <div class="mb-3">
                    <label for="comentario" class="form-label">Comentario (opcional):</label>
                    <textarea name="comentario" id="comentario" class="form-control"></textarea>
                </div>
                <button type="submit" class="btn btn-success">
                    Confirmar Pedido
                </button>
            </form>
        </div>
    @else
        <p>No hay productos en el carrito.</p>
        <a href="{{ route('menu.index') }}" class="btn btn-primary">Volver al menú</a>
    @endif
</div>
@endsection

@push('styles')
<style>
.carrito-wrapper {
    max-width: 1200px;
    margin: 0 auto;
    padding: 20px;
}

.carrito-wrapper h1 {
    color: #d4af37;
    text-align: center;
    margin-bottom: 30px;
    font-family: 'Playfair Display', serif;
    font-weight: 700;
}

.carrito-tabla {
    background: #000000;
    border: 3px solid #ffd700;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 0 20px rgba(255, 215, 0, 0.3);
}

.carrito-tabla th {
    background: linear-gradient(135deg, #d4af37 0%, #ffed4e 100%);
    color: #000;
    font-weight: bold;
    padding: 15px;
    text-align: center;
    border: none;
}

.carrito-tabla td {
    background: #000000;
    color: #ffffff;
    padding: 15px;
    text-align: center;
    border: none;
    border-bottom: 1px solid rgba(255, 215, 0, 0.2);
}

.carrito-total td {
    background: rgba(212, 175, 55, 0.1);
    color: #ffd700;
    font-size: 1.2rem;
    font-weight: bold;
    border-bottom: none;
}

.cantidad-controls button {
    background: #d4af37;
    color: #000;
    border: 1px solid #d4af37;
    font-weight: bold;
}

.cantidad-controls button:hover {
    background: #ffed4e;
    border-color: #ffed4e;
}

.btn-danger {
    background: #dc3545;
    border-color: #dc3545;
}

.btn-success {
    background: linear-gradient(135deg, #d4af37 0%, #ffed4e 100%);
    color: #000;
    border: none;
    padding: 12px 30px;
    font-weight: bold;
    border-radius: 25px;
    margin-top: 20px;
}

.btn-success:hover {
    background: linear-gradient(135deg, #ffed4e 0%, #d4af37 100%);
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(255, 215, 0, 0.4);
}

.form-control {
    background: rgba(255, 255, 255, 0.9);
    border: 2px solid #d4af37;
    color: #333;
}

.form-control:focus {
    background: rgba(255, 255, 255, 1);
    border-color: #ffd700;
    box-shadow: 0 0 10px rgba(255, 215, 0, 0.5);
}

.alert {
    border-radius: 10px;
    margin-bottom: 20px;
}
</style>
@endpush

@push('scripts')
<script>
function cambiarCantidad(id, cambio) {
    const cantidadElement = document.getElementById('cantidad-' + id);
    let cantidadActual = parseInt(cantidadElement.textContent);
    let nuevaCantidad = cantidadActual + cambio;
    
    if (nuevaCantidad < 1) {
        if (confirm('¿Deseas eliminar este producto del carrito?')) {
            eliminarProducto(id);
        }
        return;
    }
    
    // Actualizar visualmente
    cantidadElement.textContent = nuevaCantidad;
    
    // Enviar actualización al servidor
    fetch('{{ route('carrito.actualizar') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            id: id,
            cantidad: nuevaCantidad
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Actualizar subtotal y total
            location.reload();
        } else {
            alert('Error al actualizar el carrito');
            cantidadElement.textContent = cantidadActual; // Revertir cambio
        }
    })
    .catch(error => {
        console.error('Error:', error);
        cantidadElement.textContent = cantidadActual; // Revertir cambio
    });
}

function eliminarProducto(id) {
    fetch('{{ route('carrito.eliminar') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            id: id
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error al eliminar el producto');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al eliminar el producto');
    });
}
</script>
@endpush

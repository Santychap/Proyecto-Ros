@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Carrito de Compras</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(count($carrito) > 0)
        <form method="POST" action="{{ route('pedidos.store') }}">
            @csrf
            <table class="table">
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
                        <tr>
                            <td>{{ $item['nombre'] }}</td>
                            <td>${{ number_format($item['precio'], 2) }}</td>
                            <td>
                                <form action="{{ route('carrito.actualizar') }}" method="POST" class="d-inline-flex">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $id }}">
                                    <input type="number" name="cantidad" value="{{ $item['cantidad'] }}" min="1" class="form-control" style="width:70px;">
                                    <button type="submit" class="btn btn-sm btn-primary ms-2">Actualizar</button>
                                </form>
                            </td>
                            <td>${{ number_format($subtotal, 2) }}</td>
                            <td>
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
                    <tr>
                        <td colspan="3"><strong>Total</strong></td>
                        <td colspan="2"><strong>${{ number_format($total, 2) }}</strong></td>
                    </tr>
                </tbody>
            </table>

            <div class="mb-3">
                <label for="comentario" class="form-label">Comentario (opcional):</label>
                <textarea name="comentario" id="comentario" class="form-control"></textarea>
            </div>

            <button type="submit" class="btn btn-success">
                Confirmar Pedido
            </button>
        </form>
    @else
        <p>No hay productos en el carrito.</p>
        <a href="{{ route('menu.index') }}" class="btn btn-primary">Volver al menú</a>
    @endif
</div>
@endsection

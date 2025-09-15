@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Historial de Pedidos</h1>

    @if($pedidos->isEmpty())
        <p>No tienes pedidos registrados.</p>
    @else
        @foreach($pedidos as $pedido)
            <div class="card mb-3">
                <div class="card-header">
                    Pedido #{{ $pedido->id }} - Estado: {{ $pedido->estado }} - Empleado: {{ $pedido->empleado ? $pedido->empleado->name : 'Sin asignar' }}
                    <br>
                    Fecha: {{ $pedido->created_at->format('d/m/Y H:i') }}
                </div>
                <div class="card-body">
                    <p><strong>Comentario:</strong> {{ $pedido->comentario ?? 'Ninguno' }}</p>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($pedido->detalles as $detalle)
                                <tr>
                                    <td>{{ $detalle->producto->nombre }}</td>
                                    <td>{{ $detalle->cantidad }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endforeach
    @endif
</div>
@endsection

@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">
        {{ Auth::user()->rol === 'cliente' ? 'Mis Pedidos' : 'Historial de Pedidos' }}
    </h1>

    @if($pedidos->isEmpty())
        <p>No tienes pedidos registrados.</p>
    @else
        @foreach($pedidos as $pedido)
            <div class="card mb-3">
                <div class="card-header">
                    <strong>Pedido #{{ $pedido->id }}</strong> <br>
                    <span><strong>Estado:</strong> {{ $pedido->estado }}</span><br>

                    @if(Auth::user()->rol !== 'cliente')
                        <span><strong>Cliente:</strong> {{ $pedido->user->name }} ({{ $pedido->user->email }})</span><br>
                        <span><strong>Empleado:</strong> {{ $pedido->empleado ? $pedido->empleado->name : 'Sin asignar' }}</span><br>
                    @else
                        <span><strong>Empleado asignado:</strong> {{ $pedido->empleado ? $pedido->empleado->name : 'Aún no asignado' }}</span><br>
                    @endif

                    <span><strong>Fecha:</strong> {{ $pedido->created_at->format('d/m/Y H:i') }}</span>
                </div>

                <div class="card-body">
                    <p><strong>Comentario:</strong> {{ $pedido->comentario ?? 'Ninguno' }}</p>

                    <h6>Detalle del pedido:</h6>
                    <table class="table table-bordered">
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

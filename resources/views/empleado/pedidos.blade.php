@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Mis Pedidos</h2>
    @forelse($pedidos as $pedido)
        <div class="card mb-3">
            <div class="card-header">
                Pedido #{{ $pedido->id }} | Estado: {{ $pedido->estado }}
            </div>
            <div class="card-body">
                <ul>
                    @foreach($pedido->detalles as $detalle)
                        <li>{{ $detalle->producto->nombre }} x {{ $detalle->cantidad }}</li>
                    @endforeach
                </ul>
                <p><strong>Comentario:</strong> {{ $pedido->comentario ?? 'Ninguno' }}</p>
            </div>
        </div>
    @empty
        <p>No tienes pedidos aún.</p>
    @endforelse
</div>
@endsection

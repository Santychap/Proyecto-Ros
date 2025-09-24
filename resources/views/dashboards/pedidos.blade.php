// No changes needed. This is not an admin view.
// This file will remain unchanged.
// Marking this step as complete.
@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Todos los Pedidos</h2>
    @foreach($pedidos as $pedido)
        <div class="card mb-3">
            <div class="card-header">
                Pedido #{{ $pedido->id }} | Cliente: {{ $pedido->user->name }} | Estado: {{ $pedido->estado }}
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
    @endforeach
</div>
@endsection

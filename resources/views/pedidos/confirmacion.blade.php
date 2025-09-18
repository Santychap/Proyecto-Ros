@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mt-10 p-6 bg-white rounded shadow">

    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <h1 class="text-2xl font-semibold mb-4">¡Gracias por tu pedido!</h1>
    <p>Tu pedido ha sido confirmado correctamente.</p>

    <h2 class="mt-6 text-xl font-semibold">Detalle del pedido #{{ $pedido->id }}</h2>

    <ul class="mb-4">
        @foreach($pedido->detalles as $detalle)
            <li class="border-b py-2 flex justify-between">
                <span>{{ $detalle->producto->nombre }} x {{ $detalle->cantidad }}</span>
                <span>${{ number_format($detalle->producto->precio * $detalle->cantidad, 2) }}</span>
            </li>
        @endforeach
    </ul>

    <p class="font-bold mb-4">Total: ${{ number_format($total, 2) }}</p>

    <p>Estado del pedido: <strong>{{ ucfirst($pedido->estado) }}</strong></p>

    @if (strtolower($pedido->estado) === 'pendiente')
        {{-- Cancelar pedido --}}
        @if($puedeCancelar)
            <form action="{{ route('pedidos.cancelar', $pedido) }}" method="POST" class="inline-block mr-2">
                @csrf
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    Cancelar Pedido
                </button>
            </form>
        @else
            <p class="text-gray-500 italic mb-4">El tiempo para cancelar el pedido ha expirado.</p>
        @endif

        {{-- Botón de pago funcional --}}
        <a href="{{ route('pagos.create', ['pedido' => $pedido->id]) }}"
           class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded inline-block">
            Pagar Pedido
        </a>
    @else
        <p class="mt-4 text-gray-600">No se pueden realizar acciones sobre este pedido.</p>
    @endif

    <a href="{{ route('menu.index') }}" class="mt-6 inline-block text-blue-600 hover:underline">
        Volver al menú
    </a>
</div>
@endsection

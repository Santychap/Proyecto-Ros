<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Pago #{{ $pago->id }}</h2>
    </x-slot>

    <div class="py-6 max-w-xl mx-auto bg-white p-6 rounded shadow">
        <p><strong>Pedido:</strong> #{{ $pago->pedido_id }}</p>
        <p><strong>Monto:</strong> ${{ $pago->monto }}</p>
        <p><strong>Método:</strong> {{ ucfirst($pago->metodo) }}</p>
        <p><strong>Fecha:</strong> {{ $pago->fecha_pago->format('d/m/Y H:i') }}</p>
        <p><strong>Detalles:</strong> {{ $pago->datos_pago }}</p>
    </div>
</x-app-layout>

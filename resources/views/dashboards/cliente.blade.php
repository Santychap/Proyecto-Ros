<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Dashboard Cliente</h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">¡Hola {{ auth()->user()->name }}!</h3>
            <p class="text-gray-600">Aquí puedes revisar tus reservas, pedidos y promociones activas.</p>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="{{ route('reservas.index') }}" class="bg-green-600 text-white rounded p-4 text-center hover:bg-green-700">
                    Mis Reservas
                </a>
                <a href="{{ route('pedidos.historial') }}" class="bg-yellow-500 text-white rounded p-4 text-center hover:bg-yellow-600">
                    Historial de Pedidos
                </a>
            </div>
        </div>
    </div>
</x-app-layout>

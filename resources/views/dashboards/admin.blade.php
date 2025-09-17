<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Dashboard Administrador</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">

        <!-- Cuadros resumen -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-4 text-center">
                <h3 class="text-gray-600">Reservas Hoy</h3>
                <p class="text-3xl font-bold">{{ $totalReservasHoy }}</p>
            </div>

            <div class="bg-white rounded-lg shadow p-4 text-center">
                <h3 class="text-gray-600">Pedidos Hoy</h3>
                <p class="text-3xl font-bold">{{ $totalPedidosHoy }}</p>
            </div>

            <div class="bg-white rounded-lg shadow p-4 text-center">
                <h3 class="text-gray-600">Clientes Registrados</h3>
                <p class="text-3xl font-bold">{{ $totalClientes }}</p>
            </div>

            <div class="bg-white rounded-lg shadow p-4 text-center">
                <h3 class="text-gray-600">Mesas Disponibles</h3>
                <p class="text-3xl font-bold">{{ $mesasDisponibles }}</p>
            </div>
        </div>

        <!-- Gráfica de reservas -->
        <div class="bg-white rounded-lg shadow p-6 mb-8">
            <h3 class="text-gray-700 font-semibold mb-4">Reservas últimos 7 días</h3>
            <canvas id="reservasChart" height="100"></canvas>
        </div>

        <!-- Accesos rápidos -->
        <div class="bg-white rounded-lg shadow p-6 grid grid-cols-2 md:grid-cols-4 gap-6">
            <a href="{{ route('reservas.index') }}" class="bg-blue-600 text-white rounded p-4 text-center hover:bg-blue-700">
                Reservas
            </a>
            <a href="{{ route('users.index') }}" class="bg-green-600 text-white rounded p-4 text-center hover:bg-green-700">
                Usuarios
            </a>
            <a href="{{ route('mesas.index') }}" class="bg-yellow-500 text-white rounded p-4 text-center hover:bg-yellow-600">
                Mesas
            </a>
            <a href="{{ route('productos.index') }}" class="bg-purple-600 text-white rounded p-4 text-center hover:bg-purple-700">
                Productos
            </a>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('reservasChart').getContext('2d');
            const reservasChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($labels),
                    datasets: [{
                        label: 'Reservas',
                        data: @json($data),
                        borderColor: 'rgb(59, 130, 246)',
                        backgroundColor: 'rgba(59, 130, 246, 0.3)',
                        fill: true,
                        tension: 0.3,
                        pointRadius: 5,
                        pointHoverRadius: 7,
                    }]
                },
                options: {
                    scales: {
                        x: { display: true },
                        y: { beginAtZero: true, stepSize: 1 }
                    }
                }
            });
        </script>
    @endpush
</x-app-layout>

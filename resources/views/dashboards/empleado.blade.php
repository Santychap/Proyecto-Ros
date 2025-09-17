<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Dashboard Empleado</h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Bienvenido, {{ auth()->user()->name }}</h3>
            <p class="text-gray-600">Aquí puedes gestionar tus pedidos, ver tu horario y más funciones del día a día.</p>

            <div class="mt-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                <a href="{{ route('pedidos.index') }}" class="bg-blue-600 text-white rounded p-4 text-center hover:bg-blue-700">
                    Pedidos
                </a>
                <a href="{{ route('horarios.index') }}" class="bg-indigo-600 text-white rounded p-4 text-center hover:bg-indigo-700">
                    Horarios
                </a>
            </div>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Horario Semanal</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Mensaje de éxito --}}
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-200 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Solo para administrador --}}
            @if(auth()->user()->rol === 'admin')

                {{-- Botón crear horario --}}
                <a href="{{ route('horarios.create') }}" class="mb-4 inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Crear nuevo horario
                </a>

                {{-- Barra de búsqueda --}}
                <form action="{{ route('horarios.index') }}" method="GET" class="mb-4 flex">
                    <input
                        type="text"
                        name="busqueda"
                        placeholder="Buscar por empleado o día..."
                        value="{{ request('busqueda') }}"
                        class="border border-gray-300 rounded-l px-4 py-2 w-full"
                    >
                    <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-r hover:bg-blue-700">
                        Buscar
                    </button>
                </form>
            @endif

            {{-- Tabla de horarios --}}
            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">ID</th>
                        @if(auth()->user()->rol === 'admin')
                            <th class="py-2 px-4 border-b">Empleado</th>
                        @endif
                        <th class="py-2 px-4 border-b">Día</th>
                        <th class="py-2 px-4 border-b">Hora Entrada</th>
                        <th class="py-2 px-4 border-b">Hora Salida</th>
                        @if(auth()->user()->rol === 'admin')
                            <th class="py-2 px-4 border-b">Acciones</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse($horarios as $horario)
                        <tr>
                            <td class="border-b py-2 px-4">{{ $horario->id }}</td>
                            @if(auth()->user()->rol === 'admin')
                                <td class="border-b py-2 px-4">{{ $horario->user->name }} ({{ $horario->user->email }})</td>
                            @endif
                            <td class="border-b py-2 px-4">{{ ucfirst($horario->dia) }}</td>
                            <td class="border-b py-2 px-4">{{ $horario->hora_entrada }}</td>
                            <td class="border-b py-2 px-4">{{ $horario->hora_salida }}</td>
                            @if(auth()->user()->rol === 'admin')
                                <td class="border-b py-2 px-4">
                                    <a href="{{ route('horarios.edit', $horario) }}" class="text-blue-600 hover:underline">Editar</a>
                                    <form action="{{ route('horarios.destroy', $horario) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Eliminar horario?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline ml-2">Eliminar</button>
                                    </form>
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()->rol === 'admin' ? 6 : 4 }}" class="py-4 text-center text-gray-500">
                                No hay horarios para mostrar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Horarios</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-200 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Botón para crear nuevo horario (solo admin) --}}
            @if(auth()->user()->rol === 'admin')
                <a href="{{ route('horarios.create') }}" class="mb-4 inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Crear nuevo horario
                </a>
            @endif

            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr>
                        <th class="py-2 px-4 border-b">Empleado</th>
                        <th class="py-2 px-4 border-b">Día</th>
                        <th class="py-2 px-4 border-b">Hora Entrada</th>
                        <th class="py-2 px-4 border-b">Hora Salida</th>
                        {{-- Encabezado Acciones solo para admin --}}
                        @if(auth()->user()->rol === 'admin')
                            <th class="py-2 px-4 border-b">Acciones</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($horarios as $horario)
                        <tr>
                            <td class="border-b py-2 px-4">{{ $horario->user->name }}</td>
                            <td class="border-b py-2 px-4">{{ ucfirst($horario->dia) }}</td>
                            <td class="border-b py-2 px-4">{{ $horario->hora_entrada }}</td>
                            <td class="border-b py-2 px-4">{{ $horario->hora_salida }}</td>
                            {{-- Acciones por cada fila, solo para admin --}}
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
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>

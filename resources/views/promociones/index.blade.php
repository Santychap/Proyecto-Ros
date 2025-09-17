<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Promociones</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-200 text-green-800 rounded">{{ session('success') }}</div>
        @endif

        <a href="{{ route('promociones.create') }}" class="mb-4 inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Crear Promoción
        </a>

        <table class="min-w-full bg-white border border-gray-300">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">Título</th>
                    <th class="py-2 px-4 border-b">Descuento (%)</th>
                    <th class="py-2 px-4 border-b">Fecha Inicio</th>
                    <th class="py-2 px-4 border-b">Fecha Fin</th>
                    <th class="py-2 px-4 border-b">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($promociones as $promocion)
                    <tr>
                        <td class="border-b py-2 px-4">{{ $promocion->titulo }}</td>
                        <td class="border-b py-2 px-4">{{ $promocion->descuento ?? '-' }}</td>
                        <td class="border-b py-2 px-4">{{ $promocion->fecha_inicio->format('d/m/Y') }}</td>
                        <td class="border-b py-2 px-4">{{ $promocion->fecha_fin->format('d/m/Y') }}</td>
                        <td class="border-b py-2 px-4 space-x-2">
                            <a href="{{ route('promociones.edit', $promocion) }}" class="text-blue-600 hover:underline">Editar</a>
                            <form action="{{ route('promociones.destroy', $promocion) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Eliminar promoción?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="py-4 text-center text-gray-500">No hay promociones para mostrar.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $promociones->links() }}
        </div>
    </div>
</x-app-layout>

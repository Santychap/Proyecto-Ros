<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Noticias</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-200 text-green-800 rounded">{{ session('success') }}</div>
        @endif

        <a href="{{ route('noticias.create') }}" class="mb-4 inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Crear Noticia
        </a>

        <table class="min-w-full bg-white border border-gray-300">
            <thead>
                <tr>
                    <th class="py-2 px-4 border-b">Título</th>
                    <th class="py-2 px-4 border-b">Contenido</th>
                    <th class="py-2 px-4 border-b">Fecha de creación</th>
                    <th class="py-2 px-4 border-b">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($noticias as $noticia)
                    <tr>
                        <td class="border-b py-2 px-4">{{ $noticia->titulo }}</td>
                        <td class="border-b py-2 px-4">{{ Str::limit($noticia->contenido, 50) }}</td>
                        <td class="border-b py-2 px-4">{{ $noticia->created_at->format('d/m/Y') }}</td>
                        <td class="border-b py-2 px-4 space-x-2">
                            <a href="{{ route('noticias.edit', $noticia) }}" class="text-blue-600 hover:underline">Editar</a>
                            <form action="{{ route('noticias.destroy', $noticia) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Eliminar noticia?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline">Eliminar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="py-4 text-center text-gray-500">No hay noticias para mostrar.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $noticias->links() }}
        </div>
    </div>
</x-app-layout>

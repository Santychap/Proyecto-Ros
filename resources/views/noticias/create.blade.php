<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Crear Noticia</h2>
    </x-slot>

    <div class="py-6 max-w-lg mx-auto sm:px-6 lg:px-8">

        <form action="{{ route('noticias.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="titulo" class="block font-medium text-gray-700">Título</label>
                <input type="text" name="titulo" id="titulo" value="{{ old('titulo') }}" class="mt-1 block w-full border border-gray-300 rounded p-2" required>
                @error('titulo') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="contenido" class="block font-medium text-gray-700">Contenido</label>
                <textarea name="contenido" id="contenido" rows="5" class="mt-1 block w-full border border-gray-300 rounded p-2" required>{{ old('contenido') }}</textarea>
                @error('contenido') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex space-x-2">
                <a href="{{ route('noticias.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancelar</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Guardar</button>
            </div>
        </form>

    </div>
</x-app-layout>

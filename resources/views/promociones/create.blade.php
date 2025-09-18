<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Crear Nueva Promoción</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto bg-white p-6 shadow rounded">
            <form action="{{ route('promociones.store') }}" method="POST">
                @csrf

                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Título</label>
                    <input type="text" name="titulo" value="{{ old('titulo') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    @error('titulo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Descripción</label>
                    <textarea name="descripcion" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('descripcion') }}</textarea>
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Descuento (%)</label>
                    <input type="number" name="descuento" value="{{ old('descuento') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required min="0" max="100" step="0.01">
                    @error('descuento') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Fecha de Inicio</label>
                    <input type="date" name="fecha_inicio" value="{{ old('fecha_inicio') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                    @error('fecha_inicio') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Fecha de Fin</label>
                    <input type="date" name="fecha_fin" value="{{ old('fecha_fin') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                    @error('fecha_fin') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end space-x-4">
                    <a href="{{ route('promociones.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded">Cancelar</a>
                    <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Crear Promoción</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

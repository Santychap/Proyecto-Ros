<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Editar Reserva</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 bg-white p-6 shadow rounded">
            <form action="{{ route('reservas.update', $reserva) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Fecha</label>
                    <input type="date" name="fecha" value="{{ old('fecha', $reserva->fecha) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Hora</label>
                    <input type="time" name="hora" value="{{ old('hora', $reserva->hora) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Personas</label>
                    <input type="number" name="personas" value="{{ old('personas', $reserva->personas) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Mesas</label>
                    <input type="number" name="mesas" value="{{ old('mesas', $reserva->mesas) }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Motivo</label>
                    <select name="motivo" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        <option value="">Selecciona un motivo</option>
                        <option value="Cumpleaños" {{ $reserva->motivo == 'Cumpleaños' ? 'selected' : '' }}>Cumpleaños</option>
                        <option value="Aniversario" {{ $reserva->motivo == 'Aniversario' ? 'selected' : '' }}>Aniversario</option>
                        <option value="Cena de negocios" {{ $reserva->motivo == 'Cena de negocios' ? 'selected' : '' }}>Cena de negocios</option>
                        <option value="Otro" {{ $reserva->motivo == 'Otro' ? 'selected' : '' }}>Otro</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Nota</label>
                    <textarea name="nota" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('nota', $reserva->nota) }}</textarea>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Actualizar Reserva</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>


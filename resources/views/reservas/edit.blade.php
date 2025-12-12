<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Reserva</h2>
    </x-slot>

    <div class="py-6 max-w-3xl mx-auto sm:px-6 lg:px-8 bg-white p-6 shadow rounded">
        <form action="{{ route('reservas.update', $reserva) }}" method="POST">
            @csrf
            @method('PUT')

            @if(Auth::user()->rol === 'admin')
                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Cliente</label>
                    <input type="text" value="{{ $reserva->user->name }} ({{ $reserva->user->email }})" disabled
                        class="form-input w-full bg-gray-100 cursor-not-allowed">
                </div>
            @endif

            <div class="mb-4">
                <label class="block font-medium text-sm text-gray-700">Fecha</label>
                <input type="date" name="fecha" value="{{ old('fecha', $reserva->fecha) }}" class="form-input w-full" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium text-sm text-gray-700">Hora</label>
                <input type="time" name="hora" value="{{ old('hora', $reserva->hora) }}" class="form-input w-full" required>
            </div>

            <div class="mb-4">
                <label class="block font-medium text-sm text-gray-700">Cantidad de Personas</label>
                <input type="number" name="personas" min="1" value="{{ old('personas', $reserva->personas) }}" class="form-input w-full" required>
            </div>

            @if(Auth::user()->rol === 'admin')
                <div class="mb-4">
                    <label class="block font-medium text-sm text-gray-700">Mesa asignada</label>
                    <select name="mesas" class="form-select w-full">
                        <option value="">-- Seleccionar mesa --</option>
                        @foreach($mesas as $mesa)
                            <option value="{{ $mesa->id }}" {{ $reserva->mesa_id == $mesa->id ? 'selected' : '' }}>
                                Mesa {{ $mesa->codigo ?? $mesa->id }} (Capacidad: {{ $mesa->capacidad }})
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            <div class="mb-4">
                <label class="block font-medium text-sm text-gray-700">Motivo</label>
                <select name="motivo" class="form-select w-full">
                    <option value="">Selecciona una opción</option>
                    @foreach(['Cumpleaños', 'Aniversario', 'Cena de negocios', 'Otro'] as $motivo)
                        <option value="{{ $motivo }}" {{ old('motivo', $reserva->motivo) === $motivo ? 'selected' : '' }}>
                            {{ $motivo }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block font-medium text-sm text-gray-700">Nota</label>
                <textarea name="nota" rows="4" class="form-textarea w-full">{{ old('nota', $reserva->nota) }}</textarea>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Actualizar Reserva</button>
            </div>
        </form>
    </div>
</x-app-layout>

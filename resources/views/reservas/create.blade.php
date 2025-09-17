<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Crear Reserva</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            @if(in_array(Auth::user()->rol, ['admin', 'cliente']))
                <form action="{{ route('reservas.store') }}" method="POST" class="bg-white p-6 rounded shadow">
                    @csrf

                    {{-- Mostrar campo de selección de cliente solo para el admin --}}
                    @if(Auth::user()->rol === 'admin')
                        <div class="mb-4">
                            <label class="block font-medium text-sm text-gray-700">Seleccionar Cliente</label>
                            <select name="user_id" id="user_id" class="form-select w-full">
                                <option value="">-- Selecciona un cliente --</option>
                                @foreach ($clientes as $cliente)
                                    <option value="{{ $cliente->id }}">
                                        {{ $cliente->name }} ({{ $cliente->email }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Selección manual de mesa solo para admin --}}
                        <div class="mb-4">
                            <label class="block font-medium text-sm text-gray-700">Seleccionar Mesa</label>
                            <select name="mesa_id" class="form-select w-full">
                                <option value="">-- Selecciona una mesa --</option>
                                @foreach ($mesas as $mesa)
                                    <option value="{{ $mesa->id }}">
                                        Mesa {{ $mesa->codigo }} (Capacidad: {{ $mesa->capacidad }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Fecha</label>
                        <input type="date" name="fecha" class="form-input w-full" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Hora</label>
                        <input type="time" name="hora" class="form-input w-full" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Cantidad de Personas</label>
                        <input type="number" name="personas" class="form-input w-full" min="1" required>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Motivo de la reserva</label>
                        <select name="motivo" class="form-select w-full">
                            <option value="">Selecciona una opción</option>
                            <option value="Cumpleaños">Cumpleaños</option>
                            <option value="Aniversario">Aniversario</option>
                            <option value="Cena de negocios">Cena de negocios</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label class="block font-medium text-sm text-gray-700">Nota (opcional)</label>
                        <textarea name="nota" class="form-textarea w-full" rows="4" placeholder="Ej: mesa cerca de la ventana, decoración especial, etc."></textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Guardar Reserva</button>
                    </div>
                </form>
            @else
                <div class="bg-yellow-100 text-yellow-800 p-4 rounded">
                    No tienes permisos para crear reservas.
                </div>
            @endif
        </div>
    </div>

    {{-- Script para mejor experiencia al buscar cliente --}}
    @if(Auth::user()->rol === 'admin')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            new TomSelect("#user_id", {
                create: false,
                sortField: {
                    field: "text",
                    direction: "asc"
                },
                placeholder: "Buscar cliente por nombre o correo...",
            });
        });
    </script>
    @endif
</x-app-layout>

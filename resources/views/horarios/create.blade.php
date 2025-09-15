<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Crear Horario</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8 bg-white p-6 rounded shadow">

            @if ($errors->any())
                <div class="mb-4">
                    <ul class="list-disc list-inside text-red-600">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('horarios.store') }}">
                @csrf

                <div class="mb-4">
                    <label for="user_id" class="block font-medium text-sm text-gray-700">Empleado</label>
                    <select name="user_id" id="user_id" class="border-gray-300 rounded w-full">
                        <option value="">Selecciona un empleado</option>
                        @foreach($empleados as $empleado)
                            <option value="{{ $empleado->id }}" {{ old('user_id') == $empleado->id ? 'selected' : '' }}>
                                {{ $empleado->name }} ({{ $empleado->email }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-4">
                    <label for="dia" class="block font-medium text-sm text-gray-700">Día</label>
                    <input type="text" name="dia" id="dia" value="{{ old('dia') }}" class="border-gray-300 rounded w-full" placeholder="Ejemplo: lunes, martes...">
                </div>

                <div class="mb-4">
                    <label for="hora_entrada" class="block font-medium text-sm text-gray-700">Hora Entrada</label>
                    <input type="time" name="hora_entrada" id="hora_entrada" value="{{ old('hora_entrada') }}" class="border-gray-300 rounded w-full">
                </div>

                <div class="mb-4">
                    <label for="hora_salida" class="block font-medium text-sm text-gray-700">Hora Salida</label>
                    <input type="time" name="hora_salida" id="hora_salida" value="{{ old('hora_salida') }}" class="border-gray-300 rounded w-full">
                </div>

                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Guardar horario
                </button>
            </form>
        </div>
    </div>
</x-app-layout>

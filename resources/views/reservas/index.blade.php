<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">
            {{ Auth::user()->rol === 'admin' ? 'Reservas del Sistema' : 'Mis Reservas' }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Mensaje de éxito --}}
            @if(session('success'))
                <div class="mb-4 px-4 py-2 bg-green-200 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Botón para crear nueva reserva SOLO para admin y cliente --}}
            @if(in_array(Auth::user()->rol, ['admin', 'cliente']))
                <a href="{{ route('reservas.create') }}" class="mb-4 inline-block px-4 py-2 bg-green-600 text-white rounded">+ Nueva Reserva</a>
            @endif

            {{-- Listado de reservas --}}
            @forelse ($reservas as $reserva)
                <div class="bg-white p-4 mb-4 rounded shadow">
                    @if(Auth::user()->rol === 'admin')
                        <p><strong>Usuario:</strong> {{ $reserva->user->name }}</p>
                        <p><strong>Email:</strong> {{ $reserva->user->email }}</p>
                    @endif

                    <p><strong>Fecha:</strong> {{ $reserva->fecha }}</p>
                    <p><strong>Hora:</strong> {{ $reserva->hora }}</p>
                    <p><strong>Personas:</strong> {{ $reserva->personas }}</p>

                    {{-- Mostrar información de la mesa asignada --}}
                    <p>
                        <strong>Mesa:</strong>
                        @if ($reserva->mesa)
                            {{ $reserva->mesa->codigo ?? 'Mesa ' . $reserva->mesa->id }} (Capacidad: {{ $reserva->mesa->capacidad }})
                        @else
                            No asignada
                        @endif
                    </p>

                    <p><strong>Motivo:</strong> {{ $reserva->motivo ?? 'No especificado' }}</p>
                    <p><strong>Nota:</strong> {{ $reserva->nota ?? 'Ninguna' }}</p>
                    <p><strong>Estado:</strong> {{ $reserva->estado }}</p>

                    <div class="mt-3 flex space-x-2">
                        {{-- Botón editar --}}
                        @can('update', $reserva)
                            <a href="{{ route('reservas.edit', $reserva) }}" class="px-3 py-1 bg-yellow-500 text-white rounded">Editar</a>
                        @endcan

                        {{-- Botón eliminar --}}
                        @can('delete', $reserva)
                            <form action="{{ route('reservas.destroy', $reserva) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar esta reserva?');">
                                @csrf
                                @method('DELETE')
                                <button class="px-3 py-1 bg-red-600 text-white rounded">Eliminar</button>
                            </form>
                        @endcan
                    </div>
                </div>
            @empty
                <div class="bg-white p-4 rounded shadow">
                    <p>No tienes reservas registradas aún.</p>
                </div>
            @endforelse

            {{-- Paginación --}}
            <div class="mt-6">
                {{ $reservas->links() }}
            </div>

        </div>
    </div>
</x-app-layout>

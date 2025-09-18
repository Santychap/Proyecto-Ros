<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Pedidos</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-200 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-200 text-red-800 rounded">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Solo el cliente puede ver el botón para hacer pedido --}}
            @if(auth()->user()->rol === 'cliente')
                <a href="{{ route('menu.index') }}" class="mb-4 inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Ir al menú y hacer pedido
                </a>
            @endif

            {{-- Barra de búsqueda solo para el admin --}}
            @if(auth()->user()->rol === 'admin')
                <form method="GET" action="{{ route('pedidos.index') }}" class="mb-4 flex space-x-2">
                    <input
                        type="text"
                        name="search"
                        placeholder="Buscar por cliente, estado o fecha (YYYY-MM-DD)"
                        value="{{ request('search') }}"
                        class="px-4 py-2 border rounded w-full"
                    >
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        Buscar
                    </button>
                </form>
            @endif

            <table class="min-w-full bg-white border border-gray-300">
                <thead>
                    <tr>
                        @if(auth()->user()->rol !== 'cliente')
                            <th class="py-2 px-4 border-b">Cliente</th>
                        @endif

                        @if(auth()->user()->rol === 'admin' || auth()->user()->rol === 'empleado')
                            <th class="py-2 px-4 border-b">Empleado asignado</th>
                        @endif

                        <th class="py-2 px-4 border-b">Estado</th>
                        <th class="py-2 px-4 border-b">Comentario</th>
                        <th class="py-2 px-4 border-b">Detalles</th>
                        <th class="py-2 px-4 border-b">Fecha</th>

                        @if(auth()->user()->rol !== 'cliente')
                            <th class="py-2 px-4 border-b">Acciones</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pedidos as $pedido)
                        <tr>
                            @if(auth()->user()->rol !== 'cliente')
                                <td class="border-b py-2 px-4">{{ $pedido->user->name }}</td>
                            @endif

                            @if(auth()->user()->rol === 'admin' || auth()->user()->rol === 'empleado')
                                <td class="border-b py-2 px-4">
                                    {{ $pedido->empleado ? $pedido->empleado->name : 'Sin asignar' }}
                                </td>
                            @endif

                            <td class="border-b py-2 px-4">{{ $pedido->estado }}</td>
                            <td class="border-b py-2 px-4">{{ $pedido->comentario ?? '-' }}</td>

                            <td class="border-b py-2 px-4">
                                @foreach ($pedido->detalles as $detalle)
                                    <div>{{ $detalle->producto->nombre }} x{{ $detalle->cantidad }}</div>
                                @endforeach
                            </td>

                            <td class="border-b py-2 px-4">
                                {{ $pedido->created_at->format('d/m/Y H:i') }}
                            </td>

                            @if(auth()->user()->rol !== 'cliente')
                                <td class="border-b py-2 px-4 space-y-2">
                                    @if(auth()->user()->rol === 'admin' || auth()->user()->rol === 'empleado')
                                        @if($pedido->estado === 'Pendiente')
                                            <form action="{{ route('pedidos.actualizarEstado', $pedido) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('PUT')
                                                <select name="estado" onchange="this.form.submit()" class="border rounded px-2 py-1">
                                                    <option value="Pendiente" selected>Pendiente</option>
                                                    <option value="Pagado">Pagado</option>
                                                </select>
                                            </form>
                                        @elseif($pedido->estado === 'Pagado')
                                            <span class="px-2 py-1 bg-green-200 text-green-800 rounded">Pagado</span>
                                        @else
                                            <span class="px-2 py-1 text-gray-500">Sin acciones</span>
                                        @endif

                                        {{-- ✅ SOLO permitir cancelar si está Pendiente --}}
                                        @if(auth()->user()->rol === 'admin' && $pedido->estado === 'Pendiente')
                                            <form action="{{ route('pedidos.adminCancelar', $pedido) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit"
                                                    class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700"
                                                    onclick="return confirm('¿Seguro que quieres cancelar este pedido?')">
                                                    Cancelar
                                                </button>
                                            </form>
                                        @endif
                                    @endif
                                </td>
                            @endif
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ auth()->user()->rol !== 'cliente' ? 7 : 6 }}" class="py-4 text-center text-gray-500">
                                No hay pedidos para mostrar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>
</x-app-layout>

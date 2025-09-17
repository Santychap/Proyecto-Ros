<x-app-layout>
    <x-slot name="header">
        <h2 class="text-xl font-semibold text-gray-800">Mis Pagos</h2>
    </x-slot>

    <div class="py-6 max-w-6xl mx-auto">

        {{-- Mensaje de éxito --}}
        @if(session('success'))
            <div class="mb-4 p-4 text-green-800 bg-green-200 rounded">
                {{ session('success') }}
            </div>
        @endif

        {{-- Opcional: mostrar errores --}}
        @if($errors->any())
            <div class="mb-4 p-4 text-red-800 bg-red-200 rounded">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <table class="w-full bg-white border">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-2 border">ID</th>
                    <th class="p-2 border">Pedido</th>
                    <th class="p-2 border">Monto</th>
                    <th class="p-2 border">Método</th>
                    <th class="p-2 border">Fecha</th>
                    <th class="p-2 border">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pagos as $pago)
                    <tr>
                        <td class="p-2 border">{{ $pago->id }}</td>
                        <td class="p-2 border">#{{ $pago->pedido_id }}</td>
                        <td class="p-2 border">${{ $pago->monto }}</td>
                        <td class="p-2 border">{{ ucfirst($pago->metodo) }}</td>
                        <td class="p-2 border">{{ $pago->fecha_pago->format('d/m/Y') }}</td>
                        <td class="p-2 border">
                            <a href="{{ route('pagos.show', $pago) }}" class="text-blue-600 hover:underline">Ver</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">
            {{ $pagos->links() }}
        </div>
    </div>
</x-app-layout>

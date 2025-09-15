@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-black text-gold-500 p-6">
    <h1 class="text-3xl font-bold mb-6 border-b border-gold-500 pb-2">Mesas</h1>

    <a href="{{ route('mesas.create') }}"
       class="inline-block mb-4 px-5 py-2 border border-gold-500 text-gold-500 hover:bg-gold-500 hover:text-black transition rounded">
        ➕ Agregar Mesa
    </a>

    <div class="overflow-x-auto bg-gray-900 rounded shadow">
        <table class="min-w-full text-white text-sm">
            <thead class="bg-gray-800">
                <tr>
                    <th class="text-left px-4 py-3 text-gold-500">Código</th>
                    <th class="text-left px-4 py-3 text-gold-500">Capacidad</th>
                    <th class="text-left px-4 py-3 text-gold-500">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($mesas as $mesa)
                    <tr class="border-t border-gray-700 hover:bg-gray-800">
                        <td class="px-4 py-2">{{ $mesa->codigo }}</td>
                        <td class="px-4 py-2">{{ $mesa->capacidad }}</td>
                        <td class="px-4 py-2">
                            <a href="{{ route('mesas.edit', $mesa) }}"
                               class="text-gold-500 hover:underline">Editar</a>

                            <form action="{{ route('mesas.destroy', $mesa) }}" method="POST" class="inline ml-2">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        onclick="return confirm('¿Estás seguro?')"
                                        class="text-red-500 hover:text-red-400">
                                    Eliminar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-4 py-4 text-center text-gray-400">No hay mesas registradas.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $mesas->links() }}
    </div>
</div>
@endsection

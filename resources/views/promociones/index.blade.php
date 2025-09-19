@extends('layouts.menu')

@section('content')
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Promociones</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8 promos-theme">

        @if(session('success'))
            <div class="mb-4 p-4 bg-green-200 text-green-800 rounded">{{ session('success') }}</div>
        @endif

        <a href="{{ route('promociones.create') }}" class="mb-4 inline-block btn-promos">
            Crear Promoción
        </a>

        <table class="min-w-full promos-table">
            <thead>
                <tr>
                    <th>Título</th>
                    <th>Descuento (%)</th>
                    <th>Fecha Inicio</th>
                    <th>Fecha Fin</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($promociones as $promocion)
                    <tr>
                        <td>{{ $promocion->titulo }}</td>
                        <td><span class="badge-discount">{{ $promocion->descuento ?? '-' }}%</span></td>
                        <td>{{ $promocion->fecha_inicio->format('d/m/Y') }}</td>
                        <td>{{ $promocion->fecha_fin->format('d/m/Y') }}</td>
                        <td class="actions">
                            <a href="{{ route('promociones.edit', $promocion) }}" class="btn-action btn-edit" title="Editar"><i class="fas fa-edit"></i> <span>Editar</span></a>
                            <form action="{{ route('promociones.destroy', $promocion) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Eliminar promoción?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-delete" title="Eliminar"><i class="fas fa-trash"></i> <span>Eliminar</span></button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="py-4 text-center text-gray-500">No hay promociones para mostrar.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-4">
            {{ $promociones->links() }}
        </div>
    </div>
    <style>
    .promos-theme { --p-bg:#0f1117; --p-panel:#111827; --p-panel-2:#0b0f1a; --p-text:#e5e7eb; --p-muted:#9ca3af; --p-gold:#f4d03f; --p-outline:rgba(244,208,63,0.35); }
    .promos-table { width: 100%; border-collapse: separate; border-spacing: 0 10px; }
    .promos-table thead th { text-align: left; padding: 12px 16px; color: var(--p-muted); font-weight: 700; letter-spacing: .4px; font-size: 0.95rem; }
    .promos-table tbody tr { background: linear-gradient(180deg, var(--p-panel) 0%, var(--p-panel-2) 100%); box-shadow: 0 0 0 1px rgba(255,255,255,0.04) inset, 0 8px 24px rgba(0,0,0,0.35); }
    .promos-table tbody tr td { padding: 16px; color: var(--p-text); border-top: 1px solid rgba(255,255,255,0.06); border-bottom: 1px solid rgba(255,255,255,0.06); }
    .promos-table tbody tr td:first-child { border-left: 1px solid rgba(255,255,255,0.06); border-top-left-radius: 12px; border-bottom-left-radius: 12px; font-weight: 600; }
    .promos-table tbody tr td:last-child { border-right: 1px solid rgba(255,255,255,0.06); border-top-right-radius: 12px; border-bottom-right-radius: 12px; }
    .promos-table tbody tr:hover { transform: translateY(-2px); transition: transform .2s ease; }
    .badge-discount { background: rgba(244,208,63,0.15); color: var(--p-gold); border:1px solid var(--p-outline); padding: 6px 10px; border-radius: 999px; font-weight: 700; }
    .actions { display: flex; gap: 10px; align-items: center; }
    .btn-action { background:#0b0f1a; color:#fff; border:1px solid var(--p-outline); padding: 8px 12px; border-radius: 10px; display: inline-flex; align-items: center; gap: 8px; }
    .btn-action:hover { background: var(--p-gold); color:#0b0f1a; border-color: var(--p-gold); }
    .btn-edit i { color: var(--p-gold); }
    .btn-delete i { color: #e11d48; }
    .btn-promos { background:#0b0f1a; color:#fff; border:1px solid var(--p-outline); padding: 10px 14px; border-radius: 12px; font-weight: 700; }
    .btn-promos:hover { background: var(--p-gold); color:#0b0f1a; border-color: var(--p-gold); }
    </style>
@endsection

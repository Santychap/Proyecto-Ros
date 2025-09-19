<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800">Editar Promoción</h2>
    </x-slot>

    <div class="py-6 promos-theme">
        <div class="max-w-4xl mx-auto promo-card p-8 shadow rounded">
            <form action="{{ route('promociones.update', $promocion) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-6">
                    <label class="block font-medium text-sm label-muted">Título</label>
                    <input type="text" name="titulo" value="{{ old('titulo', $promocion->titulo) }}" class="mt-1 block w-full input-dark" required>
                    @error('titulo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-6">
                    <label class="block font-medium text-sm label-muted">Descripción</label>
                    <textarea name="descripcion" rows="4" class="mt-1 block w-full input-dark">{{ old('descripcion', $promocion->descripcion) }}</textarea>
                </div>

                <div class="mb-6">
                    <label class="block font-medium text-sm label-muted">Descuento (%)</label>
                    <input type="number" name="descuento" value="{{ old('descuento', $promocion->descuento) }}" class="mt-1 block w-full input-dark" required min="0" max="100" step="0.01">
                    @error('descuento') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-6">
                    <label class="block font-medium text-sm label-muted">Fecha de Inicio</label>
                    <input type="date" name="fecha_inicio" value="{{ old('fecha_inicio', $promocion->fecha_inicio->format('Y-m-d')) }}" class="mt-1 block w-full input-dark" required>
                    @error('fecha_inicio') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="mb-6">
                    <label class="block font-medium text-sm label-muted">Fecha de Fin</label>
                    <input type="date" name="fecha_fin" value="{{ old('fecha_fin', $promocion->fecha_fin ? $promocion->fecha_fin->format('Y-m-d') : '') }}" class="mt-1 block w-full input-dark">
                    @error('fecha_fin') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <div class="flex justify-end space-x-4 actions-bar">
                    <a href="{{ route('promociones.index') }}" class="btn-dark">Cancelar</a>
                    <button type="submit" class="btn-gold">Actualizar Promoción</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
<style>
.promos-theme { --p-bg:#0f1117; --p-panel:#111827; --p-panel-2:#0b0f1a; --p-text:#e5e7eb; --p-muted:#9ca3af; --p-gold:#f4d03f; --p-outline:rgba(244,208,63,0.35); }
.promo-card { background: linear-gradient(180deg, var(--p-panel) 0%, var(--p-panel-2) 100%); border:1px solid rgba(255,255,255,0.06); border-radius:16px; color: var(--p-text); }
.label-muted { color: var(--p-muted); }
.input-dark { background:#0b0f1a; border:1px solid rgba(255,255,255,0.08); color: var(--p-text); border-radius:10px; height:48px; padding:10px 12px; }
.input-dark:focus { border-color: var(--p-gold); box-shadow: 0 0 0 0.2rem rgba(244,208,63,0.15); outline: none; }
textarea.input-dark { height: auto; min-height: 110px; padding-top: 12px; }
.btn-dark { background:#0b0f1a; color:#fff; border:1px solid var(--p-outline); padding:10px 16px; border-radius:12px; }
.btn-gold { background: var(--p-gold); color:#0b0f1a; border:1px solid var(--p-gold); padding:10px 16px; border-radius:12px; font-weight:700; }
.btn-dark:hover { background: rgba(244,208,63,0.12); color: var(--p-gold); border-color: var(--p-gold); }
.btn-gold:hover { filter: brightness(1.05); }
.actions-bar { margin-top: 8px; }
</style>

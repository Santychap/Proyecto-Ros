<<<<<<< HEAD
@extends('layouts.menu')

@section('title', 'Crear Noticia - Olla y Sazón')

@section('content')
<div class="noticia-form-container">
    <div class="form-header">
        <h1 class="form-title">
            <i class="fas fa-plus-circle"></i>
            Crear Nueva Noticia
        </h1>
        <p class="form-subtitle">Agrega una nueva noticia o anuncio para el restaurante</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-error">
            <i class="fas fa-exclamation-circle"></i>
            <div>
                <strong>Por favor corrige los siguientes errores:</strong>
                <ul style="margin: 0.5rem 0 0 0; padding-left: 1.5rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <div class="form-card">
        <form action="{{ route('noticias.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-heading"></i> Título de la Noticia
                </label>
                <input type="text" name="titulo" class="form-input" 
                       value="{{ old('titulo') }}" required 
                       placeholder="Ej: Nueva promoción de fin de semana">
            </div>

            <div class="form-group">
                <label class="form-label">
                    <i class="fas fa-align-left"></i> Contenido
                </label>
                <textarea name="contenido" class="form-input" rows="6" required
                          placeholder="Escribe aquí el contenido completo de la noticia...">{{ old('contenido') }}</textarea>
                <small class="form-help">Describe detalladamente la noticia o anuncio que quieres publicar</small>
            </div>

            <div class="form-actions">
                <a href="{{ route('noticias.index') }}" class="btn-secondary">
                    <i class="fas fa-arrow-left"></i> Cancelar
                </a>
                <button type="submit" class="btn-primary">
                    <i class="fas fa-save"></i> Crear Noticia
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
.noticia-form-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 2rem;
}

.form-header {
    text-align: center;
    margin-bottom: 2rem;
}

.form-title {
    font-size: 2.5rem;
    color: var(--color-primary);
    margin-bottom: 0.5rem;
    font-weight: bold;
}

.form-subtitle {
    color: var(--text-muted);
    font-size: 1.1rem;
}

.form-card {
    background: var(--bg-glass);
    border: 2px solid var(--color-primary);
    border-radius: 20px;
    padding: 2rem;
    backdrop-filter: blur(15px);
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-label {
    display: block;
    color: var(--color-primary);
    font-weight: 600;
    margin-bottom: 0.5rem;
    font-size: 1rem;
}

.form-label i {
    margin-right: 0.5rem;
    width: 16px;
    text-align: center;
}

.form-input {
    width: 100%;
    padding: 1rem;
    border: 2px solid rgba(255, 215, 0, 0.3);
    border-radius: 10px;
    background: rgba(255, 255, 255, 0.9);
    color: #000000;
    font-size: 1rem;
    transition: all 0.3s ease;
    resize: vertical;
}

.form-input:focus {
    outline: none;
    border-color: var(--color-primary);
    background: rgba(255, 255, 255, 0.95);
    box-shadow: 0 0 0 3px rgba(255, 215, 0, 0.2);
    color: #000000;
}

.form-input::placeholder {
    color: rgba(0, 0, 0, 0.6);
}

.form-help {
    display: block;
    margin-top: 0.5rem;
    color: var(--text-muted);
    font-size: 0.9rem;
    line-height: 1.4;
}

.form-actions {
    display: flex;
    gap: 1rem;
    justify-content: center;
    margin-top: 2rem;
}

.btn-primary, .btn-secondary {
    padding: 1rem 2rem;
    border: none;
    border-radius: 10px;
    font-weight: 600;
    font-size: 1rem;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.3s ease;
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
}

.btn-primary {
    background: var(--color-primary);
    color: #000;
}

.btn-primary:hover {
    background: var(--color-primary-light);
    color: #000;
    transform: translateY(-2px);
}

.btn-secondary {
    background: rgba(255, 255, 255, 0.1);
    color: var(--text-light);
    border: 2px solid rgba(255, 215, 0, 0.3);
}

.btn-secondary:hover {
    background: rgba(255, 215, 0, 0.1);
    border-color: var(--color-primary);
    color: var(--text-light);
}

.alert {
    padding: 1rem;
    border-radius: 10px;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: flex-start;
    gap: 0.5rem;
}

.alert-error {
    background: rgba(255, 71, 87, 0.1);
    border: 2px solid #ff4757;
    color: #ff4757;
}

@media (max-width: 768px) {
    .form-actions {
        flex-direction: column;
    }
    
    .noticia-form-container {
        padding: 1rem;
    }
    
    .form-title {
        font-size: 2rem;
    }
}
</style>
@endpush
=======
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Crear Noticia</h2>
    </x-slot>

    <div class="py-6 max-w-lg mx-auto sm:px-6 lg:px-8">

        <form action="{{ route('noticias.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label for="titulo" class="block font-medium text-gray-700">Título</label>
                <input type="text" name="titulo" id="titulo" value="{{ old('titulo') }}" class="mt-1 block w-full border border-gray-300 rounded p-2" required>
                @error('titulo') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="contenido" class="block font-medium text-gray-700">Contenido</label>
                <textarea name="contenido" id="contenido" rows="5" class="mt-1 block w-full border border-gray-300 rounded p-2" required>{{ old('contenido') }}</textarea>
                @error('contenido') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="flex space-x-2">
                <a href="{{ route('noticias.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancelar</a>
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Guardar</button>
            </div>
        </form>

    </div>
</x-app-layout>
>>>>>>> c5eafba12a8e0645d3d855a7405f2f47bcd1ef45

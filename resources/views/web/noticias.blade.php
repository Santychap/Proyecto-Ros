@extends('layouts.menu')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/noticias.css') }}">
@endpush

@section('content')
<div class="hero">
    <h1><i class="fas fa-newspaper"></i> Noticias</h1>
    <p class="tagline">Últimas novedades del restaurante</p>
</div>

<div class="noticias">

    <div class="cuadros-grid">
        @forelse($noticias as $noticia)
            <div class="cuadro">
                @if($noticia->imagen)
                    <div class="cuadro-image">
                        <img src="{{ asset('storage/' . $noticia->imagen) }}" alt="{{ $noticia->titulo }}" onerror="this.src='https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=400&h=200&fit=crop'">
                    </div>
                @else
                    <div class="cuadro-image">
                        <img src="https://images.unsplash.com/photo-1504674900247-0877df9cc836?w=400&h=200&fit=crop" alt="{{ $noticia->titulo }}">
                    </div>
                @endif
                <div class="cuadro-content">
                    <h3 style="color: #fff;">{{ $noticia->titulo }}</h3>
                    <p style="color: #e0e0e0;">{{ Str::limit($noticia->contenido, 120) }}</p>
                    <div class="cuadro-meta" style="color: #ffd700;">
                        <span><i class="fas fa-calendar"></i> {{ $noticia->created_at->format('d/m/Y') }}</span>
                    </div>
                </div>
            </div>
        @empty
                <div class="cuadro-empty" style="color: #fff;">No hay noticias disponibles.</div>
        @endforelse
    </div>
</div>
@endsection
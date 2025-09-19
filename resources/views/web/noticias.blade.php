@extends('layouts.menu')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/noticias.css') }}">
@endpush

@section('content')
<div class="hero">
    <h1><i class="fas fa-newspaper"></i> Noticias</h1>
    <p class="tagline">Mantente informado sobre las últimas novedades del restaurante</p>
</div>

<div class="noticias">
    <h2 class="section-title">📰 Últimas Noticias</h2>

    <div class="cuadros-grid">
        @forelse($noticias as $noticia)
            <div class="cuadro">
                <div class="cuadro-icon">
                    <i class="fas fa-newspaper"></i>
                </div>
                <div class="cuadro-content">
                    <h3>{{ $noticia->titulo }}</h3>
                    <p>{{ Str::limit($noticia->contenido, 150) }}</p>
                    <span class="cuadro-badge">{{ $noticia->created_at->format('d/m/Y') }}</span>
                </div>
            </div>
        @empty
            <div class="cuadro">
                <div class="cuadro-icon">
                    <i class="fas fa-info-circle"></i>
                </div>
                <div class="cuadro-content">
                    <h3>No hay noticias disponibles</h3>
                    <p>Pronto tendremos noticias emocionantes para compartir contigo.</p>
                    <span class="cuadro-badge">Próximamente</span>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
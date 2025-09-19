@extends('layouts.menu')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/noticias.css') }}">
@endpush

@section('content')
<div class="hero">
    <h1><i class="fas fa-tags"></i> Promociones</h1>
    <p class="tagline">Descubre nuestras ofertas especiales y promociones exclusivas</p>
</div>

<div class="noticias">
    <h2 class="section-title">🏷️ Promociones Activas</h2>

    <div class="cuadros-grid">
        @forelse($promociones as $promocion)
            <div class="cuadro">
                <div class="cuadro-icon">
                    <i class="fas fa-percent"></i>
                </div>
                <div class="cuadro-content">
                    <h3>{{ $promocion->titulo }}</h3>
                    <p>{{ $promocion->descripcion ?? 'Promoción especial disponible por tiempo limitado.' }}</p>
                    @if($promocion->descuento)
                        <div style="margin: 10px 0;">
                            <strong style="color: gold; font-size: 1.2em;">{{ $promocion->descuento }}% de descuento</strong>
                        </div>
                    @endif
                    <div style="font-size: 0.9em; color: #ccc; margin-top: 10px;">
                        <p>📅 Desde: {{ $promocion->fecha_inicio->format('d/m/Y') }}</p>
                        @if($promocion->fecha_fin)
                            <p>📅 Hasta: {{ $promocion->fecha_fin->format('d/m/Y') }}</p>
                        @endif
                    </div>
                    <span class="cuadro-badge">¡OFERTA!</span>
                </div>
            </div>
        @empty
            <div class="cuadro">
                <div class="cuadro-icon">
                    <i class="fas fa-info-circle"></i>
                </div>
                <div class="cuadro-content">
                    <h3>No hay promociones activas</h3>
                    <p>Mantente atento a nuestras redes sociales para no perderte las próximas ofertas especiales.</p>
                    <span class="cuadro-badge">Próximamente</span>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection
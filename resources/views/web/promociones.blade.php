@extends('layouts.menu')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/noticias.css') }}">
@endpush

@section('content')
<div class="hero">
    <h1><i class="fas fa-tags"></i> Promociones</h1>
    <p class="tagline">Ofertas especiales y descuentos exclusivos</p>
</div>

<div class="noticias">

    <div class="cuadros-grid">
        @forelse($promociones as $promocion)
            <div class="cuadro">
                @if($promocion->imagen)
                    <div class="cuadro-image">
                        <img src="{{ asset('storage/' . $promocion->imagen) }}" alt="{{ $promocion->titulo }}" onerror="this.src='https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=400&h=200&fit=crop'">
                    </div>
                @else
                    <div class="cuadro-image">
                        <img src="https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=400&h=200&fit=crop" alt="{{ $promocion->titulo }}">
                    </div>
                @endif
                <div class="cuadro-content">
                    <h3 style="color: #fff;">{{ $promocion->titulo }}</h3>
                    <p style="color: #e0e0e0;">{{ Str::limit($promocion->descripcion, 120) }}</p>
                    <div class="cuadro-meta" style="color: #ffd700;">
                        <span><i class="fas fa-percent"></i> {{ $promocion->descuento }}% </span>
                        <span><i class="fas fa-calendar"></i> {{ $promocion->fecha_inicio->format('d/m/Y') }} - {{ $promocion->fecha_fin ? $promocion->fecha_fin->format('d/m/Y') : 'Sin fecha fin' }}</span>
                    </div>
                </div>
            </div>
        @empty
                <div class="cuadro-empty" style="color: #fff;">No hay promociones activas.</div>
        @endforelse
    </div>
</div>
@endsection
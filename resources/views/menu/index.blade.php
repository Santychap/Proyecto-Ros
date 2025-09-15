@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Menú</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row">
        @foreach($productos as $producto)
            <div class="col-md-4 mb-3">
                <div class="card">
                    @if($producto->image)
                        <img src="{{ asset('storage/' . $producto->image) }}" class="card-img-top" style="height:200px; object-fit:cover;">
                    @else
                        <img src="https://via.placeholder.com/200x200?text=Sin+Imagen" class="card-img-top">
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $producto->nombre }}</h5>
                        <p>{{ $producto->descripcion }}</p>
                        <p><strong>${{ number_format($producto->precio, 2) }}</strong></p>
                        
                        <form action="{{ route('carrito.agregar') }}" method="POST">
                            @csrf
                            <input type="hidden" name="producto_id" value="{{ $producto->id }}">
                            <button type="submit" class="btn btn-primary w-100">Agregar al carrito</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <a href="{{ route('carrito.mostrar') }}" class="btn btn-success mt-3">Ver Carrito</a>
</div>
@endsection

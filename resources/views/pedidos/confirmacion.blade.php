@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto mt-10 p-6 bg-white rounded shadow">
    @if(session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
            {{ session('success') }}
        </div>
    @endif

    <h1 class="text-2xl font-semibold mb-4">¡Gracias por tu pedido!</h1>
    <p>Tu pedido ha sido confirmado correctamente.</p>
    <a href="{{ route('menu.index') }}" class="mt-6 inline-block bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Volver al menú
    </a>
</div>
@endsection

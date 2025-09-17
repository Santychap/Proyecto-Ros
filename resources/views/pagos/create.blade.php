@extends('layouts.app')

@section('content')
<div class="max-w-xl mx-auto mt-10 p-6 bg-white rounded shadow">

    <h1 class="text-2xl font-semibold mb-6">Pagar Pedido #{{ $pedido->id }}</h1>

    <form action="{{ route('pagos.store', ['pedido' => $pedido->id]) }}" method="POST" id="formPago">
        @csrf

        <div class="mb-4">
            <label class="block font-semibold mb-1">Total a pagar:</label>
            <input type="text" 
                   value="${{ number_format($pedido->total, 2) }}" 
                   readonly 
                   class="border rounded w-full py-2 px-3 bg-gray-100 cursor-not-allowed" />
        </div>

        <div class="mb-4">
            <label for="metodo" class="block font-semibold mb-1">Método de pago:</label>
            <select id="metodo" name="metodo" class="border rounded w-full py-2 px-3" required>
                @foreach($metodos as $metodo)
                    <option value="{{ $metodo }}">{{ ucfirst($metodo) }}</option>
                @endforeach
            </select>
        </div>

        {{-- Campos para tarjeta --}}
        <div id="campos-tarjeta" class="mb-4 hidden">
            <label class="block font-semibold mb-1">Número de tarjeta:</label>
            <input type="text" name="numero_tarjeta" placeholder="1234 5678 9012 3456" class="border rounded w-full py-2 px-3" />

            <label class="block font-semibold mt-4 mb-1">Fecha de expiración:</label>
            <input type="text" name="expiracion_tarjeta" placeholder="MM/AA" class="border rounded w-full py-2 px-3" />

            <label class="block font-semibold mt-4 mb-1">Código CVV:</label>
            <input type="text" name="cvv_tarjeta" placeholder="123" class="border rounded w-full py-2 px-3" />
        </div>

        {{-- Campos para transferencia --}}
        <div id="campos-transferencia" class="mb-4 hidden">
            <label class="block font-semibold mb-1">Número de referencia bancaria:</label>
            <input type="text" name="referencia_transferencia" placeholder="Ej: 123456789" class="border rounded w-full py-2 px-3" />
        </div>

        {{-- Campos para PayPal --}}
        <div id="campos-paypal" class="mb-4 hidden">
            <label class="block font-semibold mb-1">Correo electrónico de PayPal:</label>
            <input type="email" name="email_paypal" placeholder="usuario@paypal.com" class="border rounded w-full py-2 px-3" />
        </div>

        {{-- No se muestra opción efectivo para cliente --}}

        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Confirmar Pago
        </button>
    </form>
</div>

<script>
    const metodoSelect = document.getElementById('metodo');
    const camposTarjeta = document.getElementById('campos-tarjeta');
    const camposTransferencia = document.getElementById('campos-transferencia');
    const camposPaypal = document.getElementById('campos-paypal');

    function mostrarCampos() {
        const metodo = metodoSelect.value;

        // Ocultar todos los grupos
        camposTarjeta.classList.add('hidden');
        camposTransferencia.classList.add('hidden');
        camposPaypal.classList.add('hidden');

        // Limpiar inputs de todos los grupos
        camposTarjeta.querySelectorAll('input').forEach(input => input.value = '');
        camposTransferencia.querySelectorAll('input').forEach(input => input.value = '');
        camposPaypal.querySelectorAll('input').forEach(input => input.value = '');

        // Mostrar según método seleccionado
        if (metodo === 'tarjeta') {
            camposTarjeta.classList.remove('hidden');
        } else if (metodo === 'transferencia') {
            camposTransferencia.classList.remove('hidden');
        } else if (metodo === 'paypal') {
            camposPaypal.classList.remove('hidden');
        }
        // efectivo no aparece para cliente
    }

    metodoSelect.addEventListener('change', mostrarCampos);

    // Ejecutar al cargar para mostrar campos correctamente
    mostrarCampos();
</script>
@endsection

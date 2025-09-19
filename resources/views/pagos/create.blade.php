<<<<<<< HEAD
@extends('layouts.menu')

@section('content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0">
                <div class="card-header bg-gradient-primary text-white border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="mb-0">
                                <i class="fas fa-credit-card me-2"></i>Registrar Nuevo Pago
                            </h4>
                            <p class="mb-0 opacity-8">Completa la información del pago</p>
                        </div>
                        <a href="{{ route('pagos.index') }}" class="btn btn-light btn-sm">
                            <i class="fas fa-arrow-left me-1"></i>Volver
                        </a>
                    </div>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('pagos.store') }}" method="POST">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="pedido_id" class="form-label fw-bold">
                                    <i class="fas fa-receipt me-2 text-primary"></i>Pedido
                                </label>
                                <select name="pedido_id" id="pedido_id" class="form-select @error('pedido_id') is-invalid @enderror" required>
                                    <option value="">Seleccionar pedido...</option>
                                    @foreach($pedidos as $pedido)
                                    <option value="{{ $pedido->id }}" {{ old('pedido_id') == $pedido->id ? 'selected' : '' }}>
                                        Pedido #{{ $pedido->numero }} - {{ $pedido->cliente }} - Mesa {{ $pedido->mesa->numero }} (${{ number_format($pedido->total, 2) }})
                                    </option>
                                    @endforeach
                                </select>
                                @error('pedido_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="monto" class="form-label fw-bold">
                                    <i class="fas fa-dollar-sign me-2 text-success"></i>Monto
                                </label>
                                <input type="number" step="0.01" name="monto" id="monto" 
                                       class="form-control @error('monto') is-invalid @enderror" 
                                       value="{{ old('monto') }}" placeholder="0.00" required>
                                @error('monto')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="metodo" class="form-label fw-bold">
                                    <i class="fas fa-credit-card me-2 text-info"></i>Método de Pago
                                </label>
                                <select name="metodo" id="metodo" class="form-select @error('metodo') is-invalid @enderror" required>
                                    <option value="">Seleccionar método...</option>
                                    <option value="efectivo" {{ old('metodo') == 'efectivo' ? 'selected' : '' }}>
                                        <i class="fas fa-money-bill"></i> Efectivo
                                    </option>
                                    <option value="tarjeta" {{ old('metodo') == 'tarjeta' ? 'selected' : '' }}>
                                        <i class="fas fa-credit-card"></i> Tarjeta
                                    </option>
                                    <option value="transferencia" {{ old('metodo') == 'transferencia' ? 'selected' : '' }}>
                                        <i class="fas fa-exchange-alt"></i> Transferencia
                                    </option>

                                </select>
                                @error('metodo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="fecha" class="form-label fw-bold">
                                    <i class="fas fa-calendar me-2 text-warning"></i>Fecha y Hora
                                </label>
                                <input type="datetime-local" name="fecha_pago" id="fecha_pago" 
                                       class="form-control @error('fecha_pago') is-invalid @enderror" 
                                       value="{{ old('fecha_pago', now()->format('Y-m-d\TH:i')) }}" required>
                                @error('fecha_pago')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">

                        </div>

                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('pagos.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Registrar Pago
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('pedido_id').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    if (selectedOption.value) {
        const text = selectedOption.text;
        const match = text.match(/\$([0-9,]+\.?[0-9]*)\)/);
        if (match) {
            document.getElementById('monto').value = match[1].replace(',', '');
        }
    }
});
</script>
@endsection
=======
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
>>>>>>> c5eafba12a8e0645d3d855a7405f2f47bcd1ef45

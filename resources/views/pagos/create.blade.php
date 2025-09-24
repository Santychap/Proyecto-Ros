@extends('layouts.cliente')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
<style>
.payment-method {
    border: 2px solid rgba(255, 215, 0, 0.3);
    border-radius: 15px;
    padding: 20px;
    margin-bottom: 20px;
    cursor: pointer;
    transition: all 0.3s ease;
    background: rgba(0, 0, 0, 0.3);
}

.payment-method:hover {
    border-color: #ffd700;
    background: rgba(255, 215, 0, 0.1);
}

.payment-method.selected {
    border-color: #ffd700;
    background: rgba(255, 215, 0, 0.2);
}

.payment-form {
    display: none;
    margin-top: 20px;
    padding: 20px;
    background: rgba(255, 215, 0, 0.1);
    border-radius: 10px;
}

.payment-form.active {
    display: block;
}

.bank-info {
    background: rgba(0, 0, 0, 0.3);
    padding: 15px;
    border-radius: 10px;
    margin: 15px 0;
    border: 1px solid rgba(255, 215, 0, 0.3);
}

.payment-method input, .payment-method select {
    background: rgba(0, 0, 0, 0.5) !important;
    color: #ffffff !important;
    border: 1px solid #ffd700 !important;
}

.payment-method label {
    color: #ffd700 !important;
    font-weight: 600;
}

@media (max-width: 768px) {
    .dashboard-main {
        padding: 15px !important;
    }
    
    div[style*="grid-template-columns: 1fr 1fr"] {
        grid-template-columns: 1fr !important;
    }
}
</style>
@endpush

@section('content')
<div class="dashboard-main" style="padding: 30px; width: 100%;">
    <div style="max-width: 1200px; margin: 0 auto;">
        <!-- Header -->
        <div class="chart-container" style="text-align: center; margin-bottom: 30px;">
            <h1 class="title-primary" style="display: flex; align-items: center; justify-content: center; gap: 15px; margin-bottom: 10px;">
                <i class="fas fa-credit-card"></i>
                Procesar Pago
            </h1>
            <p style="color: #cccccc; font-size: 1.1rem;">Selecciona tu método de pago preferido</p>
        </div>

        <!-- Resumen del pedido -->
        <div class="chart-container" style="margin-bottom: 30px;">
            <h2 class="chart-title" style="display: flex; align-items: center; gap: 10px; margin-bottom: 20px;">
                <i class="fas fa-receipt"></i>
                Resumen del Pedido #{{ $pedido->numero }}
            </h2>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; align-items: center;">
                <div>
                    <div style="display: flex; flex-direction: column; gap: 10px;">
                        <p style="color: #ffffff;"><strong style="color: #ffd700;">Cliente:</strong> {{ $pedido->user->name }}</p>
                        <p style="color: #ffffff;"><strong style="color: #ffd700;">Fecha:</strong> {{ $pedido->created_at->format('d/m/Y H:i') }}</p>
                        @if($pedido->empleado)
                            <p style="color: #ffffff;"><strong style="color: #ffd700;">Empleado:</strong> {{ $pedido->empleado->name }}</p>
                        @endif
                    </div>
                </div>
                <div style="text-align: right;">
                    <div style="font-size: 2.5rem; font-weight: bold; color: #51cf66; margin-bottom: 5px;">
                        ${{ number_format($pedido->total, 2) }}
                    </div>
                    <p style="color: #cccccc;">Total a pagar</p>
                </div>
            </div>

            <!-- Productos -->
            <div style="margin-top: 20px;">
                <h3 style="color: #ffd700; font-weight: 600; margin-bottom: 10px;">Productos:</h3>
                <div style="background: rgba(255, 215, 0, 0.1); border-radius: 10px; padding: 15px;">
                    @foreach($pedido->detalles as $detalle)
                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 5px 0; border-bottom: 1px solid rgba(255, 215, 0, 0.2);">
                            <span style="color: #ffffff; font-size: 0.9rem;">{{ $detalle->producto->nombre }} x{{ $detalle->cantidad }}</span>
                            <span style="color: #ffd700; font-weight: 600; font-size: 0.9rem;">${{ number_format($detalle->producto->precio * $detalle->cantidad, 2) }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Métodos de pago -->
        <div class="chart-container">
            <h2 class="chart-title" style="margin-bottom: 30px;">Selecciona el método de pago</h2>
            
            <form action="{{ route('pagos.store', $pedido) }}" method="POST" id="paymentForm">
                @csrf
                
                <!-- Efectivo -->
                <div class="payment-method" data-method="efectivo">
                    <div class="flex items-center">
                        <input type="radio" name="metodo" value="efectivo" id="efectivo" class="mr-3">
                        <div class="flex-1">
                            <div class="flex items-center">
                                <i class="fas fa-money-bill-wave text-green-600 text-xl mr-3"></i>
                                <div>
                                    <h3 class="font-semibold">Efectivo</h3>
                                    <p class="text-gray-600 text-sm">Paga en efectivo al recibir tu pedido</p>
                                </div>
                            </div>
                        </div>
                        <div class="text-yellow-600 font-semibold text-sm">
                            Pago pendiente
                        </div>
                    </div>
                    
                    <div class="payment-form" id="efectivo-form">
                        <p class="text-sm text-gray-600 mb-3">
                            <i class="fas fa-info-circle mr-2"></i>
                            Al seleccionar efectivo, tu pago quedará como pendiente hasta que el empleado o administrador confirme el pago.
                        </p>
                    </div>
                </div>

                <!-- PSE -->
                <div class="payment-method" data-method="pse">
                    <div class="flex items-center">
                        <input type="radio" name="metodo" value="pse" id="pse" class="mr-3">
                        <div class="flex-1">
                            <div class="flex items-center">
                                <i class="fas fa-university text-blue-600 text-xl mr-3"></i>
                                <div>
                                    <h3 class="font-semibold">PSE</h3>
                                    <p class="text-gray-600 text-sm">Pago seguro con tu cuenta bancaria</p>
                                </div>
                            </div>
                        </div>
                        <div class="text-green-600 font-semibold text-sm">
                            Pago inmediato
                        </div>
                    </div>
                    
                    <div class="payment-form" id="pse-form">
                        <div class="grid md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium mb-2">Banco</label>
                                <select name="datos_pago[banco]" class="w-full border rounded px-3 py-2">
                                    <option value="">Selecciona tu banco</option>
                                    <option value="bancolombia">Bancolombia</option>
                                    <option value="davivienda">Davivienda</option>
                                    <option value="bbva">BBVA</option>
                                    <option value="banco_bogota">Banco de Bogotá</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2">Tipo de documento</label>
                                <select name="datos_pago[tipo_documento]" class="w-full border rounded px-3 py-2">
                                    <option value="cc">Cédula de Ciudadanía</option>
                                    <option value="ce">Cédula de Extranjería</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2">Número de documento</label>
                                <input type="text" name="datos_pago[documento]" class="w-full border rounded px-3 py-2" placeholder="123456789">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-2">Email</label>
                                <input type="email" name="datos_pago[email]" class="w-full border rounded px-3 py-2" placeholder="ejemplo@correo.com">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Nequi -->
                <div class="payment-method" data-method="nequi">
                    <div class="flex items-center">
                        <input type="radio" name="metodo" value="nequi" id="nequi" class="mr-3">
                        <div class="flex-1">
                            <div class="flex items-center">
                                <i class="fas fa-mobile-alt text-purple-600 text-xl mr-3"></i>
                                <div>
                                    <h3 class="font-semibold">Nequi</h3>
                                    <p class="text-gray-600 text-sm">Paga fácilmente desde tu app Nequi</p>
                                </div>
                            </div>
                        </div>
                        <div class="text-green-600 font-semibold text-sm">
                            Pago inmediato
                        </div>
                    </div>
                    
                    <div class="payment-form" id="nequi-form">
                        <div class="grid md:grid-cols-2 gap-6">
                            <div>
                                <div class="mb-4">
                                    <label class="block text-sm font-medium mb-2">Número de teléfono Nequi</label>
                                    <input type="tel" name="datos_pago[telefono]" class="w-full border rounded px-3 py-2" placeholder="3001234567">
                                </div>
                                <div class="bg-purple-50 p-4 rounded">
                                    <h4 class="font-semibold mb-2">Instrucciones:</h4>
                                    <ol class="text-sm space-y-1">
                                        <li>1. Escanea el código QR con Nequi</li>
                                        <li>2. O envía <strong>${{ number_format($pedido->total, 2) }}</strong> al 3001234567</li>
                                        <li>3. Confirma la transacción</li>
                                        <li>4. Guarda el comprobante</li>
                                    </ol>
                                </div>
                            </div>
                            <div class="text-center">
                                <h4 class="font-semibold mb-3">Código QR Nequi</h4>
                                <div class="bg-white p-4 rounded-lg border-2 border-purple-200 inline-block">
                                    <div id="nequi-qr" class="w-48 h-48 bg-gray-100 rounded flex items-center justify-center">
                                        <div class="text-center">
                                            <i class="fas fa-qrcode text-4xl text-purple-600 mb-2"></i>
                                            <p class="text-sm text-gray-600">QR Nequi</p>
                                            <p class="text-xs text-gray-500 mt-1">Valor: ${{ number_format($pedido->total, 2) }}</p>
                                        </div>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-600 mt-2">Escanea con tu app Nequi</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Daviplata -->
                <div class="payment-method" data-method="daviplata">
                    <div class="flex items-center">
                        <input type="radio" name="metodo" value="daviplata" id="daviplata" class="mr-3">
                        <div class="flex-1">
                            <div class="flex items-center">
                                <i class="fas fa-wallet text-red-600 text-xl mr-3"></i>
                                <div>
                                    <h3 class="font-semibold">Daviplata</h3>
                                    <p class="text-gray-600 text-sm">Paga con tu billetera digital Daviplata</p>
                                </div>
                            </div>
                        </div>
                        <div class="text-green-600 font-semibold text-sm">
                            Pago inmediato
                        </div>
                    </div>
                    
                    <div class="payment-form" id="daviplata-form">
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">Número de teléfono Daviplata</label>
                            <input type="tel" name="datos_pago[telefono]" class="w-full border rounded px-3 py-2" placeholder="3001234567">
                        </div>
                        <div class="bg-red-50 p-4 rounded">
                            <h4 class="font-semibold mb-2">Instrucciones:</h4>
                            <ol class="text-sm space-y-1">
                                <li>1. Abre tu app Daviplata</li>
                                <li>2. Selecciona "Pagar" o "Enviar dinero"</li>
                                <li>3. Envía <strong>${{ number_format($pedido->total, 2) }}</strong> al número del restaurante</li>
                                <li>4. Confirma con tu PIN</li>
                            </ol>
                        </div>
                    </div>
                </div>

                <!-- Bancolombia -->
                <div class="payment-method" data-method="bancolombia">
                    <div class="flex items-center">
                        <input type="radio" name="metodo" value="bancolombia" id="bancolombia" class="mr-3">
                        <div class="flex-1">
                            <div class="flex items-center">
                                <i class="fas fa-building text-yellow-600 text-xl mr-3"></i>
                                <div>
                                    <h3 class="font-semibold">Transferencia Bancolombia</h3>
                                    <p class="text-gray-600 text-sm">Transferencia directa a cuenta Bancolombia</p>
                                </div>
                            </div>
                        </div>
                        <div class="text-green-600 font-semibold text-sm">
                            Pago inmediato
                        </div>
                    </div>
                    
                    <div class="payment-form" id="bancolombia-form">
                        <div class="bank-info">
                            <h4 class="font-semibold mb-2">Datos de la cuenta:</h4>
                            <div class="text-sm space-y-1">
                                <p><strong>Banco:</strong> Bancolombia</p>
                                <p><strong>Tipo:</strong> Cuenta de Ahorros</p>
                                <p><strong>Número:</strong> 123-456789-01</p>
                                <p><strong>Titular:</strong> Restaurante S.A.S</p>
                                <p><strong>NIT:</strong> 900.123.456-7</p>
                            </div>
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium mb-2">Número de referencia de la transferencia</label>
                            <input type="text" name="datos_pago[referencia]" class="w-full border rounded px-3 py-2" placeholder="ABC123XYZ">
                            <p class="text-xs text-gray-600 mt-1">Ingresa el número que aparece en tu comprobante</p>
                        </div>
                    </div>
                </div>

                <!-- Botones -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 40px;">
                    <a href="{{ route('pedidos.confirmacion', $pedido) }}" 
                       class="btn" style="background: #666; color: #fff;">
                        <i class="fas fa-arrow-left"></i>Volver
                    </a>
                    
                    <button type="submit" 
                            class="btn" style="background: #51cf66; color: #000;"
                            id="submitBtn" disabled>
                        <i class="fas fa-check"></i>Confirmar Pago
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/qrcode@1.5.3/build/qrcode.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentMethods = document.querySelectorAll('.payment-method');
    const paymentForms = document.querySelectorAll('.payment-form');
    const submitBtn = document.getElementById('submitBtn');
    
    // Generar QR de Nequi
    function generateNequiQR() {
        const nequiData = {
            phone: '3001234567',
            amount: {{ $pedido->total }},
            concept: 'Pedido #{{ $pedido->numero }}'
        };
        
        const qrText = `nequi://pay?phone=${nequiData.phone}&amount=${nequiData.amount}&concept=${encodeURIComponent(nequiData.concept)}`;
        
        const qrContainer = document.getElementById('nequi-qr');
        if (qrContainer) {
            qrContainer.innerHTML = '';
            QRCode.toCanvas(qrContainer, qrText, {
                width: 192,
                height: 192,
                color: {
                    dark: '#7c3aed',
                    light: '#ffffff'
                }
            }, function (error) {
                if (error) {
                    console.error('Error generando QR:', error);
                    qrContainer.innerHTML = `
                        <div class="text-center">
                            <i class="fas fa-qrcode text-4xl text-purple-600 mb-2"></i>
                            <p class="text-sm text-gray-600">QR Nequi</p>
                            <p class="text-xs text-gray-500 mt-1">Valor: ${{ number_format($pedido->total, 2) }}</p>
                        </div>
                    `;
                }
            });
        }
    }
    
    paymentMethods.forEach(method => {
        method.addEventListener('click', function() {
            const methodType = this.dataset.method;
            const radio = this.querySelector('input[type="radio"]');
            
            // Limpiar selecciones anteriores
            paymentMethods.forEach(m => m.classList.remove('selected'));
            paymentForms.forEach(f => f.classList.remove('active'));
            
            // Seleccionar método actual
            this.classList.add('selected');
            radio.checked = true;
            
            // Mostrar formulario correspondiente
            const form = document.getElementById(methodType + '-form');
            if (form) {
                form.classList.add('active');
                
                // Generar QR si es Nequi
                if (methodType === 'nequi') {
                    setTimeout(generateNequiQR, 100);
                }
            }
            
            // Habilitar botón de envío
            submitBtn.disabled = false;
        });
    });
    
    // También manejar clicks en los radio buttons
    document.querySelectorAll('input[name="metodo"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const method = this.closest('.payment-method');
            if (method) {
                method.click();
            }
        });
    });
    
    // Debug: Agregar listener al formulario
    document.getElementById('paymentForm').addEventListener('submit', function(e) {
        console.log('Formulario enviado');
        console.log('Método seleccionado:', document.querySelector('input[name="metodo"]:checked')?.value);
        
        // Verificar si hay un método seleccionado
        if (!document.querySelector('input[name="metodo"]:checked')) {
            e.preventDefault();
            alert('Por favor selecciona un método de pago');
            return false;
        }
    });
});
</script>
@endsection
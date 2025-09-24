@extends('layouts.menu')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/carrito.css') }}">
@endpush

@section('content')

    <div class="main-content">
        <div class="container">
            <div class="breadcrumb">
                <a href="#">Inicio</a> <span>/</span> <a href="#">Menú</a> <span>/</span> <span>Carrito de Compras</span>
            </div>

            <div class="page-header">
                <h1 class="page-title"><i class="fas fa-shopping-cart"></i> Tu Carrito de Compras</h1>
                <p class="page-subtitle">Revisa tus productos antes de finalizar la compra.</p>
            </div>

            <div class="cart-layout">
                <div class="cart-section">
                    <div class="section-header">
                        <h2>Productos en el Carrito</h2>
                    </div>

                    @if(count($carrito) > 0)
                        @foreach($carrito as $id => $item)
                        <div class="cart-item" data-id="{{ $id }}">
                            <div class="item-image">
                                <img src="https://via.placeholder.com/80" alt="{{ $item['nombre'] }}">
                            </div>
                            <div class="item-details">
                                <h4>{{ $item['nombre'] }}</h4>
                                <p>Precio unitario: ${{ number_format($item['precio'], 2) }}</p>
                            </div>
                            <div class="item-price">${{ number_format($item['precio'] * $item['cantidad'], 2) }}</div>
                            <div class="quantity-controls">
                                <button class="quantity-btn" onclick="cambiarCantidad({{ $id }}, -1)">-</button>
                                <span class="quantity-display" id="cantidad-{{ $id }}">{{ $item['cantidad'] }}</span>
                                <button class="quantity-btn" onclick="cambiarCantidad({{ $id }}, 1)">+</button>
                            </div>
                            <button class="remove-item" data-id="{{ $id }}"><i class="fas fa-times"></i></button>
                        </div>
                        @endforeach
                    @endif

                    @if(count($carrito) == 0)
                    <div class="empty-cart">
                        <i class="fas fa-shopping-basket empty-cart-icon"></i>
                        <h3>Tu carrito está vacío</h3>
                        <p>Parece que aún no has añadido nada a tu carrito. ¡Explora nuestro menú y encuentra algo delicioso!</p>
                        <a href="{{ route('menu.index') }}" class="btn btn-primary"><i class="fas fa-utensils"></i> Ir al Menú</a>
                    </div>
                    @endif
                </div>

                <div class="summary-section">
                    <div class="order-summary">
                        <h3>Resumen del Pedido</h3>
                        <div class="summary-details">
                            <div class="summary-row">
                                <span>Subtotal</span>
                                <span id="subtotal">${{ number_format($total, 2) }}</span>
                            </div>
                            <div class="summary-row">
                                <span>Descuentos</span>
                                <span>-$0.00</span>
                            </div>
                            <div class="summary-row">
                                <span>Envío</span>
                                <span>$0.00</span>
                            </div>
                            <div class="summary-divider"></div>
                            <div class="summary-row total">
                                <span>Total</span>
                                <span id="total">${{ number_format($total, 2) }}</span>
                            </div>
                        </div>

                        <div class="coupon-section">
                            <h4>¿Tienes un código de descuento?</h4>
                            <div class="coupon-input">
                                <input type="text" placeholder="Introduce tu código">
                                <button class="apply-coupon-btn">Aplicar</button>
                            </div>
                        </div>

                        <div class="checkout-actions">
                            @if(count($carrito) > 0)
                                @if(auth()->check())
                                    <form action="{{ route('pedidos.store') }}" method="POST" style="margin-bottom: 1rem;">
                                        @csrf
                                        <button type="submit" class="checkout-btn">
                                            <i class="fas fa-check-circle"></i> Confirmar Pedido
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login', ['redirect' => 'carrito']) }}" class="checkout-btn" style="display: inline-block; text-align: center; margin-bottom: 1rem;">
                                        <i class="fas fa-sign-in-alt"></i> Inicia sesión para ordenar
                                    </a>
                                @endif
                                <form action="{{ route('carrito.vaciar') }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres vaciar el carrito?')">
                                    @csrf
                                    <button type="submit" class="cancel-btn" style="background-color: #dc3545; margin-bottom: 1rem;">
                                        <i class="fas fa-trash-alt"></i> Vaciar Carrito
                                    </button>
                                </form>
                            @endif
                        </div>
                        <a href="{{ route('menu.index') }}" class="btn btn-secondary" style="width: 100%; margin-top: 1rem;">
                            <i class="fas fa-arrow-left"></i> Seguir Comprando
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <!-- Payment Modal -->
    <div id="paymentModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Finalizar Pedido</h3>
                <span class="close-modal">&times;</span>
            </div>
            <div class="modal-body">
                <div class="modal-summary">
                    <h4 class="total-pagar">Total a Pagar: <span class="modal-total">${{ number_format($total, 2) }}</span></h4>
                </div>

                <h4 class="payment-title">Selecciona tu método de pago:</h4>
                <div class="payment-options">
                    <div class="payment-option selected" data-payment-method="cash">
                        <div class="payment-icon"><i class="fas fa-money-bill-wave"></i></div>
                        <div class="payment-info">
                            <h5>Efectivo</h5>
                            <p>Paga en efectivo al recibir tu pedido.</p>
                        </div>
                        <div class="payment-radio">
                            <input type="radio" id="radio-cash" name="payment-method" value="cash" checked>
                            <label for="radio-cash"></label>
                        </div>
                    </div>
                    <div class="payment-option" data-payment-method="pse">
                        <div class="payment-icon"><i class="fas fa-university"></i></div>
                        <div class="payment-info">
                            <h5>PSE</h5>
                            <p>Paga con tu cuenta bancaria a través de PSE.</p>
                        </div>
                        <div class="payment-radio">
                            <input type="radio" id="radio-pse" name="payment-method" value="pse">
                            <label for="radio-pse"></label>
                        </div>
                    </div>
                    <div class="payment-option" data-payment-method="nequi">
                        <div class="payment-icon"><i class="fas fa-mobile-alt"></i></div>
                        <div class="payment-info">
                            <h5>Nequi</h5>
                            <p>Paga fácilmente desde tu cuenta Nequi.</p>
                        </div>
                        <div class="payment-radio">
                            <input type="radio" id="radio-nequi" name="payment-method" value="nequi">
                            <label for="radio-nequi"></label>
                        </div>
                    </div>
                    <div class="payment-option" data-payment-method="daviplata">
                        <div class="payment-icon"><i class="fas fa-wallet"></i></div>
                        <div class="payment-info">
                            <h5>Daviplata</h5>
                            <p>Paga con tu Daviplata.</p>
                        </div>
                        <div class="payment-radio">
                            <input type="radio" id="radio-daviplata" name="payment-method" value="daviplata">
                            <label for="radio-daviplata"></label>
                        </div>
                    </div>
                    <div class="payment-option" data-payment-method="bancolombia">
                        <div class="payment-icon"><i class="fas fa-building"></i></div>
                        <div class="payment-info">
                            <h5>Bancolombia</h5>
                            <p>Transferencia directa a Bancolombia.</p>
                        </div>
                        <div class="payment-radio">
                            <input type="radio" id="radio-bancolombia" name="payment-method" value="bancolombia">
                            <label for="radio-bancolombia"></label>
                        </div>
                    </div>
                </div>

                <div class="payment-interfaces">
                    <!-- Cash Interface -->
                    <div id="cash-interface" class="payment-interface">
                        <div class="payment-header">
                            <i class="fas fa-money-bill-wave"></i>
                            <h4>Pago en Efectivo</h4>
                        </div>
                        <div class="payment-form">
                            <div class="form-group">
                                <label for="cash-amount-received">Monto recibido (opcional)</label>
                                <input type="number" id="cash-amount-received" placeholder="Ej: 20.00">
                                <small>Ingresa el monto que recibes para calcular el cambio.</small>
                            </div>
                            <div id="change-display" class="change-calculation" style="display: none;">
                                <p>Cambio: <strong>$5.00</strong></p>
                            </div>
                        </div>
                    </div>

                    <!-- PSE Interface -->
                    <div id="pse-interface" class="payment-interface" style="display: none;">
                        <div class="payment-header">
                            <i class="fas fa-university"></i>
                            <h4>Pago con PSE</h4>
                        </div>
                        <div class="payment-form">
                            <div class="form-group">
                                <label for="pse-bank">Selecciona tu banco</label>
                                <select id="pse-bank">
                                    <option value="">Selecciona un banco</option>
                                    <option value="bancolombia">Bancolombia</option>
                                    <option value="davivienda">Davivienda</option>
                                    <option value="bbva">BBVA</option>
                                    <!-- More banks -->
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="pse-document-type">Tipo de documento</label>
                                <select id="pse-document-type">
                                    <option value="cc">Cédula de Ciudadanía</option>
                                    <option value="ce">Cédula de Extranjería</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="pse-document-number">Número de documento</label>
                                <input type="text" id="pse-document-number" placeholder="Ej: 123456789">
                            </div>
                            <div class="form-group">
                                <label for="pse-email">Correo electrónico</label>
                                <input type="email" id="pse-email" placeholder="ejemplo@correo.com">
                            </div>
                        </div>
                    </div>

                    <!-- Nequi Interface -->
                    <div id="nequi-interface" class="payment-interface" style="display: none;">
                        <div class="payment-header">
                            <i class="fas fa-mobile-alt"></i>
                            <h4>Pago con Nequi</h4>
                        </div>
                        <div class="payment-form">
                            <div class="form-group">
                                <label for="nequi-phone">Número de teléfono Nequi</label>
                                <input type="tel" id="nequi-phone" placeholder="Ej: 3001234567">
                            </div>
                            <div class="payment-instructions">
                                <p>Instrucciones para pagar con Nequi:</p>
                                <ol>
                                    <li>Abre tu aplicación Nequi.</li>
                                    <li>Ve a "Envía" o "Paga".</li>
                                    <li>Ingresa el número de teléfono del restaurante (ej: 3001234567).</li>
                                    <li>Ingresa el monto total: <strong class="payment-amount-display">${{ number_format($total, 2) }}</strong></li>
                                    <li>Confirma la transacción.</li>
                                    <li>Una vez realizado el pago, haz clic en "Confirmar Pago".</li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <!-- Daviplata Interface -->
                    <div id="daviplata-interface" class="payment-interface" style="display: none;">
                        <div class="payment-header">
                            <i class="fas fa-wallet"></i>
                            <h4>Pago con Daviplata</h4>
                        </div>
                        <div class="payment-form">
                            <div class="form-group">
                                <label for="daviplata-phone">Número de teléfono Daviplata</label>
                                <input type="tel" id="daviplata-phone" placeholder="Ej: 3001234567">
                            </div>
                            <div class="form-group">
                                <label for="daviplata-pin">PIN Daviplata</label>
                                <input type="password" id="daviplata-pin" maxlength="4" placeholder="****">
                            </div>
                            <div class="payment-instructions">
                                <p>Instrucciones para pagar con Daviplata:</p>
                                <ol>
                                    <li>Abre tu aplicación Daviplata.</li>
                                    <li>Selecciona "Pagar" o "Enviar dinero".</li>
                                    <li>Ingresa el número de teléfono del restaurante (ej: 3001234567).</li>
                                    <li>Ingresa el monto total: <strong class="payment-amount-display">${{ number_format($total, 2) }}</strong></li>
                                    <li>Confirma la transacción con tu PIN.</li>
                                    <li>Una vez realizado el pago, haz clic en "Confirmar Pago".</li>
                                </ol>
                            </div>
                        </div>
                    </div>

                    <!-- Bancolombia Interface -->
                    <div id="bancolombia-interface" class="payment-interface" style="display: none;">
                        <div class="payment-header">
                            <i class="fas fa-building"></i>
                            <h4>Transferencia Bancolombia</h4>
                        </div>
                        <div class="payment-form">
                            <div class="bank-details">
                                <h5>Datos de la cuenta Bancolombia:</h5>
                                <div class="bank-info">
                                    <p><strong>Banco:</strong> Bancolombia</p>
                                    <p><strong>Tipo de Cuenta:</strong> Ahorros</p>
                                    <p><strong>Número de Cuenta:</strong> 123-456789-0</p>
                                    <p><strong>Titular:</strong> Restaurante S.A.S</p>
                                    <p><strong>NIT/CC:</strong> 900.123.456-7</p>
                                </div>
                            </div>
                            <div class="payment-instructions">
                                <p>Instrucciones para transferencia Bancolombia:</p>
                                <ol>
                                    <li>Realiza una transferencia al número de cuenta proporcionado.</li>
                                    <li>Asegúrate de que el monto sea exactamente: <strong class="payment-amount-display">${{ number_format($total, 2) }}</strong></li>
                                    <li>Guarda el comprobante de la transacción.</li>
                                    <li>Ingresa el número de referencia de tu transacción a continuación.</li>
                                </ol>
                            </div>
                            <div class="form-group">
                                <label for="bancolombia-reference">Número de Referencia de Transacción</label>
                                <input type="text" id="bancolombia-reference" placeholder="Ej: ABC123XYZ">
                                <small>Este número se encuentra en tu comprobante de transferencia.</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button class="btn btn-secondary close-modal">Cancelar</button>
                    <button class="btn btn-primary" id="confirmPaymentBtn">Confirmar Pago</button>
                </div>
                
                <div class="payment-confirmation">
                    <p class="payment-note"><i class="fas fa-info-circle"></i> Al confirmar el pago, aceptas nuestros términos y condiciones.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="successModal" class="modal">
        <div class="modal-content">
            <div class="success-content">
                <i class="fas fa-check-circle success-icon"></i>
                <h3>¡Pedido Realizado con Éxito!</h3>
                <p>Tu pedido ha sido recibido y está siendo procesado. ¡Gracias por tu compra!</p>
                <div class="order-details">
                    <p><strong>Número de Pedido:</strong> #ORD-20250917-001</p>
                    <p><strong>Total Pagado:</strong> $15.00</p>
                    <p><strong>Método de Pago:</strong> Efectivo</p>
                </div>
                <div class="success-actions">
                    <a href="#" class="btn btn-primary"><i class="fas fa-receipt"></i> Ver Recibo</a>
                    <a href="#" class="btn btn-secondary"><i class="fas fa-home"></i> Volver al Inicio</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
// Función para cambiar cantidad de productos
function cambiarCantidad(id, cambio) {
    const cantidadElement = document.getElementById('cantidad-' + id);
    let cantidadActual = parseInt(cantidadElement.textContent);
    let nuevaCantidad = cantidadActual + cambio;
    
    if (nuevaCantidad < 1) {
        if (confirm('¿Deseas eliminar este producto del carrito?')) {
            eliminarProducto(id);
        }
        return;
    }
    
    // Actualizar visualmente
    cantidadElement.textContent = nuevaCantidad;
    
    // Enviar actualización al servidor
    fetch('{{ route('carrito.actualizar') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            id: id,
            cantidad: nuevaCantidad
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error al actualizar el carrito');
            cantidadElement.textContent = cantidadActual;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        cantidadElement.textContent = cantidadActual;
    });
}

// Eliminar producto del carrito
document.querySelectorAll('.remove-item').forEach(button => {
    button.addEventListener('click', function() {
        const productId = this.getAttribute('data-id');
        eliminarProducto(productId);
    });
});

function eliminarProducto(id) {
    fetch('{{ route('carrito.eliminar') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            id: id
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('Error al eliminar el producto');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al eliminar el producto');
    });
}


</script>
@endpush



// Carrito JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Variables globales
    const paymentModal = document.getElementById('paymentModal');
    const successModal = document.getElementById('successModal');
    const checkoutBtn = document.querySelector('.checkout-btn');
    const closeModalBtns = document.querySelectorAll('.close-modal');
    const confirmPaymentBtn = document.getElementById('confirmPaymentBtn');
    const clearCartBtn = document.querySelector('.clear-cart-btn');
    
    // Abrir modal de pago
    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', function() {
            if (!this.disabled) {
                paymentModal.style.display = 'block';
            }
        });
    }
    
    // Cerrar modales
    closeModalBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            paymentModal.style.display = 'none';
            successModal.style.display = 'none';
        });
    });
    
    // Cerrar modal al hacer clic fuera
    window.addEventListener('click', function(event) {
        if (event.target === paymentModal) {
            paymentModal.style.display = 'none';
        }
        if (event.target === successModal) {
            successModal.style.display = 'none';
        }
    });
    
    // Manejo de métodos de pago
    const paymentOptions = document.querySelectorAll('.payment-option');
    const paymentInterfaces = document.querySelectorAll('.payment-interface');
    
    paymentOptions.forEach(option => {
        option.addEventListener('click', function() {
            // Remover selección anterior
            paymentOptions.forEach(opt => opt.classList.remove('selected'));
            
            // Seleccionar opción actual
            this.classList.add('selected');
            
            // Marcar radio button
            const radio = this.querySelector('input[type="radio"]');
            if (radio) radio.checked = true;
            
            // Mostrar interfaz correspondiente
            const method = this.dataset.paymentMethod;
            showPaymentInterface(method);
        });
    });
    
    function showPaymentInterface(method) {
        // Ocultar todas las interfaces
        paymentInterfaces.forEach(interface => {
            interface.style.display = 'none';
        });
        
        // Mostrar la interfaz seleccionada
        const targetInterface = document.getElementById(method + '-interface');
        if (targetInterface) {
            targetInterface.style.display = 'block';
        }
    }
    
    // Confirmar pago
    if (confirmPaymentBtn) {
        confirmPaymentBtn.addEventListener('click', function() {
            const selectedMethod = document.querySelector('input[name="payment-method"]:checked');
            if (selectedMethod) {
                // Simular procesamiento de pago
                processPayment(selectedMethod.value);
            }
        });
    }
    
    function processPayment(method) {
        // Aquí iría la lógica real de procesamiento de pago
        console.log('Procesando pago con método:', method);
        
        // Simular delay de procesamiento
        setTimeout(() => {
            paymentModal.style.display = 'none';
            successModal.style.display = 'block';
            
            // Limpiar carrito después del pago exitoso
            clearCart();
        }, 1500);
    }
    
    // Controles de cantidad
    const quantityBtns = document.querySelectorAll('.quantity-btn');
    quantityBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const action = this.dataset.action;
            const cartItem = this.closest('.cart-item');
            const quantityDisplay = cartItem.querySelector('.quantity-display');
            const itemId = cartItem.dataset.id;
            
            let currentQuantity = parseInt(quantityDisplay.textContent);
            
            if (action === 'increase') {
                currentQuantity++;
            } else if (action === 'decrease' && currentQuantity > 1) {
                currentQuantity--;
            }
            
            quantityDisplay.textContent = currentQuantity;
            updateItemTotal(cartItem, currentQuantity);
            updateCartTotals();
            
            // Animación de actualización
            quantityDisplay.style.animation = 'updateQuantity 0.3s ease';
            setTimeout(() => {
                quantityDisplay.style.animation = '';
            }, 300);
        });
    });
    
    // Remover items del carrito
    const removeItemBtns = document.querySelectorAll('.remove-item');
    removeItemBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const cartItem = this.closest('.cart-item');
            const itemId = this.dataset.id;
            
            // Animación de salida
            cartItem.style.animation = 'fadeOut 0.3s ease';
            setTimeout(() => {
                cartItem.remove();
                updateCartTotals();
                checkEmptyCart();
            }, 300);
        });
    });
    
    // Limpiar carrito completo
    if (clearCartBtn) {
        clearCartBtn.addEventListener('click', function() {
            if (confirm('¿Estás seguro de que quieres vaciar el carrito?')) {
                clearCart();
            }
        });
    }
    
    function clearCart() {
        const cartItems = document.querySelectorAll('.cart-item');
        cartItems.forEach(item => item.remove());
        updateCartTotals();
        checkEmptyCart();
    }
    
    function updateItemTotal(cartItem, quantity) {
        const priceElement = cartItem.querySelector('.item-price');
        const unitPrice = parseFloat(cartItem.dataset.unitPrice || 0);
        const newTotal = unitPrice * quantity;
        priceElement.textContent = '$' + newTotal.toFixed(2);
    }
    
    function updateCartTotals() {
        const cartItems = document.querySelectorAll('.cart-item');
        let subtotal = 0;
        
        cartItems.forEach(item => {
            const priceText = item.querySelector('.item-price').textContent;
            const price = parseFloat(priceText.replace('$', ''));
            subtotal += price;
        });
        
        document.getElementById('subtotal').textContent = '$' + subtotal.toFixed(2);
        document.getElementById('total').textContent = '$' + subtotal.toFixed(2);
        
        // Actualizar total en modal
        const modalTotals = document.querySelectorAll('.modal-total');
        modalTotals.forEach(total => {
            total.textContent = '$' + subtotal.toFixed(2);
        });
        
        // Actualizar montos en interfaces de pago
        const paymentAmountDisplays = document.querySelectorAll('.payment-amount-display');
        paymentAmountDisplays.forEach(display => {
            display.textContent = '$' + subtotal.toFixed(2);
        });
        
        // Habilitar/deshabilitar botón de checkout
        if (checkoutBtn) {
            checkoutBtn.disabled = subtotal === 0;
        }
    }
    
    function checkEmptyCart() {
        const cartItems = document.querySelectorAll('.cart-item');
        const cartSection = document.querySelector('.cart-section');
        
        if (cartItems.length === 0) {
            // Mostrar mensaje de carrito vacío
            const emptyCartHTML = `
                <div class="empty-cart">
                    <i class="fas fa-shopping-basket empty-cart-icon"></i>
                    <h3>Tu carrito está vacío</h3>
                    <p>Parece que aún no has añadido nada a tu carrito. ¡Explora nuestro menú y encuentra algo delicioso!</p>
                    <a href="/menu" class="btn btn-primary"><i class="fas fa-utensils"></i> Ir al Menú</a>
                </div>
            `;
            
            const sectionHeader = cartSection.querySelector('.section-header');
            sectionHeader.nextElementSibling.innerHTML = emptyCartHTML;
        }
    }
    
    // Cálculo de cambio para pago en efectivo
    const cashAmountInput = document.getElementById('cash-amount-received');
    const changeDisplay = document.getElementById('change-display');
    
    if (cashAmountInput) {
        cashAmountInput.addEventListener('input', function() {
            const amountReceived = parseFloat(this.value) || 0;
            const total = parseFloat(document.getElementById('total').textContent.replace('$', '')) || 0;
            
            if (amountReceived > total) {
                const change = amountReceived - total;
                changeDisplay.querySelector('strong').textContent = '$' + change.toFixed(2);
                changeDisplay.style.display = 'block';
            } else {
                changeDisplay.style.display = 'none';
            }
        });
    }
    
    // Aplicar cupón de descuento
    const applyCouponBtn = document.querySelector('.apply-coupon-btn');
    if (applyCouponBtn) {
        applyCouponBtn.addEventListener('click', function() {
            const couponInput = this.previousElementSibling;
            const couponCode = couponInput.value.trim();
            
            if (couponCode) {
                // Aquí iría la lógica para validar el cupón
                console.log('Aplicando cupón:', couponCode);
                
                // Ejemplo de aplicación de descuento
                applyCoupon(couponCode);
            }
        });
    }
    
    function applyCoupon(code) {
        // Simulación de cupones válidos
        const validCoupons = {
            'DESCUENTO10': 0.10,
            'BIENVENIDO': 0.15,
            'ESTUDIANTE': 0.05
        };
        
        if (validCoupons[code.toUpperCase()]) {
            const discount = validCoupons[code.toUpperCase()];
            const subtotal = parseFloat(document.getElementById('subtotal').textContent.replace('$', ''));
            const discountAmount = subtotal * discount;
            const newTotal = subtotal - discountAmount;
            
            // Actualizar display de descuento
            const discountRow = document.querySelector('.summary-row:nth-child(2) span:last-child');
            discountRow.textContent = '-$' + discountAmount.toFixed(2);
            
            // Actualizar total
            document.getElementById('total').textContent = '$' + newTotal.toFixed(2);
            
            // Mostrar mensaje de éxito
            showNotification('¡Cupón aplicado correctamente! Descuento: ' + (discount * 100) + '%');
        } else {
            showNotification('Cupón no válido', 'error');
        }
    }
    
    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        notification.className = `notification ${type}`;
        notification.textContent = message;
        
        // Estilos para la notificación
        notification.style.cssText = `
            position: fixed;
            top: 20px;
            right: 20px;
            background: ${type === 'success' ? '#51cf66' : '#ff6b6b'};
            color: white;
            padding: 15px 25px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 10000;
            animation: slideIn 0.3s ease-out;
        `;
        
        document.body.appendChild(notification);
        
        setTimeout(() => {
            notification.style.animation = 'slideOut 0.3s ease-out';
            setTimeout(() => {
                notification.remove();
            }, 300);
        }, 3000);
    }
    
    // Hamburger menu
    const hamburger = document.querySelector('.hamburger');
    const navMenu = document.querySelector('.nav-menu');
    
    if (hamburger) {
        hamburger.addEventListener('click', function() {
            this.classList.toggle('active');
            navMenu.classList.toggle('active');
        });
    }
    
    // Inicializar totales al cargar la página
    updateCartTotals();
});

// Animaciones CSS adicionales
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from {
            transform: translateX(100%);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOut {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(100%);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);
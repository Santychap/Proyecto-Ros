// Carrito JavaScript functionality
document.addEventListener('DOMContentLoaded', function() {
    // CSRF Token
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    // Elements
    const checkoutBtn = document.querySelector('.checkout-btn');
    const paymentModal = document.getElementById('paymentModal');
    const closeModalBtns = document.querySelectorAll('.close-modal');
    const paymentOptions = document.querySelectorAll('.payment-option');
    const paymentInterfaces = document.querySelectorAll('.payment-interface');
    const confirmPaymentBtn = document.getElementById('confirmPaymentBtn');
    const successModal = document.getElementById('successModal');
    const clearCartBtn = document.querySelector('.clear-cart-btn');
    const hamburger = document.querySelector('.hamburger');
    const navMenu = document.querySelector('.nav-menu');

    // Hamburger menu toggle
    if (hamburger && navMenu) {
        hamburger.addEventListener('click', function() {
            hamburger.classList.toggle('active');
            navMenu.classList.toggle('active');
        });
    }

    // Open payment modal
    if (checkoutBtn) {
        checkoutBtn.addEventListener('click', function() {
            if (!this.disabled) {
                paymentModal.style.display = 'block';
            }
        });
    }

    // Close modals
    closeModalBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            paymentModal.style.display = 'none';
            successModal.style.display = 'none';
        });
    });

    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        if (event.target === paymentModal) {
            paymentModal.style.display = 'none';
        }
        if (event.target === successModal) {
            successModal.style.display = 'none';
        }
    });

    // Payment method selection
    paymentOptions.forEach(option => {
        option.addEventListener('click', function() {
            // Remove selected class from all options
            paymentOptions.forEach(opt => opt.classList.remove('selected'));
            
            // Add selected class to clicked option
            this.classList.add('selected');
            
            // Check the radio button
            const radio = this.querySelector('input[type="radio"]');
            if (radio) {
                radio.checked = true;
            }
            
            // Show corresponding payment interface
            const method = this.dataset.paymentMethod;
            paymentInterfaces.forEach(interfaceDiv => {
                interfaceDiv.style.display = 'none';
            });
            
            const targetInterface = document.getElementById(`${method}-interface`);
            if (targetInterface) {
                targetInterface.style.display = 'block';
            }
        });
    });

    // Confirm payment
    if (confirmPaymentBtn) {
        confirmPaymentBtn.addEventListener('click', function() {
            // Here you would normally process the payment
            // For now, just show success modal
            paymentModal.style.display = 'none';
            successModal.style.display = 'block';
        });
    }

    // Clear cart
    if (clearCartBtn) {
        clearCartBtn.addEventListener('click', function() {
            if (confirm('¿Estás seguro de que quieres vaciar el carrito?')) {
                fetch('/carrito/eliminar', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ clear_all: true })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    location.reload();
                });
            }
        });
    }

    // Quantity controls
    document.querySelectorAll('.quantity-btn').forEach(button => {
        button.addEventListener('click', function() {
            const cartItem = this.closest('.cart-item');
            const productId = cartItem.dataset.id;
            const quantityDisplay = this.closest('.quantity-controls').querySelector('.quantity-display');
            let quantity = parseInt(quantityDisplay.textContent);
            const action = this.dataset.action;
            
            if (action === 'increase') {
                quantity++;
            } else if (action === 'decrease' && quantity > 1) {
                quantity--;
            } else {
                return; // Don't proceed if trying to decrease below 1
            }
            
            // Add loading state
            this.disabled = true;
            
            fetch('/carrito/actualizar', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ 
                    id: productId, 
                    cantidad: quantity 
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert('Error al actualizar la cantidad');
                    this.disabled = false;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error al actualizar la cantidad');
                this.disabled = false;
            });
        });
    });

    // Remove item
    document.querySelectorAll('.remove-item').forEach(button => {
        button.addEventListener('click', function() {
            if (confirm('¿Estás seguro de que quieres eliminar este producto?')) {
                const productId = this.dataset.id;
                
                // Add loading state
                this.disabled = true;
                
                fetch('/carrito/eliminar', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ id: productId })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error al eliminar el producto');
                        this.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error al eliminar el producto');
                    this.disabled = false;
                });
            }
        });
    });

    // Cash amount calculation
    const cashAmountInput = document.getElementById('cash-amount-received');
    const changeDisplay = document.getElementById('change-display');
    
    if (cashAmountInput && changeDisplay) {
        const totalAmount = parseFloat(document.querySelector('.modal-total').textContent.replace('$', '').replace(',', ''));
        
        cashAmountInput.addEventListener('input', function() {
            const received = parseFloat(this.value);
            if (!isNaN(received) && received >= totalAmount) {
                const change = received - totalAmount;
                changeDisplay.querySelector('strong').textContent = `$${change.toFixed(2)}`;
                changeDisplay.style.display = 'block';
            } else {
                changeDisplay.style.display = 'none';
            }
        });
    }

    // Coupon functionality
    const applyCouponBtn = document.querySelector('.apply-coupon-btn');
    if (applyCouponBtn) {
        applyCouponBtn.addEventListener('click', function() {
            const couponInput = document.querySelector('.coupon-input input');
            const couponCode = couponInput.value.trim();
            
            if (couponCode) {
                // Here you would send the coupon to the server for validation
                alert('Funcionalidad de cupón en desarrollo');
            } else {
                alert('Por favor ingresa un código de cupón');
            }
        });
    }
});
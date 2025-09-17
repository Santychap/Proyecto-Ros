// ===== SISTEMA DE CARRITO DE COMPRAS =====

const STORAGE_KEY = 'carritoOllaSazon';
const ENVIO_FIJO = 3000; // Costo de envío fijo

// Función para obtener el carrito desde localStorage
function obtenerCarrito() {
    try {
        return JSON.parse(localStorage.getItem(STORAGE_KEY)) || [];
    } catch (e) {
        console.error('Error al obtener carrito:', e);
        return [];
    }
}

// Función para guardar el carrito en localStorage
function guardarCarrito(carrito) {
    try {
        localStorage.setItem(STORAGE_KEY, JSON.stringify(carrito));
    } catch (e) {
        console.error('Error al guardar carrito:', e);
        mostrarNotificacion('Error al guardar cambios', 'error');
    }
}

// Función para agregar productos al carrito
function agregarAlCarrito(producto) {
    console.log('Agregando producto:', producto);
    
    if (!producto || !producto.nombre || !producto.precio) {
        console.error('Producto inválido:', producto);
        mostrarNotificacion('Error: Producto inválido', 'error');
        return;
    }

    const carrito = obtenerCarrito();
    const productoExistente = carrito.find(item => item.nombre === producto.nombre);
    
    if (productoExistente) {
        productoExistente.cantidad++;
    } else {
        carrito.push({
            nombre: producto.nombre,
            precio: Number(producto.precio),
            imagen: producto.imagen || 'imagenes/imagen-por-defecto.jpg',
            descripcion: producto.descripcion || '',
            cantidad: 1
        });
    }
    
    guardarCarrito(carrito);
    actualizarCarrito();
    mostrarNotificacion('¡Producto agregado al carrito!');
}

// Función para actualizar el contador del carrito
function actualizarContadorCarrito() {
    const contador = document.getElementById('cartCount');
    if(contador) {
        const carrito = obtenerCarrito();
        const total = carrito.reduce((sum, item) => sum + item.cantidad, 0);
        contador.textContent = total;
        contador.style.display = total > 0 ? 'block' : 'none';
    }
}

// Función para mostrar el contenido del carrito
function mostrarCarrito() {
    const contenedorCarrito = document.getElementById('cartItems');
    const emptyCart = document.getElementById('emptyCart');
    const checkoutBtn = document.getElementById('checkoutBtn');
    const carrito = obtenerCarrito();
    const template = document.getElementById('cart-item-template');
    
    if(!contenedorCarrito || !template) return;

    // Actualizar visibilidad del carrito vacío y botón de checkout
    if(carrito.length === 0) {
        if(emptyCart) emptyCart.style.display = 'block';
        if(contenedorCarrito) contenedorCarrito.style.display = 'none';
        if(checkoutBtn) checkoutBtn.disabled = true;
        actualizarTotal(0);
        return;
    }

    if(emptyCart) emptyCart.style.display = 'none';
    contenedorCarrito.style.display = 'block';
    if(checkoutBtn) checkoutBtn.disabled = false;

    // Crear un mapa de los elementos existentes para reutilizarlos
    const elementosExistentes = new Map();
    contenedorCarrito.querySelectorAll('.cart-item').forEach(item => {
        elementosExistentes.set(item.dataset.index, item);
    });

    // Limpiar solo los elementos que ya no existen en el carrito
    contenedorCarrito.querySelectorAll('.cart-item').forEach(item => {
        if (!carrito[item.dataset.index]) {
            item.remove();
        }
    });

    // Actualizar o agregar elementos
    carrito.forEach((item, index) => {
        let cartItem = elementosExistentes.get(index.toString());
        
        if (!cartItem) {
            // Crear nuevo elemento si no existe
            const clone = template.content.cloneNode(true);
            cartItem = clone.querySelector('.cart-item');
            cartItem.dataset.index = index;
            contenedorCarrito.appendChild(cartItem);
        }
        
        // Actualizar contenido
        const img = cartItem.querySelector('.item-image img');
        img.src = item.imagen;
        img.alt = item.nombre;
        img.onerror = () => { img.src = 'imagenes/imagen-por-defecto.jpg'; };
        
        cartItem.querySelector('.item-details h4').textContent = item.nombre;
        cartItem.querySelector('.item-description').textContent = item.descripcion || '';
        cartItem.querySelector('.item-price').textContent = `$${item.precio.toLocaleString()}`;
        
        const quantityDisplay = cartItem.querySelector('.quantity-display');
        if (quantityDisplay.textContent !== item.cantidad.toString()) {
            quantityDisplay.textContent = item.cantidad;
            // Animación de actualización
            quantityDisplay.style.animation = 'none';
            quantityDisplay.offsetHeight; // Forzar reflow
            quantityDisplay.style.animation = 'updateQuantity 0.3s ease';
        }
    });

    actualizarTotal();
}

// Función para cambiar la cantidad de un producto
function cambiarCantidad(index, cambio) {
    const carrito = obtenerCarrito();
    
    if (index < 0 || index >= carrito.length) {
        console.error('Índice de producto inválido:', index);
        return;
    }

    const nuevaCantidad = carrito[index].cantidad + cambio;
    
    if (nuevaCantidad <= 0) {
        // Animar la eliminación
        const itemElement = document.querySelector(`.cart-item[data-index="${index}"]`);
        if (itemElement) {
            itemElement.style.animation = 'slideOut 0.3s ease forwards';
            setTimeout(() => {
                carrito.splice(index, 1);
                guardarCarrito(carrito);
                actualizarCarrito();
            }, 300);
        }
    } else {
        // Actualizar cantidad con animación
        const displayElement = document.querySelector(`.cart-item[data-index="${index}"] .quantity-display`);
        if (displayElement) {
            displayElement.style.transform = 'scale(1.2)';
            displayElement.style.color = cambio > 0 ? '#4CAF50' : '#ff6b6b';
            setTimeout(() => {
                displayElement.style.transform = 'scale(1)';
                displayElement.style.color = '';
            }, 200);
        }
        
        carrito[index].cantidad = nuevaCantidad;
        guardarCarrito(carrito);
        actualizarCarrito();
    }
}

// Función para eliminar un producto del carrito
function eliminarDelCarrito(index) {
    const carrito = obtenerCarrito();
    
    if (index < 0 || index >= carrito.length) {
        console.error('Índice de producto inválido:', index);
        return;
    }

    carrito.splice(index, 1);
    guardarCarrito(carrito);
    actualizarCarrito();
    mostrarNotificacion('Producto eliminado del carrito');
}

// Función para calcular totales
function calcularTotales(carrito) {
    const subtotal = carrito.reduce((total, item) => total + (item.precio * item.cantidad), 0);
    const envio = carrito.length > 0 ? ENVIO_FIJO : 0;
    return {
        subtotal,
        envio,
        total: subtotal + envio
    };
}

// Función para actualizar la interfaz del carrito
function actualizarCarrito() {
    actualizarContadorCarrito();
    mostrarCarrito();
}

// Función para actualizar el total
function actualizarTotal() {
    const subtotalElement = document.getElementById('subtotal');
    const envioElement = document.getElementById('delivery');
    const totalElement = document.getElementById('total');
    const modalTotalElement = document.getElementById('modalTotal');
    
    if (!subtotalElement || !totalElement) return;

    const carrito = obtenerCarrito();
    const { subtotal, envio, total } = calcularTotales(carrito);

    subtotalElement.textContent = `$${subtotal.toLocaleString()}`;
    if (envioElement) envioElement.textContent = `$${envio.toLocaleString()}`;
    totalElement.textContent = `$${total.toLocaleString()}`;
    
    if (modalTotalElement) {
        modalTotalElement.textContent = `$${total.toLocaleString()}`;
    }
}

// Función para vaciar el carrito
function vaciarCarrito() {
    if (confirm('¿Estás seguro de que quieres vaciar el carrito?')) {
        guardarCarrito([]);
        actualizarCarrito();
        mostrarNotificacion('Carrito vaciado');
    }
}

// Función para mostrar notificaciones
function mostrarNotificacion(mensaje, tipo = 'info') {
    // Crear elemento de notificación
    const notificacion = document.createElement('div');
    notificacion.className = `notification ${tipo}`;
    notificacion.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        background-color: ${tipo === 'error' ? '#ff6b6b' : '#4CAF50'};
        color: white;
        padding: 15px 25px;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
        z-index: 1000;
        transform: translateX(100%);
        transition: transform 0.3s ease-out;
        display: flex;
        align-items: center;
        justify-content: space-between;
    `;
    
    notificacion.innerHTML = `
        <div class="notification-content">
            <span>${mensaje}</span>
            <button class="notification-close" style="background: none; border: none; color: white; font-size: 20px; cursor: pointer; margin-left: 15px;">&times;</button>
        </div>
    `;
    
    document.body.appendChild(notificacion);
    
    // Mostrar notificación con animación
    setTimeout(() => {
        notificacion.style.transform = 'translateX(0)';
    }, 100);

    // Auto-cerrar después de 3 segundos
    setTimeout(() => {
        notificacion.style.transform = 'translateX(100%)';
        setTimeout(() => {
            if (notificacion.parentNode) {
                notificacion.parentNode.removeChild(notificacion);
            }
        }, 300);
    }, 3000);

    // Cerrar al hacer clic en el botón
    const closeBtn = notificacion.querySelector('.notification-close');
    if (closeBtn) {
        closeBtn.addEventListener('click', () => {
            notificacion.style.transform = 'translateX(100%)';
            setTimeout(() => {
                if (notificacion.parentNode) {
                    notificacion.parentNode.removeChild(notificacion);
                }
            }, 300);
        });
    }
}

// Función para procesar el pago
function procesarPago() {
    const metodoPago = document.querySelector('input[name="paymentMethod"]:checked');
    const nombre = document.getElementById('customerName').value.trim();
    const telefono = document.getElementById('customerPhone').value.trim();
    const direccion = document.getElementById('customerAddress').value.trim();

    // Validaciones
    if (!metodoPago) {
        mostrarNotificacion('Selecciona un método de pago', 'error');
        return;
    }

    if (!nombre || !telefono || !direccion) {
        mostrarNotificacion('Completa todos los campos obligatorios', 'error');
        return;
    }

    // Simular procesamiento
    const btnConfirmar = document.getElementById('confirmPayment');
    if (btnConfirmar) {
        btnConfirmar.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Procesando...';
        btnConfirmar.disabled = true;
    }

    setTimeout(() => {
        completarPedido(metodoPago.value, {
            nombre,
            telefono,
            direccion,
            notas: document.getElementById('orderNotes')?.value.trim() || ''
        });
    }, 2000);
}

// Función para completar el pedido
function completarPedido(metodoPago, infoCliente) {
    const numeroOrden = 'OS' + Date.now().toString().slice(-6);
    const carrito = obtenerCarrito();
    const { total } = calcularTotales(carrito);

    // Mostrar modal de éxito
    const modalPago = document.getElementById('paymentModal');
    const modalExito = document.getElementById('successModal');
    if (modalPago) modalPago.style.display = 'none';
    
    if (modalExito) {
        const elementoNumeroOrden = document.getElementById('orderNumber');
        const elementoMontoTotal = document.getElementById('paidAmount');
        
        if (elementoNumeroOrden) elementoNumeroOrden.textContent = numeroOrden;
        if (elementoMontoTotal) elementoMontoTotal.textContent = `$${total.toLocaleString()}`;
        
        modalExito.style.display = 'block';
    }

    // Limpiar carrito
    guardarCarrito([]);
    actualizarCarrito();

    // Enviar datos al servidor (simulado)
    console.log('Pedido enviado:', {
        numeroOrden,
        items: carrito,
        total,
        metodoPago,
        infoCliente,
        fecha: new Date().toISOString()
    });

    // Resetear formulario
    resetearFormularioPago();
}

// Función para resetear el formulario de pago
function resetearFormularioPago() {
    ['customerName', 'customerPhone', 'customerAddress', 'orderNotes'].forEach(id => {
        const elemento = document.getElementById(id);
        if (elemento) elemento.value = '';
    });

    document.querySelectorAll('input[name="paymentMethod"]').forEach(radio => {
        if (radio) radio.checked = false;
    });

    document.querySelectorAll('.payment-option').forEach(opcion => {
        if (opcion) opcion.classList.remove('selected');
    });
    
    const btnConfirmar = document.getElementById('confirmPayment');
    if (btnConfirmar) {
        btnConfirmar.innerHTML = '<i class="fas fa-check"></i> Confirmar Pedido';
        btnConfirmar.disabled = false;
    }
}

// Funciones de prueba para desarrollo
function testAddItem() {
    agregarAlCarrito({
        nombre: 'Producto de Prueba',
        precio: 15000,
        imagen: 'imagenes/test-product.jpg',
        descripcion: 'Este es un producto de prueba para verificar el funcionamiento del carrito'
    });
}

function clearTestData() {
    if (confirm('¿Estás seguro de que quieres vaciar el carrito?')) {
        guardarCarrito([]);
        actualizarCarrito();
        mostrarNotificacion('Carrito vaciado');
    }
}

// Inicializar el carrito cuando se carga la página
document.addEventListener('DOMContentLoaded', () => {
    actualizarCarrito();

    // Configurar botón para vaciar carrito
    const btnVaciarCarrito = document.getElementById('clearCart');
    if (btnVaciarCarrito) {
        btnVaciarCarrito.addEventListener('click', vaciarCarrito);
    }

    // Configurar botón de checkout
    const btnCheckout = document.getElementById('checkoutBtn');
    if (btnCheckout) {
        btnCheckout.addEventListener('click', () => {
            const carrito = obtenerCarrito();
            if (carrito.length === 0) {
                mostrarNotificacion('El carrito está vacío', 'error');
                return;
            }
            const modal = document.getElementById('paymentModal');
            if (modal) {
                modal.style.display = 'block';
                actualizarTotal();
            }
        });
    }

    // Configurar botones de cerrar modal
    const closeButtons = document.querySelectorAll('.close-modal, #cancelPayment');
    closeButtons.forEach(button => {
        if (button) {
            button.addEventListener('click', () => {
                const modal = document.getElementById('paymentModal');
                if (modal) modal.style.display = 'none';
            });
        }
    });

    // Configurar evento para procesar pago
    const btnConfirmarPago = document.getElementById('confirmPayment');
    if (btnConfirmarPago) {
        btnConfirmarPago.addEventListener('click', procesarPago);
    }

    // Configurar validaciones de métodos de pago
    const inputsTelefono = document.querySelectorAll('.phone-input');
    inputsTelefono.forEach(input => {
        if (input) {
            input.addEventListener('input', (e) => {
                e.target.value = e.target.value.replace(/\D/g, '').substring(0, 10);
            });
        }
    });

    const opcionesPago = document.querySelectorAll('.payment-option');
    opcionesPago.forEach(opcion => {
        if (opcion) {
            opcion.addEventListener('click', () => {
                opcionesPago.forEach(opt => opt.classList.remove('selected'));
                opcion.classList.add('selected');
                const radio = opcion.querySelector('input[type="radio"]');
                if (radio) radio.checked = true;
            });
        }
    });
});
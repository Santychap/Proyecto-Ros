@extends('layouts.menu')

@section('title', 'Nuestro Menú - Olla y Sazón')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/menu.css') }}">
@endpush

@section('content')
<div class="menu-container">
    <!-- Título principal -->
    <h1 class="title-primary">
        <i class="fas fa-utensils"></i>
        Nuestro Exquisito Menú
    </h1>

    <!-- Filtros de categorías -->
    <div class="category-filters">
        <button class="category-btn active" data-category="all">
            <i class="fas fa-th-large"></i>
            Todos los Platos
        </button>
        <button class="category-btn" data-category="entradas">
            <i class="fas fa-leaf"></i>
            Entradas
        </button>
        <button class="category-btn" data-category="principales">
            <i class="fas fa-drumstick-bite"></i>
            Platos Principales
        </button>
        <button class="category-btn" data-category="postres">
            <i class="fas fa-ice-cream"></i>
            Postres
        </button>
        <button class="category-btn" data-category="bebidas">
            <i class="fas fa-cocktail"></i>
            Bebidas
        </button>
    </div>

    <!-- Grid de productos -->
    <div class="productos-grid" id="productos-grid">
        @forelse($productos as $producto)
            <div class="producto-card" data-category="{{ strtolower($producto->categoria->nombre ?? 'otros') }}" data-id="{{ $producto->id }}">
                <!-- Badge de categoría -->
                <div class="categoria-badge">
                    {{ $producto->categoria->nombre ?? 'Sin categoría' }}
                </div>

                <!-- Imagen del producto -->
                <div class="producto-image">
                    @if($producto->image && file_exists(public_path('storage/' . $producto->image)))
                        <img src="{{ asset('storage/' . $producto->image) }}" alt="{{ $producto->nombre }}" loading="lazy">
                    @else
                        <div class="no-image-placeholder">
                            <i class="fas fa-utensils"></i>
                            <span>{{ $producto->nombre }}</span>
                        </div>
                    @endif
                </div>

                <!-- Contenido del producto -->
                <div class="producto-content">
                    <h3 class="producto-name">{{ $producto->nombre }}</h3>
                    
                    @if($producto->descripcion)
                        <p class="producto-description">{{ $producto->descripcion }}</p>
                    @endif

                    @if($producto->ingredientes)
                        <p class="producto-ingredientes">
                            <i class="fas fa-list-ul"></i>
                            {{ $producto->ingredientes }}
                        </p>
                    @endif

                    <!-- Footer del producto -->
                    <div class="producto-footer">
                        <div class="producto-price">
                            ${{ number_format($producto->precio, 2) }}
                        </div>
                    </div>

                    <!-- Botón de compra -->
                    @auth
                        @if(auth()->user()->rol === 'cliente')
                            <button class="comprar-btn" onclick="agregarAlCarrito({{ $producto->id }}, '{{ $producto->nombre }}', {{ $producto->precio }})">
                                <i class="fas fa-cart-plus"></i>
                                Agregar al Carrito
                            </button>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="comprar-btn">
                            <i class="fas fa-sign-in-alt"></i>
                            Inicia Sesión para Ordenar
                        </a>
                    @endauth
                </div>
            </div>
        @empty
            <div class="empty-state" style="grid-column: 1 / -1;">
                <i class="fas fa-utensils"></i>
                <h3>No hay productos disponibles</h3>
                <p>Estamos trabajando en actualizar nuestro menú. Vuelve pronto para ver nuestras deliciosas opciones.</p>
            </div>
        @endforelse
    </div>

    <!-- Información adicional -->
    <div class="menu-info card">
        <div class="grid grid-3">
            <div class="info-item text-center">
                <i class="fas fa-clock" style="font-size: 2rem; color: var(--color-primary); margin-bottom: var(--spacing-sm);"></i>
                <h4 class="title-secondary">Horarios de Cocina</h4>
                <p>Lunes a Domingo<br>12:00 PM - 10:00 PM</p>
            </div>
            <div class="info-item text-center">
                <i class="fas fa-truck" style="font-size: 2rem; color: var(--color-primary); margin-bottom: var(--spacing-sm);"></i>
                <h4 class="title-secondary">Delivery Gratis</h4>
                <p>En pedidos mayores a $25<br>Tiempo estimado: 30-45 min</p>
            </div>
            <div class="info-item text-center">
                <i class="fas fa-award" style="font-size: 2rem; color: var(--color-primary); margin-bottom: var(--spacing-sm);"></i>
                <h4 class="title-secondary">Calidad Garantizada</h4>
                <p>Ingredientes frescos<br>Preparación artesanal</p>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmación -->
<div id="cartModal" class="modal" style="display: none;">
    <div class="modal-content">
        <div class="modal-header">
            <h3><i class="fas fa-check-circle"></i> ¡Producto Agregado!</h3>
            <span class="close-modal">&times;</span>
        </div>
        <div class="modal-body text-center">
            <p id="modalMessage">El producto ha sido agregado a tu carrito exitosamente.</p>
            <div class="modal-actions" style="margin-top: var(--spacing-lg); display: flex; gap: var(--spacing-sm); justify-content: center;">
                <button class="btn btn-secondary close-modal">Seguir Comprando</button>
                <a href="{{ route('carrito.index') }}" class="btn btn-primary">
                    <i class="fas fa-shopping-cart"></i> Ver Carrito
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Filtros de categorías
    const categoryBtns = document.querySelectorAll('.category-btn');
    const productCards = document.querySelectorAll('.producto-card');

    categoryBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const category = this.dataset.category;
            
            // Actualizar botón activo
            categoryBtns.forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            // Filtrar productos con animación
            productCards.forEach(card => {
                const cardCategory = card.dataset.category;
                
                if (category === 'all' || cardCategory === category) {
                    card.style.display = 'block';
                    card.style.animation = 'fadeIn 0.5s ease-in';
                } else {
                    card.style.animation = 'fadeOut 0.3s ease-out';
                    setTimeout(() => {
                        card.style.display = 'none';
                    }, 300);
                }
            });
        });
    });

    // Modal functionality
    const modal = document.getElementById('cartModal');
    const closeButtons = document.querySelectorAll('.close-modal');
    
    closeButtons.forEach(btn => {
        btn.addEventListener('click', function() {
            modal.style.display = 'none';
        });
    });

    // Cerrar modal al hacer clic fuera
    window.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });

    // Animaciones de entrada
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animation = 'slideInUp 0.6s ease-out';
            }
        });
    });

    productCards.forEach(card => {
        observer.observe(card);
    });
});

// Función para agregar al carrito
function agregarAlCarrito(id, nombre, precio) {
    const formData = new FormData();
    formData.append('producto_id', id);
    formData.append('_token', document.querySelector('meta[name="csrf-token"]').getAttribute('content'));
    
    fetch('/carrito/agregar', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Producto agregado al carrito');
            // Actualizar contador
            const cartCount = document.querySelector('.cart-count');
            if (cartCount) {
                cartCount.textContent = data.cartCount;
            }
        } else {
            alert('Error: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al agregar producto');
    });
}
</script>

<style>
/* Animaciones adicionales */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

@keyframes fadeOut {
    from { opacity: 1; transform: translateY(0); }
    to { opacity: 0; transform: translateY(-20px); }
}

@keyframes slideInUp {
    from { opacity: 0; transform: translateY(50px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Modal styles */
.modal {
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.8);
    display: flex;
    align-items: center;
    justify-content: center;
}

.modal-content {
    background: var(--bg-glass);
    border-radius: var(--border-radius-medium);
    max-width: 500px;
    width: 90%;
    box-shadow: var(--shadow-large);
    border: 2px solid var(--color-primary);
    animation: modalSlideIn 0.3s ease-out;
}

@keyframes modalSlideIn {
    from { opacity: 0; transform: scale(0.8) translateY(-50px); }
    to { opacity: 1; transform: scale(1) translateY(0); }
}

.modal-header {
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-light) 100%);
    color: var(--text-dark);
    padding: var(--spacing-md);
    border-radius: var(--border-radius-medium) var(--border-radius-medium) 0 0;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.modal-header h3 {
    margin: 0;
    font-size: var(--font-size-lg);
    font-weight: 600;
}

.close-modal {
    background: none;
    border: none;
    font-size: var(--font-size-xl);
    cursor: pointer;
    color: var(--text-dark);
    font-weight: bold;
    padding: 0;
    width: 30px;
    height: 30px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: all var(--transition-normal);
}

.close-modal:hover {
    background: rgba(0, 0, 0, 0.1);
}

.modal-body {
    padding: var(--spacing-lg);
    color: var(--text-light);
}

.menu-info {
    margin-top: var(--spacing-xl);
}

.info-item h4 {
    color: var(--color-primary);
    margin-bottom: var(--spacing-sm);
}

.info-item p {
    color: var(--text-muted);
    line-height: 1.6;
}

.no-image-placeholder {
    width: 100%;
    height: 200px;
    background: linear-gradient(135deg, var(--color-primary) 0%, var(--color-primary-light) 100%);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: #000;
    font-weight: 600;
    text-align: center;
    padding: 1rem;
}

.no-image-placeholder i {
    font-size: 3rem;
    margin-bottom: 0.5rem;
}

.no-image-placeholder span {
    font-size: 1rem;
    max-width: 100%;
    word-wrap: break-word;
}
</style>
@endpush
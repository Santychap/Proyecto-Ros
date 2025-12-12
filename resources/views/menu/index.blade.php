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
        <button class="category-btn active" data-category="all" style="margin-right: 0.5rem;">
            <i class="fas fa-th-large"></i>
            Todos los Platos
        </button>
        @foreach($categorias as $categoria)
            <button class="category-btn" data-category="{{ strtolower($categoria->nombre) }}" style="margin-right: 0.5rem;">
                @if(strtolower($categoria->nombre) == 'bebidas')
                    <i class="fas fa-cocktail"></i>
                @elseif(strtolower($categoria->nombre) == 'postres')
                    <i class="fas fa-ice-cream"></i>
                @elseif(str_contains(strtolower($categoria->nombre), 'plato'))
                    <i class="fas fa-drumstick-bite"></i>
                @elseif(strtolower($categoria->nombre) == 'aperitivos')
                    <i class="fas fa-leaf"></i>
                @else
                    <i class="fas fa-utensils"></i>
                @endif
                {{ $categoria->nombre }}
            </button>
        @endforeach
    </div>

    <!-- Grid de productos -->
    <div class="productos-grid" id="productos-grid" style="display: grid !important; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)) !important; gap: 2rem !important; margin-bottom: 2.5rem !important;">
        @forelse($productos as $producto)
            <div class="producto-card @if($producto->stock === 0) agotado @endif" data-category="{{ strtolower($producto->categoria->nombre ?? 'otros') }}" data-id="{{ $producto->id }}">
                <!-- Imagen del producto -->
                <div class="producto-image">
                    @if($producto->image)
                        <img src="{{ asset('storage/' . $producto->image) }}" alt="{{ $producto->nombre }}" loading="lazy">
                    @else
                        <div class="no-image-placeholder">
                            <i class="fas fa-image"></i>
                            <span>Sin imagen</span>
                        </div>
                    @endif
                    <span class="categoria-badge">{{ $producto->categoria->nombre ?? 'Otros' }}</span>
                </div>
                <!-- Contenido del producto -->
                <div class="producto-content">
                    <div class="producto-name">{{ $producto->nombre }}</div>
                    <div class="producto-description">{{ $producto->descripcion }}</div>
                    @if($producto->ingredientes)
                        <div class="ingredientes-toggle">
                            <button class="btn-ingredientes" onclick="toggleIngredientes({{ $producto->id }})">
                                <i class="fas fa-list"></i> Ver ingredientes
                            </button>
                            <div class="producto-ingredientes" id="ingredientes-{{ $producto->id }}" style="display: none;">
                                {{ $producto->ingredientes }}
                            </div>
                        </div>
                    @endif
                </div>
                <!-- Footer con precio y botón -->
                <div class="producto-footer">
                    <div class="producto-price">${{ number_format($producto->precio, 2) }}</div>
                    @if($producto->stock === 0)
                        <button class="comprar-btn agotado-btn" disabled>
                            <i class="fas fa-times"></i> Agotado
                        </button>
                    @else
                        <button class="comprar-btn" onclick="agregarAlCarrito({{ $producto->id }}, '{{ addslashes($producto->nombre) }}', {{ $producto->precio }})">
                            <i class="fas fa-cart-plus"></i> Agregar
                        </button>
                    @endif
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
                <a href="{{ route('carrito.mostrar') }}" class="btn btn-primary">
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

// Función para mostrar/ocultar ingredientes
function toggleIngredientes(id) {
    const ingredientes = document.getElementById('ingredientes-' + id);
    const btn = event.target.closest('.btn-ingredientes');
    const icon = btn.querySelector('i');
    
    if (ingredientes.style.display === 'none') {
        ingredientes.style.display = 'block';
        btn.innerHTML = '<i class="fas fa-eye-slash"></i> Ocultar ingredientes';
    } else {
        ingredientes.style.display = 'none';
        btn.innerHTML = '<i class="fas fa-list"></i> Ver ingredientes';
    }
}

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
    background: #000000 !important;
    border: 3px solid #ffd700 !important;
    box-shadow: 0 0 20px rgba(255, 215, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.8) inset !important;
}

.info-item h4 {
    color: var(--color-primary);
    margin-bottom: var(--spacing-sm);
}

.info-item p {
    color: #cccccc !important;
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

/* Estilos mejorados para las tarjetas */
.producto-card {
    background: #000000 !important;
    border: 3px solid #ffd700 !important;
    border-radius: 15px;
    overflow: hidden;
    box-shadow: 0 0 20px rgba(255, 215, 0, 0.3), 0 0 40px rgba(0, 0, 0, 0.8) inset !important;
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
    height: 100%;
}

.producto-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 0 30px rgba(255, 215, 0, 0.5), 0 0 40px rgba(0, 0, 0, 0.8) inset !important;
}

.producto-image {
    position: relative;
    height: 200px;
    overflow: hidden;
}

.producto-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.producto-card:hover .producto-image img {
    transform: scale(1.05);
}

.categoria-badge {
    position: absolute;
    top: 10px;
    right: 10px;
    background: rgba(255, 215, 0, 0.9);
    color: #000;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
}

.producto-content {
    padding: 15px;
    flex: 1;
    display: flex;
    flex-direction: column;
}

.producto-name {
    font-size: 1.2rem;
    font-weight: 700;
    color: #ffffff !important;
    margin-bottom: 8px;
}

.producto-description {
    color: #cccccc !important;
    font-size: 0.9rem;
    line-height: 1.4;
    margin-bottom: 10px;
    flex: 1;
}

.ingredientes-toggle {
    margin-top: auto;
}

.btn-ingredientes {
    background: none;
    border: 1px solid #ddd;
    color: #666;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 0.8rem;
    cursor: pointer;
    transition: all 0.3s ease;
    width: 100%;
    margin-bottom: 8px;
}

.btn-ingredientes:hover {
    background: #f8f9fa;
    border-color: #ffd700;
    color: #333;
}

.producto-ingredientes {
    background: #f8f9fa;
    padding: 10px;
    border-radius: 8px;
    font-size: 0.8rem;
    color: #555;
    line-height: 1.3;
    margin-top: 8px;
    border-left: 3px solid #ffd700;
}

.producto-footer {
    padding: 15px;
    border-top: 1px solid rgba(255, 215, 0, 0.3);
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: rgba(0, 0, 0, 0.8) !important;
}

.producto-price {
    font-size: 1.3rem;
    font-weight: 700;
    color: #ffd700;
}

.comprar-btn {
    background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
    color: #000;
    border: none;
    padding: 8px 16px;
    border-radius: 20px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    font-size: 0.9rem;
    display: flex;
    align-items: center;
    gap: 5px;
}

.comprar-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(255, 215, 0, 0.4);
}

.agotado-btn {
    background: #ccc !important;
    color: #666 !important;
    cursor: not-allowed !important;
}

.agotado-btn:hover {
    transform: none !important;
    box-shadow: none !important;
}
</style>
@endpush
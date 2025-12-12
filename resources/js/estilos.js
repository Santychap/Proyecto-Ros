
const hamburger = document.querySelector('.hamburger');
const navMenu = document.querySelector('.nav-menu');

if (hamburger && navMenu) {
    hamburger.addEventListener('click', () => {
        hamburger.classList.toggle('active');
        navMenu.classList.toggle('active');
    });
}

// Smooth scrolling for navigation links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
            target.scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        }
    });
});

// Close mobile menu when clicking on a link
document.querySelectorAll('.nav-link').forEach(link => {
    link.addEventListener('click', () => {
        if (hamburger && navMenu) {
            hamburger.classList.remove('active');
            navMenu.classList.remove('active');
        }
    });
});

// Menu category filtering
const categoryButtons = document.querySelectorAll('.category-btn');
const menuCards = document.querySelectorAll('.menu-card');

categoryButtons.forEach(button => {
    button.addEventListener('click', () => {
        // Remove active class from all buttons
        categoryButtons.forEach(btn => btn.classList.remove('active'));
        // Add active class to clicked button
        button.classList.add('active');

        const category = button.getAttribute('data-category');

        menuCards.forEach(card => {
            if (category === 'all' || card.getAttribute('data-category') === category) {
                card.style.display = 'block';
                card.style.animation = 'fadeInUp 0.6s ease-out';
            } else {
                card.style.display = 'none';
            }
        });
    });
});

// Ingredients tooltip functionality - MEJORADO
document.addEventListener('DOMContentLoaded', function() {
    const ingredientsButtons = document.querySelectorAll('.ingredients-btn');
    
    ingredientsButtons.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            e.stopPropagation();
            
            // Buscar el tooltip asociado (puede ser el siguiente elemento o dentro del contenedor)
            let tooltip = btn.nextElementSibling;
            if (!tooltip || !tooltip.classList.contains('ingredients-tooltip')) {
                tooltip = btn.parentElement.querySelector('.ingredients-tooltip');
            }
            
            if (!tooltip) {
                console.log('No se encontró tooltip para este botón');
                return;
            }

            // Hide all other tooltips
            document.querySelectorAll('.ingredients-tooltip').forEach(t => {
                if (t !== tooltip) {
                    t.style.opacity = '0';
                    t.style.visibility = 'hidden';
                }
            });

            // Toggle current tooltip
            const isVisible = tooltip.style.opacity === '1' || 
                            getComputedStyle(tooltip).opacity === '1';
            
            if (isVisible) {
                tooltip.style.opacity = '0';
                tooltip.style.visibility = 'hidden';
            } else {
                tooltip.style.opacity = '1';
                tooltip.style.visibility = 'visible';
            }
        });
    });

    // Close tooltips when clicking outside
    document.addEventListener('click', (e) => {
        if (!e.target.closest('.ingredients-btn') && !e.target.closest('.ingredients-tooltip')) {
            document.querySelectorAll('.ingredients-tooltip').forEach(tooltip => {
                tooltip.style.opacity = '0';
                tooltip.style.visibility = 'hidden';
            });
        }
    });
});

// Buy button functionality
document.querySelectorAll('.buy-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const dishTitle = btn.closest('.menu-card').querySelector('.dish-title').textContent;
        const dishPrice = btn.closest('.menu-card').querySelector('.dish-price').textContent;
        
        // Simple alert for demo - you can replace this with actual cart functionality
        alert(`¡${dishTitle} agregado al carrito!\nPrecio: ${dishPrice}`);
        
        // Add visual feedback
        btn.style.background = 'linear-gradient(135deg, #28a745 0%, #20c997 100%)';
        btn.innerHTML = '<span class="cart-icon">✓</span>Agregado';
        
        setTimeout(() => {
            btn.style.background = 'linear-gradient(135deg,#ff0000 0%, #00d9ff8a 100%)';
            btn.innerHTML = '<span class="cart-icon">🛒</span>Comprar';
        }, 6000);
    });
});

// Debug function to check if elements exist
function debugTooltips() {
    console.log('Botones de ingredientes encontrados:', document.querySelectorAll('.ingredients-btn').length);
    console.log('Tooltips encontrados:', document.querySelectorAll('.ingredients-tooltip').length);
    
    document.querySelectorAll('.ingredients-btn').forEach((btn, index) => {
        const tooltip = btn.nextElementSibling || btn.parentElement.querySelector('.ingredients-tooltip');
        console.log(`Botón ${index + 1}:`, btn, 'Tooltip asociado:', tooltip);
    });
}

// Llamar a la función debug (puedes comentar esta línea en producción)
// debugTooltips();
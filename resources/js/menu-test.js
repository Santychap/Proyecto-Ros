// Función de prueba para agregar un producto
function testAddProduct() {
    const testProduct = {
        id: 'test-product',
        name: 'Producto de Prueba',
        price: 15000,
        image: 'imagenes/default-dish.jpg',
        description: 'Este es un producto de prueba'
    };
    
    addToCart(testProduct);
    console.log('Producto de prueba agregado al carrito');
    console.log('Estado actual del carrito:', JSON.parse(localStorage.getItem('cartItems')));
}

// Función para verificar el carrito
function checkCart() {
    const cartItems = JSON.parse(localStorage.getItem('cartItems')) || [];
    console.log('Contenido actual del carrito:', cartItems);
    return cartItems;
}

// Función para limpiar el carrito de prueba
function clearTestCart() {
    localStorage.removeItem('cartItems');
    console.log('Carrito limpiado');
}

// Agregar al window para acceso global
window.testAddProduct = testAddProduct;
window.checkCart = checkCart;
window.clearTestCart = clearTestCart;

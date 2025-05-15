document.addEventListener('DOMContentLoaded', function() {
    // Limpiar el carrito después de completar la compra
    localStorage.removeItem('cart');
    
    // Actualizar el contador del carrito
    const badge = document.getElementById('cart-count-badge');
    if (badge) {
        badge.style.display = 'none';
    }
});

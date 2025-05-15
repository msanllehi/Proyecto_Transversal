// Checkout.js - Maneja la funcionalidad de la página de checkout

// Definición de imágenes de productos
const PRODUCT_IMAGES = {
    '1': 'https://images.unsplash.com/photo-1504674900247-0877df9cc836',
    '2': 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0',
    '3': 'https://images.unsplash.com/photo-1600565193348-f74bd3c7ccdf?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
    '4': 'https://plus.unsplash.com/premium_photo-1667899297624-dd0a246b1384?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
    '5': 'https://images.unsplash.com/photo-1498837167922-ddd27525d352?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
    '6': 'https://images.unsplash.com/photo-1563599175592-c58dc214deff?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'
};

document.addEventListener('DOMContentLoaded', function() {
    // Asignar imágenes a window para mantener compatibilidad
    window.PRODUCT_IMAGES = PRODUCT_IMAGES;
    
    // Cargar el resumen del carrito
    loadCartSummary();
    
    // Manejar el envío del formulario
    setupCheckoutForm();
});

// Carga el resumen del carrito desde localStorage
function loadCartSummary() {
    const cartSummaryContainer = document.getElementById('cart-summary');
    const cartTotalElement = document.getElementById('cart-total');
    
    if (!cartSummaryContainer || !cartTotalElement) return;
    
    // Obtener carrito del localStorage
    const cart = JSON.parse(localStorage.getItem('cart')) || [];
    
    if (cart.length === 0) {
        // Redirigir si el carrito está vacío
        window.location.href = '/cart';
        return;
    }
    
    // Limpiar el contenedor
    cartSummaryContainer.innerHTML = '';
    
    // Calcular total
    let total = 0;
    
    // Crear un campo oculto para enviar los items del carrito al servidor
    const cartItemsInput = document.createElement('input');
    cartItemsInput.type = 'hidden';
    cartItemsInput.name = 'cart_items';
    cartItemsInput.value = JSON.stringify(cart);
    document.getElementById('checkout-form').appendChild(cartItemsInput);
    
    // Mostrar cada item
    cart.forEach(item => {
        const itemTotal = parseFloat(item.price) * item.quantity;
        total += itemTotal;
        
        const itemElement = document.createElement('div');
        itemElement.className = 'py-3 flex justify-between';
        
        // Usar la imagen del producto si está disponible
        const imgSrc = window.PRODUCT_IMAGES && window.PRODUCT_IMAGES[item.id] 
            ? window.PRODUCT_IMAGES[item.id] 
            : 'https://via.placeholder.com/50x50?text=Producto';
        
        itemElement.innerHTML = `
            <div class="flex items-center gap-3">
                <img src="${imgSrc}" alt="${item.name}" class="w-12 h-12 object-cover rounded-lg">
                <div>
                    <p class="font-medium">${item.name}</p>
                    <p class="text-sm text-gray-500">${item.quantity} x ${parseFloat(item.price).toFixed(2)} €</p>
                </div>
            </div>
            <div class="font-medium self-center">${(itemTotal).toFixed(2)} €</div>
        `;
        
        cartSummaryContainer.appendChild(itemElement);
    });
    
    // Actualizar el total
    cartTotalElement.textContent = total.toFixed(2) + ' €';
}

// Configura el formulario de checkout
function setupCheckoutForm() {
    const form = document.getElementById('checkout-form');
    const sameAsShippingCheckbox = document.getElementById('same_as_shipping');
    const billingFields = document.getElementById('billing_fields');
    
    if (!form || !sameAsShippingCheckbox || !billingFields) return;
    
    // Mostrar/ocultar campos de facturación
    sameAsShippingCheckbox.addEventListener('change', function() {
        if (this.checked) {
            billingFields.classList.add('hidden');
            // Desactivar validación para campos de facturación
            document.querySelectorAll('#billing_fields input').forEach(input => {
                input.required = false;
            });
        } else {
            billingFields.classList.remove('hidden');
            // Activar validación para campos de facturación
            document.querySelectorAll('#billing_fields input').forEach(input => {
                input.required = true;
            });
        }
    });

    // Formatear número de tarjeta
    const cardNumberInput = document.getElementById('card_number');
    if (cardNumberInput) {
        cardNumberInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 16) value = value.slice(0, 16);
            
            // Formatear con espacios cada 4 dígitos
            let formattedValue = '';
            for (let i = 0; i < value.length; i++) {
                if (i > 0 && i % 4 === 0) formattedValue += ' ';
                formattedValue += value[i];
            }
            
            e.target.value = formattedValue;
        });
        
        // Validar que el número de tarjeta tenga 16 dígitos
        cardNumberInput.addEventListener('blur', function() {
            const digitsOnly = this.value.replace(/\D/g, '');
            if (digitsOnly.length < 16) {
                this.setCustomValidity('El número de tarjeta debe tener 16 dígitos');
            } else {
                this.setCustomValidity('');
            }
        });
    }

    // Formatear fecha de caducidad
    const cardExpiryInput = document.getElementById('card_expiry');
    if (cardExpiryInput) {
        cardExpiryInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 4) value = value.slice(0, 4);
            
            if (value.length > 2) {
                e.target.value = value.slice(0, 2) + '/' + value.slice(2);
            } else {
                e.target.value = value;
            }
        });
        
        // Validar formato MM/YY y que la fecha no sea pasada
        cardExpiryInput.addEventListener('blur', function() {
            const value = this.value;
            const regex = /^(0[1-9]|1[0-2])\/([0-9]{2})$/;
            
            if (!regex.test(value)) {
                this.setCustomValidity('Formato inválido. Use MM/AA');
                return;
            }
            
            const parts = value.split('/');
            const month = parseInt(parts[0], 10);
            const year = parseInt('20' + parts[1], 10);
            
            const now = new Date();
            const currentYear = now.getFullYear();
            const currentMonth = now.getMonth() + 1; // getMonth() devuelve 0-11
            
            if (year < currentYear || (year === currentYear && month < currentMonth)) {
                this.setCustomValidity('La tarjeta ha caducado');
            } else {
                this.setCustomValidity('');
            }
        });
    }

    // Formatear CVV
    const cardCvvInput = document.getElementById('card_cvv');
    if (cardCvvInput) {
        cardCvvInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 3) value = value.slice(0, 3);
            e.target.value = value;
        });
        
        // Validar que el CVV tenga exactamente 3 dígitos
        cardCvvInput.addEventListener('blur', function() {
            if (this.value.length < 3) {
                this.setCustomValidity('El CVV debe tener 3 dígitos');
            } else {
                this.setCustomValidity('');
            }
        });
    }
    
    // Manejar envío del formulario
    form.addEventListener('submit', function(e) {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        
        if (cart.length === 0) {
            e.preventDefault();
            alert('Tu carrito está vacío');
            window.location.href = '/cart';
            return;
        }
        
        // Si todo está bien, el formulario se enviará normalmente y después de procesar el pedido, se limpiará el carrito
    });
}

// Limpiar carrito después de completar la compra
function clearCart() {
    localStorage.removeItem('cart');
}

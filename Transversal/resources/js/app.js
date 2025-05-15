import './bootstrap';

// --- 
// 
// --- IMÁGENES POR ID DE PRODUCTO ---
const PRODUCT_IMAGES = {
    '1': 'https://images.unsplash.com/photo-1504674900247-0877df9cc836',
    '2': 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0',
    '3': 'https://images.unsplash.com/photo-1600565193348-f74bd3c7ccdf?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
    '4': 'https://plus.unsplash.com/premium_photo-1667899297624-dd0a246b1384?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
    '5': 'https://images.unsplash.com/photo-1498837167922-ddd27525d352?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
    '6': 'https://images.unsplash.com/photo-1563599175592-c58dc214deff?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D'
};

// --- NOTIFICACIONES ---
function showNotify(message, type = 'success') {
    let notify = document.createElement('div');
    notify.className = `fixed bottom-8 right-8 z-50 min-w-[220px] max-w-xs px-6 py-4 rounded-xl shadow-2xl text-white font-semibold text-base transition-all duration-300 flex items-center gap-3 opacity-0`;
    notify.style.background = type === 'success'
        ? 'linear-gradient(90deg, #22c55e 0%, #4ade80 100%)'
        : 'linear-gradient(90deg, #ef4444 0%, #f87171 100%)';
    notify.innerHTML = `
        <span class="inline-flex items-center justify-center rounded-full bg-white/20 p-2">
            ${type === 'success'
                ? '<svg class=\'w-6 h-6 text-white\' fill=\'none\' stroke=\'currentColor\' stroke-width=\'2\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' d=\'M5 13l4 4L19 7\'/></svg>'
                : '<svg class=\'w-6 h-6 text-white\' fill=\'none\' stroke=\'currentColor\' stroke-width=\'2\' viewBox=\'0 0 24 24\'><path stroke-linecap=\'round\' stroke-linejoin=\'round\' d=\'M6 18L18 6M6 6l12 12\'/></svg>'}
        </span>
        <span>${message}</span>
    `;
    document.body.appendChild(notify);
    setTimeout(() => { notify.classList.add('opacity-100'); }, 50);
    setTimeout(() => {
        notify.classList.remove('opacity-100');
        setTimeout(() => notify.remove(), 400);
    }, 2200);
}

function updateCartBadge() {
    const badge = document.getElementById('cart-count-badge');
    if (!badge) return;
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    if (cart.length === 0) {
        badge.style.display = 'none';
    } else {
        badge.textContent = cart.length;
        badge.style.display = 'flex';
    }
}

function addToCart(product) {
    showNotify(`¡${product.name} añadido al carrito!`);
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    const exists = cart.some(item => item.id === product.id);
    
    if (exists) {
        return;
    }
    
    cart.push({ ...product, quantity: 1 });
    localStorage.setItem('cart', JSON.stringify(cart));
    updateCartBadge();
}

function removeFromCart(productId) {
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    const index = cart.findIndex(item => item.id === productId);
    if (index !== -1) {
        const removed = cart[index];
        cart.splice(index, 1);
        localStorage.setItem('cart', JSON.stringify(cart));
        renderCart();
        showNotify(`${removed.name} ha sido eliminado del carrito`, 'error');
        updateCartBadge();
    }
}

function renderCart() {
    const cartContainer = document.getElementById('cart-items');
    const cartEmpty = document.getElementById('cart-empty');
    if (!cartContainer) return;
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    cartContainer.innerHTML = '';
    if (cart.length === 0) {
        if (cartEmpty) cartEmpty.style.display = 'block';
        updateCartBadge();
        return;
    } else {
        if (cartEmpty) cartEmpty.style.display = 'none';
    }
    let total = 0;
    cart.forEach(item => {
        total += parseFloat(item.price);
        const li = document.createElement('li');
        li.className = 'py-4';
        const imgSrc = PRODUCT_IMAGES[item.id] || 'https://via.placeholder.com/80x80?text=Curso';
        li.innerHTML = `
            <div class="flex items-start gap-4">
                <img src="${imgSrc}" alt="${item.name}" class="w-20 h-20 object-cover rounded-xl shadow-md border border-orange-100">
                <div class="flex-1">
                    <span class="block font-semibold text-lg text-gray-800">${item.name}</span>
                </div>
            </div>
            <div class="flex items-center justify-between w-full mt-3 pl-0 sm:pl-24">
                <span class="text-orange-600 font-bold text-lg">${parseFloat(item.price).toFixed(2)}€</span>
                <button class='remove-from-cart bg-red-500 hover:bg-red-600 text-white py-2 px-3 rounded-md transition' data-id='${item.id}'>Quitar</button>
            </div>
        `;
        cartContainer.appendChild(li);
    });
    // Total
    const totalLi = document.createElement('li');
    totalLi.className = 'flex justify-end items-center pt-4 border-t border-orange-100 mt-4';
    totalLi.innerHTML = `<span class=\"text-xl sm:text-2xl font-bold text-green-600\">Total: ${total.toFixed(2)}€</span>`;
    cartContainer.appendChild(totalLi);
    
    // Actualizar visibilidad del botón de checkout
    const checkoutBtn = document.getElementById('checkout-btn');
    if (checkoutBtn) {
        checkoutBtn.style.display = cart.length > 0 ? 'flex' : 'none';
    }

    document.querySelectorAll('.remove-from-cart').forEach(btn => {
        btn.addEventListener('click', function() {
            const productId = this.getAttribute('data-id');
            removeFromCart(productId);
        });
    });
    updateCartBadge();
}

document.addEventListener('DOMContentLoaded', function() {
    // Funcionalidad de carrito
    document.querySelectorAll('.add-to-cart').forEach(btn => {
        btn.addEventListener('click', function() {
            const product = {
                id: this.getAttribute('data-id'),
                name: this.getAttribute('data-name'),
                price: this.getAttribute('data-price')
            };
            addToCart(product);
        });
    });
    renderCart();
    updateCartBadge();
    
    // Funcionalidad del menú móvil
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
        
        // Cerrar menú al hacer clic en un enlace
        mobileMenu.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', function() {
                mobileMenu.classList.add('hidden');
            });
        });
        
        // Sincronizar badge del carrito móvil
        const mobileBadge = document.getElementById('mobile-cart-count-badge');
        if (mobileBadge) {
            let cart = JSON.parse(localStorage.getItem('cart')) || [];
            if (cart.length === 0) {
                mobileBadge.style.display = 'none';
            } else {
                mobileBadge.textContent = cart.length;
                mobileBadge.style.display = 'flex';
            }
        }
    }
});

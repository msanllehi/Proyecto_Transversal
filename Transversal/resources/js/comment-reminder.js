/**
 * Sistema de recordatorios de comentarios para productos comprados
 * 
 * Este script muestra un modal con productos pendientes de comentar:
 * 1. Al iniciar sesión
 * 2. Al completar una compra
 */

document.addEventListener('DOMContentLoaded', function() {
    console.log('Inicializando sistema de recordatorios de comentarios');
    
    // Solo ejecutar si el usuario está autenticado
    if (!document.body.classList.contains('user-authenticated')) {
        console.log('Usuario no autenticado, no se muestra modal');
        return;
    }
    
    // Definir variables comunes
    const isUserAuthenticated = document.body.classList.contains('user-authenticated');
    const isHomePage = window.location.pathname === '/' || 
                       window.location.pathname === '/home' || 
                       window.location.pathname === '/dashboard';
    const isOrderConfirmation = window.location.pathname.includes('/checkout/confirmation');
    const urlParams = new URLSearchParams(window.location.search);
    
    console.log('¿El usuario está autenticado?', isUserAuthenticated);
    console.log('¿Estamos en la página principal?', isHomePage);
    console.log('¿Estamos en la página de confirmación?', isOrderConfirmation);
    
    // Evitar mostrar el modal si venimos de comentar un producto
    if (urlParams.get('commenting')) {
        console.log('Usuario acaba de comentar un producto, no mostrar modal');
        return;
    }
    
    // Caso 1: Página de confirmación de compra
    if (isOrderConfirmation) {
        console.log('Página de confirmación de compra detectada');
        // Marcar que hay que mostrar el modal al volver al home
        sessionStorage.setItem('show_comments_after_purchase', 'true');
        return;
    }
    
    // Caso 2: Volviendo a home después de una compra
    if (isHomePage && sessionStorage.getItem('show_comments_after_purchase') === 'true') {
        console.log('Volviendo a home después de una compra, mostrando el modal...');
        fetchAndShowComments();
        // Limpiar para que no se muestre varias veces
        sessionStorage.removeItem('show_comments_after_purchase');
        return;
    }
    
    // Caso 3: Inicio de sesión normal
    if (isUserAuthenticated && isHomePage) {
        // SOLUCIÓN SIMPLIFICADA: 
        // En lugar de intentar detectar si venimos del login, vamos a implementar una solución
        // que aprovecha el almacenamiento local para recordar si ya mostramos el modal o no
        
        // Obtenemos la fecha y hora actual
        const now = new Date().getTime();
        
        // Intentar obtener la última vez que se mostró el modal en esta sesión del navegador
        const lastModalShow = sessionStorage.getItem('modal_last_shown_at');
        const userIdentifier = sessionStorage.getItem('user_identifier');
        
        // Obtener un identificador para el usuario actual (puede ser cualquier información disponible)
        // Por ejemplo, elementos en la página que contengan el nombre de usuario, ID, etc.
        const currentUserIdentifier = document.querySelector('.user-name')?.textContent.trim() || 
                                     document.querySelector('[data-user-id]')?.dataset.userId || 
                                     Math.random().toString(); // Fallback aleatorio
        
        // Diagnóstico
        console.log('Usuario actual:', currentUserIdentifier);
        console.log('Usuario anterior:', userIdentifier);
        console.log('Última vez que se mostró el modal:', lastModalShow ? new Date(parseInt(lastModalShow)).toLocaleString() : 'Nunca');
        
        // Verificar si es la primera vez para este usuario o si el usuario ha cambiado
        const isFirstTimeOrUserChanged = !lastModalShow || (userIdentifier !== currentUserIdentifier);
        
        // Verificar si han pasado al menos 2 segundos desde la última vez
        // (esto es para evitar mostrar el modal varias veces si la página se recarga rápidamente)
        const hasTimeElapsed = !lastModalShow || (now - parseInt(lastModalShow)) > 2000;
        
        if (isFirstTimeOrUserChanged && hasTimeElapsed) {
            console.log('Se mostrará el modal para este usuario');
            
            // Actualizar la información del usuario y la última vez que se mostró el modal
            sessionStorage.setItem('user_identifier', currentUserIdentifier);
            sessionStorage.setItem('modal_last_shown_at', now.toString());
            
            // Mostrar el modal
            fetchAndShowComments();
            return;
        }
        
        console.log('No se mostrará el modal para este usuario en esta sesión');
        return;
    }
    
    // Si estamos en la página principal (home o dashboard) y no hemos mostrado el modal en esta sesión
    if (isHomePage) {
        const modalShown = sessionStorage.getItem('comment_modal_shown');
        if (!modalShown) {
            console.log('Página inicial detectada y modal no mostrado anteriormente');
            sessionStorage.setItem('comment_modal_shown', 'true');
            fetchAndShowComments();
        } else {
            console.log('Modal ya mostrado en esta sesión');
        }
    }
});

/**
 * Realiza una petición AJAX para obtener y mostrar productos pendientes de comentar
 */
function fetchAndShowComments() {
    console.log('Obteniendo productos pendientes de comentar...');

    // Mostrar indicador de carga
    const loadingIndicator = document.createElement('div');
    loadingIndicator.id = 'comment-loading';
    loadingIndicator.className = 'fixed top-4 right-4 bg-orange-500 text-white p-3 rounded-lg z-50';
    loadingIndicator.innerHTML = 'Cargando recordatorio de comentarios...';
    document.body.appendChild(loadingIndicator);
    
    fetch('/comment-reminders', {
        method: 'GET',
        headers: {
            'Accept': 'application/json'
        }
    })
    .then(response => {
        // Eliminar indicador de carga
        const loadingEl = document.getElementById('comment-loading');
        if (loadingEl) loadingEl.remove();
        
        if (!response.ok) {
            throw new Error(`Error del servidor: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Datos de comentarios recibidos:', data);
        
        // Verificar si hay items para comentar
        if (data && data.items && data.items.length > 0) {
            console.log('Hay', data.items.length, 'productos pendientes de comentar');
            showCommentModal(data.items);
        } else {
            console.log('No hay productos pendientes de comentar');
        }
    })
    .catch(error => {
        console.error('Error al cargar comentarios pendientes:', error);
    });
}

/**
 * Muestra un modal con los productos pendientes de comentar
 * @param {Array} items - Lista de productos pendientes de comentar
 */
function showCommentModal(items) {
    console.log('Mostrando modal con', items.length, 'productos pendientes de comentar');

    if (!items || items.length === 0) {
        console.log('No hay productos para mostrar');
        return;
    }
    
    // Crear el modal si no existe
    if (!document.getElementById('comment-reminder-modal')) {
        createCommentModal();
    }
    
    // Obtener el modal y la lista de productos
    const modal = document.getElementById('comment-reminder-modal');
    const productsList = document.getElementById('products-to-comment');
    if (!modal || !productsList) {
        console.error('No se pudo encontrar el modal o la lista de productos');
        return;
    }
    
    // Limpiar la lista de productos
    productsList.innerHTML = '';
    
    // Añadir cada producto a la lista
    items.forEach(item => {
        // Validar que el item tenga todas las propiedades necesarias
        if (!item.id || !item.product_name) {
            console.warn('Item incompleto:', item);
            return;
        }
        
        const productElement = document.createElement('div');
        productElement.className = 'flex flex-col sm:flex-row items-start sm:items-center gap-3 mb-4 p-3 border rounded-lg bg-white';
        productElement.dataset.itemId = item.id;
        
        // Usar imagen por defecto si no hay imagen del producto
        const productImage = item.product_image || '/img/default-product.jpg';
        
        productElement.innerHTML = `
            <img src="${productImage}" alt="${item.product_name}" class="w-16 h-16 object-cover rounded-md">
            <div class="flex-grow">
                <h4 class="font-semibold text-gray-800 text-sm md:text-base">${item.product_name}</h4>
                <p class="text-xs md:text-sm text-gray-600">Comprado el: ${item.order_date || 'Fecha no disponible'}</p>
            </div>
            <div class="flex flex-wrap gap-2 w-full sm:w-auto mt-2 sm:mt-0">
                <button class="comment-action flex-1 sm:flex-none px-2 sm:px-3 py-1 text-xs md:text-sm bg-orange-500 text-white rounded-md hover:bg-orange-600 transition" data-decision="comment">
                    Comentar
                </button>
                <button class="comment-action flex-1 sm:flex-none px-2 sm:px-3 py-1 text-xs md:text-sm bg-gray-200 text-black font-medium rounded-md hover:bg-gray-300 transition dark:bg-gray-600 dark:text-white" data-decision="skip">
                    No comentar
                </button>
                <button class="comment-action flex-1 sm:flex-none px-2 sm:px-3 py-1 text-xs md:text-sm bg-gray-300 text-black font-medium rounded-md hover:bg-gray-400 transition dark:bg-gray-500 dark:text-white" data-decision="postpone">
                    Más tarde
                </button>
            </div>
        `;
        
        productsList.appendChild(productElement);
    });
    
    // Mostrar el modal
    modal.classList.remove('hidden');
    
    // Añadir manejadores de eventos para los botones de acción
    addCommentActionHandlers();
}

/**
 * Crea el modal para los recordatorios de comentarios
 */
function createCommentModal() {
    console.log('Creando modal de recordatorio de comentarios');
    
    // Verificar si el modal ya existe para evitar duplicados
    if (document.getElementById('comment-reminder-modal')) {
        console.log('El modal ya existe, no se creará uno nuevo');
        return;
    }
    
    const modalHTML = `
        <div id="comment-reminder-modal" class="fixed inset-0 flex items-center justify-center z-[9999] bg-transparent hidden">
            <div class="bg-white rounded-lg shadow-xl w-full mx-4 md:mx-auto md:max-w-xl max-h-[90vh] md:max-h-[80vh] overflow-auto">
                <div class="p-4 md:p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-lg md:text-xl font-semibold text-gray-900">¿Deseas comentar tus compras recientes?</h3>
                        <button id="close-comment-modal" class="text-gray-500 hover:text-gray-700">
                            <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    <p class="text-sm md:text-base text-gray-600 mb-4">Tus opiniones son importantes para nosotros y otros usuarios. Puedes elegir comentar ahora, no comentar o dejarlo para más tarde.</p>
                    <div id="products-to-comment" class="space-y-4 mb-4">
                        <!-- Aquí se insertarán los productos pendientes de comentar -->
                    </div>
                </div>
            </div>
        </div>
    `;
    
    // Añadir el modal al final del body
    document.body.insertAdjacentHTML('beforeend', modalHTML);
    
    // Añadir manejador para cerrar el modal
    document.getElementById('close-comment-modal').addEventListener('click', function() {
        document.getElementById('comment-reminder-modal').classList.add('hidden');
    });
    
    // Cerrar el modal al hacer clic fuera de él
    document.getElementById('comment-reminder-modal').addEventListener('click', function(event) {
        if (event.target === this) {
            this.classList.add('hidden');
        }
    });
    
    console.log('Modal creado correctamente');
}

/**
 * Añade manejadores de eventos a los botones de acción de comentarios
 */
function addCommentActionHandlers() {
    console.log('Añadiendo manejadores de eventos a los botones');
    
    try {
        // Obtener todos los botones
        const buttons = document.querySelectorAll('.comment-action');
        console.log(`Encontrados ${buttons.length} botones de acción`);
        
        if (buttons.length === 0) {
            console.warn('No se encontraron botones de acción para añadir manejadores');
            return;
        }
        
        // Añadir manejadores a cada botón
        buttons.forEach(button => {
            // Eliminar cualquier event listener previo clonando el botón
            const newButton = button.cloneNode(true);
            button.parentNode.replaceChild(newButton, button);
            
            // Agregar el nuevo event listener al botón clonado
            newButton.addEventListener('click', function(event) {
                event.preventDefault();
                
                // Obtener datos del botón y del producto
                const decision = this.dataset.decision;
                const itemElement = this.closest('[data-item-id]');
                
                if (!itemElement) {
                    console.error('No se pudo encontrar el elemento del producto');
                    return;
                }
                
                const itemId = itemElement.dataset.itemId;
                console.log(`Botón pulsado: ${this.textContent.trim()} (${decision}) para el item ${itemId}`);
                
                // Mostrar estado de carga en el botón
                const originalText = this.textContent.trim();
                this.innerHTML = '<span class="animate-spin">⌛</span> Procesando...';
                this.disabled = true;
                
                // Enviar la decisión al servidor
                processCommentDecision(itemId, decision, this, originalText);
            });
        });
        
        console.log('Manejadores de eventos añadidos correctamente');
    } catch (error) {
        console.error('Error al añadir manejadores de eventos:', error);
    }
}

/**
 * Procesa la decisión del usuario sobre si quiere comentar un producto
 * @param {number} itemId - ID del item del pedido
 * @param {string} decision - Decisión tomada (comment, skip, postpone)
 * @param {HTMLElement} button - Botón que se ha pulsado
 * @param {string} originalText - Texto original del botón
 */
function processCommentDecision(itemId, decision, button, originalText) {
    console.log(`Procesando decisión "${decision}" para el item ${itemId}`);
    
    // Obtener el token CSRF
    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
    if (!csrfToken) {
        console.error('No se pudo obtener el token CSRF');
        showAlert('Error: No se pudo obtener el token CSRF', 'error');
        resetButton(button, originalText);
        return;
    }
    
    // Realizar la petición al servidor
    fetch(`/comment-reminders/${itemId}/decision`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
        },
        body: JSON.stringify({ decision })
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`Error del servidor: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Respuesta recibida:', data);
        
        if (data.success) {
            // Si hay redirección, navegar a la página de producto
            if (data.redirect) {
                window.location.href = data.redirect;
                return;
            }
            
            // Eliminar el producto de la lista
            const productElement = document.querySelector(`[data-item-id="${itemId}"]`);
            if (productElement) {
                productElement.remove();
            }
            
            // Si no quedan productos, cerrar el modal
            const remainingProducts = document.querySelectorAll('#products-to-comment > div').length;
            if (remainingProducts === 0) {
                document.getElementById('comment-reminder-modal')?.classList.add('hidden');
            }
            
            // Mostrar mensaje de éxito
            if (data.message) {
                showAlert(data.message, 'success');
            }
        } else {
            showAlert(data.message || 'Ha ocurrido un error al procesar tu decisión', 'error');
            resetButton(button, originalText);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showAlert(`Error: ${error.message}`, 'error');
        resetButton(button, originalText);
    });
}

/**
 * Restaura el estado original de un botón después de un error
 * @param {HTMLElement} button - El botón a restaurar
 * @param {string} originalText - Texto original del botón
 */
function resetButton(button, originalText) {
    if (button && originalText) {
        button.innerHTML = originalText;
        button.disabled = false;
    }
}

/**
 * Muestra una notificación al usuario
 * @param {string} message - Mensaje a mostrar
 * @param {string} type - Tipo de notificación (success, error, warning, info)
 */
function showAlert(message, type = 'info') {
    console.log(`Mostrando notificación: ${message} (${type})`);
    
    // Usar la función global showNotify si está disponible
    if (typeof window.showNotify === 'function') {
        let title = '';
        let icon = '';
        
        switch (type) {
            case 'success':
                title = 'Éxito';
                icon = 'success';
                break;
            case 'error':
                title = 'Error';
                icon = 'error';
                break;
            case 'warning':
                title = 'Atención';
                icon = 'warning';
                break;
            default:
                title = 'Información';
                icon = 'info';
        }
        
        window.showNotify(title, message, icon);
    } else {
        // Crear una notificación personalizada similar a la del carrito
        createToast(message, type);
    }
}

/**
 * Crea una notificación tipo toast (similar a la del carrito)
 * @param {string} message - Mensaje a mostrar
 * @param {string} type - Tipo de notificación (success, error, warning, info)
 */
function createToast(message, type = 'info') {
    // Eliminar notificaciones anteriores si existen
    const existingToasts = document.querySelectorAll('.comment-toast');
    existingToasts.forEach(toast => toast.remove());
    
    // Crear el elemento toast
    const toast = document.createElement('div');
    // Posicionamos el toast en la parte inferior, centrado, y con un z-index muy alto
    toast.className = `comment-toast fixed bottom-8 right-8 p-4 rounded-lg shadow-lg z-[9999] animate-fade-in`;
    // El margen adicional y z-index alto aseguran que no interfiera con otros elementos
    
    // Definir color según el tipo
    let bgColor, textColor, icon;
    switch (type) {
        case 'success':
            bgColor = 'bg-green-500';
            textColor = 'text-white';
            icon = `<svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>`;
            break;
        case 'error':
            bgColor = 'bg-red-500';
            textColor = 'text-white';
            icon = `<svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>`;
            break;
        case 'warning':
            bgColor = 'bg-yellow-500';
            textColor = 'text-white';
            icon = `<svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>`;
            break;
        default: // info
            bgColor = 'bg-blue-500';
            textColor = 'text-white';
            icon = `<svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>`;
    }
    
    toast.classList.add(bgColor, textColor);
    
    // Contenido del toast
    toast.innerHTML = `
        <div class="flex items-center">
            ${icon}
            <span>${message}</span>
        </div>
        <button class="absolute top-1 right-1 text-white" onclick="this.parentNode.remove()">
            &times;
        </button>
    `;
    
    // Añadir al DOM
    document.body.appendChild(toast);
    
    // Eliminar después de 5 segundos
    setTimeout(() => {
        if (toast.parentNode) {
            toast.classList.add('animate-fade-out');
            setTimeout(() => toast.remove(), 500);
        }
    }, 5000);
}

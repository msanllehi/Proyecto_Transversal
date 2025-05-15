// Esperar a que el DOM esté completamente cargado
document.addEventListener('DOMContentLoaded', initUserMenu);

// También intentar inicializar inmediatamente
initUserMenu();

function initUserMenu() {
    // Buscar los elementos del menú de usuario
    const userMenu = document.getElementById('userMenu');
    const userMenuButton = document.getElementById('userMenuButton');
    const userMenuDropdown = document.getElementById('userMenuDropdown');
    
    // Si no existen los elementos necesarios, salir
    if (!userMenu || !userMenuButton || !userMenuDropdown) {
        console.log('No se encontraron todos los elementos del menú de usuario');
        return;
    }
    
    console.log('Inicializando menú de usuario');
    
    let timeoutId;
    
    // Mostrar el menú al hacer hover en el botón
    userMenuButton.addEventListener('mouseenter', function() {
        clearTimeout(timeoutId);
        userMenuDropdown.classList.remove('hidden');
    });
    
    // Mantener el menú visible cuando el cursor está sobre el menú desplegable
    userMenuDropdown.addEventListener('mouseenter', function() {
        clearTimeout(timeoutId);
    });
    
    // Ocultar el menú con un retraso cuando el cursor sale del botón o del menú
    userMenu.addEventListener('mouseleave', function() {
        timeoutId = setTimeout(function() {
            userMenuDropdown.classList.add('hidden');
        }, 500); // 500ms de retraso antes de ocultar
    });
    
    // También mostrar/ocultar al hacer clic (para dispositivos táctiles)
    userMenuButton.addEventListener('click', function(e) {
        e.preventDefault();
        userMenuDropdown.classList.toggle('hidden');
    });
    
    // Cerrar el menú al hacer clic fuera
    document.addEventListener('click', function(e) {
        if (!userMenu.contains(e.target)) {
            userMenuDropdown.classList.add('hidden');
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    // Ajustar el padding superior en dispositivos móviles
    if (window.innerWidth <= 768) {
        const formContainer = document.querySelector('.bg-white');
        if (formContainer) {
            formContainer.classList.add('pt-16');
        }
    }

    // Volver a verificar el tamaño cuando se redimensiona la ventana
    window.addEventListener('resize', function() {
        const formContainer = document.querySelector('.bg-white');
        if (formContainer) {
            if (window.innerWidth <= 768) {
                formContainer.classList.add('pt-16');
            } else {
                formContainer.classList.remove('pt-16');
            }
        }
    });
});

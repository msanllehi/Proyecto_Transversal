document.addEventListener('DOMContentLoaded', function () {
    const fullName = document.getElementById('fullName');
    if (fullName) {
        fullName.addEventListener('input', function () {
            let names = this.value.split(' ');
            let formattedName = names.map(name => name.charAt(0).toUpperCase() + name.slice(1).toLowerCase()).join(' ');
            this.value = formattedName;
        });
    }

    const birthDate = document.getElementById('birthDate');
    if (birthDate) {
        birthDate.addEventListener('input', function () {
            let value = this.value;
            // Formatear automáticamente la fecha mientras el usuario escribe
            if (value.length > 0) {
                // Eliminar caracteres no numéricos
                value = value.replace(/[^0-9]/g, '');
                
                // Formatear como DD/MM/YYYY
                if (value.length > 2 && value.length <= 4) {
                    value = value.substring(0, 2) + '/' + value.substring(2);
                } else if (value.length > 4) {
                    value = value.substring(0, 2) + '/' + value.substring(2, 4) + '/' + value.substring(4, 8);
                }
                
                this.value = value;
                
                // Validar formato DD/MM/YYYY
                if (value.length === 10) {
                    const parts = value.split('/');
                    const day = parseInt(parts[0], 10);
                    const month = parseInt(parts[1], 10) - 1; // Los meses en JS van de 0 a 11
                    const year = parseInt(parts[2], 10);
                    
                    const birthDateObj = new Date(year, month, day);
                    const today = new Date();
                    
                    // Verificar que la fecha sea válida
                    const isValidDate = birthDateObj.getDate() === day && 
                                       birthDateObj.getMonth() === month && 
                                       birthDateObj.getFullYear() === year;
                    
                    if (!isValidDate) {
                        this.setCustomValidity('La fecha no es válida');
                        return;
                    }
                    
                    // Calcular edad
                    let age = today.getFullYear() - birthDateObj.getFullYear();
                    if (today.getMonth() < birthDateObj.getMonth() || 
                        (today.getMonth() === birthDateObj.getMonth() && today.getDate() < birthDateObj.getDate())) {
                        age--;
                    }
                    
                    if (age < 18 || age > 100) {
                        this.setCustomValidity('Debes tener entre 18 y 100 años para registrarte.');
                    } else {
                        this.setCustomValidity('');
                    }
                }
            }
        });
    }

    // Manejar la visibilidad de los campos de facturación
    const sameBillingAddress = document.getElementById('same_billing_address');
    if (sameBillingAddress) {
        const billingFields = document.getElementById('billing_fields');
        
        // Función para actualizar la visibilidad de los campos de facturación
        function updateBillingFields() {
            if (sameBillingAddress.checked) {
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
        }
        
        // Inicializar el estado
        updateBillingFields();
        
        // Actualizar cuando cambie el checkbox
        sameBillingAddress.addEventListener('change', updateBillingFields);
    }

    const registerPasswordInput = document.getElementById('registerPassword');
    if (registerPasswordInput) {
        registerPasswordInput.addEventListener('input', function () {
            const password = this.value;
            let valor = 0;

            if (password.length >= 8) valor++;
            if (/[A-Z]/.test(password)) valor++;
            if (/[0-9]/.test(password)) valor++;
            if (/[!@#$%^&*]/.test(password)) valor++;
            if (/[a-z]/.test(password)) valor++;

            const meter = document.getElementById('pass');
            if (meter) meter.value = valor;

            if (valor < 3) {
                this.setCustomValidity('La contraseña debe ser de nivel medio o fuerte.');
            } else {
                this.setCustomValidity('');
            }
        });
    }

    const confirmPassword = document.getElementById('confirmPassword');
    if (confirmPassword) {
        confirmPassword.addEventListener('input', function () {
            let password = document.getElementById('password') ? document.getElementById('password').value : '';
            if (this.value !== password) {  
                this.setCustomValidity('Las contraseñas no coinciden.');
            } else {
                this.setCustomValidity('');
            }
        });
    }

    const detailsModal = document.getElementById('detailsModal');
    if (detailsModal && detailsModal.querySelector('button')) {
        detailsModal.querySelector('button').addEventListener('click', function () {
            detailsModal.style.display = 'none';
        });
    }

    const cookiesBanner = document.getElementById('cookiesBanner');
    if (cookiesBanner && cookiesBanner.querySelector('button')) {
        cookiesBanner.querySelector('button').addEventListener('click', function () {
            cookiesBanner.style.display = 'none';
            localStorage.setItem('cookiesAccepted', 'true');
        });
    }



    const popupCorrecto = document.getElementById('popupCorrecto');
    if (popupCorrecto && popupCorrecto.querySelector('button')) {
        popupCorrecto.querySelector('button').addEventListener('click', function () {
            popupCorrecto.style.display = 'none';
        });
    }

    document.querySelectorAll('.tab').forEach(tab => {
        tab.addEventListener('click', function () {
            let formType = this.getAttribute('data-form');
            cambiarFormulario(formType);
        });
    });

    window.aceptarCookies = function() {
        document.getElementById('cookiesBanner').style.display = 'none';
        localStorage.setItem('cookiesAccepted', 'true');
    }

    function cambiarFormulario(formType) {
        let loginForm = document.getElementById('loginForm');
        let registerForm = document.getElementById('registerForm');
        let tabs = document.querySelectorAll('.tab');

        if (formType === 'login') {
            loginForm.classList.remove('hidden');
            registerForm.classList.add('hidden');
            tabs[0].classList.add('active');
            tabs[1].classList.remove('active');
        } else {
            loginForm.classList.add('hidden');
            registerForm.classList.remove('hidden');
            tabs[0].classList.remove('active');
            tabs[1].classList.add('active');
        }
    }

    if (localStorage.getItem('cookiesAccepted')) {
        document.getElementById('cookiesBanner').style.display = 'none';
    }
});
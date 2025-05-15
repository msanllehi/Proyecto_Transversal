document.addEventListener('DOMContentLoaded', function() {
    // Sistema de estrellas para valoración
    const ratingStars = document.querySelectorAll('.rating-star');
    const ratingInput = document.getElementById('rating');
    
    if (ratingStars.length > 0 && ratingInput) {
        ratingStars.forEach(star => {
            star.addEventListener('click', () => {
                const value = star.getAttribute('data-value');
                ratingInput.value = value;
                
                // Actualizar visualmente las estrellas
                ratingStars.forEach(s => {
                    if (s.getAttribute('data-value') <= value) {
                        s.classList.add('text-yellow-400');
                        s.classList.remove('text-gray-300');
                    } else {
                        s.classList.add('text-gray-300');
                        s.classList.remove('text-yellow-400');
                    }
                });
            });
        });
    }
    
    // Envío de formulario de opiniones
    const opinionForm = document.getElementById('opinion-form');
    if (opinionForm) {
        opinionForm.addEventListener('submit', async function(e) {
            e.preventDefault();
            
            const productId = document.getElementById('product-id').value;
            const username = document.getElementById('username').value;
            const rating = document.getElementById('rating').value;
            const comment = document.getElementById('comment').value;
            
            // Validar campos requeridos
            if (!username || !rating) {
                alert('Por favor, completa tu nombre y valoración');
                return;
            }
            
            try {
                // Obtener la URL de la API de opiniones
                const apiUrl = opinionForm.getAttribute('data-api-url');
                
                // Enviar opinión a la API
                const response = await fetch(apiUrl + "/api/opinions/" + productId, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        username: username,
                        rating: parseInt(rating),
                        comment: comment
                    })
                });
                
                const result = await response.json();
                
                if (result.success) {
                    // Recargar la página para mostrar la nueva opinión
                    window.location.reload();
                } else {
                    alert('Error: ' + (result.message || 'No se pudo enviar la opinión'));
                }
            } catch (error) {
                console.error('Error:', error);
                alert('Error al enviar la opinión');
            }
        });
    }
});

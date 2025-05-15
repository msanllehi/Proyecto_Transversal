document.addEventListener('DOMContentLoaded', function() {
    // Eliminar producto con AJAX
    document.querySelectorAll('.delete-product').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-id');
            const productName = this.getAttribute('data-name');
            
            if (confirm(`¿Estás seguro de que quieres eliminar el producto "${productName}"?`)) {
                // Realizar una solicitud para eliminar el producto
                const url = `/admin/products/${productId}`;
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                
                // Crear y enviar la solicitud
                const xhr = new XMLHttpRequest();
                xhr.open('POST', url);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        try {
                            const response = JSON.parse(xhr.responseText);
                            if (response.success) {
                                // Eliminar la fila de la tabla
                                document.getElementById(`product-${productId}`).remove();
                                alert(response.message || 'Producto eliminado correctamente');
                            } else {
                                alert(response.message || 'Error al eliminar el producto');
                            }
                        } catch (e) {
                            // Si la respuesta no es JSON, eliminamos la fila
                            document.getElementById(`product-${productId}`).remove();
                            alert('Producto eliminado correctamente');
                        }
                    } else {
                        alert('Error al eliminar el producto');
                    }
                };
                xhr.onerror = function() {
                    alert('Error de conexión al eliminar el producto');
                };
                xhr.send('_method=DELETE&_token=' + token);
            }
        });
    });
    
    // Editar precio con AJAX
    document.querySelectorAll('.edit-price-btn').forEach(button => {
        button.addEventListener('click', function() {
            const productId = this.getAttribute('data-id');
            const currentPrice = this.getAttribute('data-price');
            const newPrice = prompt('Introduce el nuevo precio:', currentPrice);
            
            if (newPrice !== null && newPrice !== '' && !isNaN(newPrice)) {
                // Crear y enviar la solicitud
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const xhr = new XMLHttpRequest();
                xhr.open('POST', `/admin/products/${productId}`);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        try {
                            const response = JSON.parse(xhr.responseText);
                            if (response.success) {
                                // Actualizar el precio mostrado
                                const row = document.getElementById(`product-${productId}`);
                                const priceSpan = row.querySelector('.product-price');
                                priceSpan.textContent = newPrice;
                                button.setAttribute('data-price', newPrice);
                                alert('¡Precio actualizado correctamente!');
                            } else {
                                alert(response.message || 'Error al actualizar el precio');
                            }
                        } catch (e) {
                            alert('Error al procesar la respuesta');
                        }
                    } else {
                        alert('Error al actualizar el precio');
                    }
                };
                xhr.onerror = function() {
                    alert('Error de conexión al actualizar el precio');
                };
                xhr.send(`_method=PUT&_token=${token}&price=${newPrice}`);
            }
        });
    });
});

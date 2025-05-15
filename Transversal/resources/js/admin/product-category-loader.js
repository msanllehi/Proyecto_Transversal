document.addEventListener('DOMContentLoaded', function() {
    const categorySelect = document.getElementById('category_id');
    const subcategorySelect = document.getElementById('subcategory_id');
    
    // Si no existen los elementos en el DOM, salir
    if (!categorySelect || !subcategorySelect) return;
    
    // Cargar subcategorías cuando se selecciona una categoría
    categorySelect.addEventListener('change', function() {
        const categoryId = this.value;
        
        if (categoryId) {
            // Habilitar el selector de subcategorías
            subcategorySelect.disabled = false;
            
            // Cargar las subcategorías mediante AJAX
            fetch(`/admin/get-subcategories?category_id=${categoryId}`, {
                headers: {
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Limpiar opciones actuales
                    subcategorySelect.innerHTML = '<option value="">Selecciona una subcategoria</option>';
                    
                    // Añadir nuevas opciones
                    data.subcategories.forEach(subcategory => {
                        const option = document.createElement('option');
                        option.value = subcategory.id;
                        option.textContent = subcategory.name;
                        subcategorySelect.appendChild(option);
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Ha ocurrido un error al cargar las subcategorías');
            });
        } else {
            // Deshabilitar y limpiar el selector de subcategorías
            subcategorySelect.disabled = true;
            subcategorySelect.innerHTML = '<option value="">Selecciona primer una categoria</option>';
        }
    });
});

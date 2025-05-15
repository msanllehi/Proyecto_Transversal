document.addEventListener('DOMContentLoaded', function() {
    // Inicializar DataTable
    initDataTable('datatable-subcategories');
    
    // Eliminar subcategoría con AJAX
    document.querySelectorAll('.delete-subcategory').forEach(button => {
        button.addEventListener('click', function() {
            const subcategoryId = this.getAttribute('data-id');
            const subcategoryName = this.getAttribute('data-name');
            
            if (confirm(`¿Estás seguro de que quieres eliminar la subcategoría "${subcategoryName}"?`)) {
                const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                fetch(`/admin/subcategories/${subcategoryId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': token,
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Eliminar la fila de la tabla
                        document.getElementById(`subcategory-${subcategoryId}`).remove();
                        alert(data.message);
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Ha ocurrido un error al eliminar la subcategoría');
                });
            }
        });
    });
    
    // Cambiar categoría con AJAX
    const modal = document.getElementById('changeCategoryModal');
    const form = document.getElementById('changeCategoryForm');
    const subcategoryIdInput = document.getElementById('subcategoryId');
    const categorySelect = document.getElementById('category_id');
    
    // Abrir modal
    document.querySelectorAll('.change-category-btn').forEach(button => {
        button.addEventListener('click', function() {
            const subcategoryId = this.getAttribute('data-id');
            const currentCategoryId = this.getAttribute('data-current');
            
            subcategoryIdInput.value = subcategoryId;
            categorySelect.value = currentCategoryId;
            
            modal.classList.remove('hidden');
        });
    });
    
    // Cerrar modal
    document.getElementById('cancelChangeCategory').addEventListener('click', function() {
        modal.classList.add('hidden');
    });
    
    // Enviar formulario
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const subcategoryId = subcategoryIdInput.value;
        const categoryId = categorySelect.value;
        const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        fetch(`/admin/subcategories/${subcategoryId}/change-category`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': token,
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                category_id: categoryId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Actualizar el nombre de la categoría en la tabla
                const row = document.getElementById(`subcategory-${subcategoryId}`);
                const categoryNameSpan = row.querySelector('.category-name');
                categoryNameSpan.textContent = data.category_name;
                
                // Actualizar el data-current del botón
                const button = row.querySelector('.change-category-btn');
                button.setAttribute('data-current', categoryId);
                
                // Cerrar modal
                modal.classList.add('hidden');
                
                alert(data.message);
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Ha ocurrido un error al cambiar la categoría');
        });
    });
});

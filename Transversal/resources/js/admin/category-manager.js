document.addEventListener('DOMContentLoaded', function() {
    // Inicializar DataTable
    initDataTable('datatable-categories');
    
    // Confirmación de eliminación
    document.querySelectorAll('.delete-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const categoryName = this.getAttribute('data-name');
            if (confirm(`¿Estás seguro de que quieres eliminar la categoría "${categoryName}"?`)) {
                this.submit();
            }
        });
    });
});

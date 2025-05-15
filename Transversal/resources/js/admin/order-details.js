document.addEventListener('DOMContentLoaded', function() {
    // Esperamos a que DataTables esté disponible
    const checkDataTables = setInterval(function() {
        if (typeof $.fn.DataTable !== 'undefined') {
            clearInterval(checkDataTables);
            
            // Verificamos si la tabla ya ha sido inicializada
            if (!$.fn.DataTable.isDataTable('#datatable-order-items')) {
                // Solo inicializamos si no ha sido inicializada previamente
                $('#datatable-order-items').DataTable({
                    responsive: false,
                    scrollX: true,
                    language: {
                        url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
                    }
                });
            }
        }
    }, 100); // Comprobamos cada 100ms
    
    // Establecemos un timeout para evitar bucles infinitos
    setTimeout(function() {
        clearInterval(checkDataTables);
    }, 5000); // 5 segundos máximo de espera
});

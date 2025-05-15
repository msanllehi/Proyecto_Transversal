// Archivo común para inicializar DataTables
// Este archivo evita cargar múltiples veces las mismas librerías

// Función para cargar script de manera asíncrona
function loadScript(url, callback) {
    var script = document.createElement('script');
    script.type = 'text/javascript';
    script.src = url;
    script.onload = callback;
    document.head.appendChild(script);
}

// Función para cargar CSS
function loadCSS(url) {
    var link = document.createElement('link');
    link.rel = 'stylesheet';
    link.href = url;
    document.head.appendChild(link);
}

// Cargar jQuery primero, luego DataTables
if (typeof jQuery === 'undefined') {
    loadScript('https://code.jquery.com/jquery-3.6.0.min.js', function() {
        // Una vez que jQuery está cargado, cargar DataTables
        loadScript('https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js', function() {
            // Inicializar DataTables después de cargar todas las dependencias
            initDataTables();
        });
        loadCSS('https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css');
        // Añadir estilos adicionales para el contenedor responsive
        const style = document.createElement('style');
        style.textContent = `
            .table-responsive {
                width: 100%;
                overflow-x: auto;
                -webkit-overflow-scrolling: touch;
            }
        `;
        document.head.appendChild(style);
    });
} else if (typeof $.fn.DataTable === 'undefined') {
    // jQuery ya está cargado, solo cargar DataTables
    loadScript('https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js', function() {
        // Inicializar DataTables después de cargar todas las dependencias
        initDataTables();
    });
    loadCSS('https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css');
    // Añadir estilos adicionales para el contenedor responsive
    const style = document.createElement('style');
    style.textContent = `
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
    `;
    document.head.appendChild(style);
} else {
    // Todo está cargado, inicializar directamente
    initDataTables();
}

// Función para inicializar DataTables
function initDataTables() {
    $(document).ready(function() {
        // Opciones comunes para todas las tablas
        const commonOptions = {
            responsive: false, // Desactivamos responsive para permitir scroll horizontal
            scrollX: true,    // Habilitamos scroll horizontal
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
            }
        };
        
        // Aplicar estilos para el contenedor de la tabla
        $('table.dataTable').wrap('<div class="table-responsive" style="width: 100%; overflow-x: auto;"></div>');
        
        // Inicializar todas las tablas DataTables
        if ($('#datatable-products').length) {
            $('#datatable-products').DataTable(commonOptions);
        }
        
        if ($('#datatable-users').length) {
            $('#datatable-users').DataTable(commonOptions);
        }
        
        if ($('#datatable-orders').length) {
            $('#datatable-orders').DataTable(commonOptions);
        }
        
        // Inicializar cualquier otra tabla con la clase datatable-responsive
        $('.datatable-responsive').each(function() {
            if (!$.fn.DataTable.isDataTable(this)) {
                $(this).DataTable(commonOptions);
            }
        });
    });
}

// La inicialización ahora se maneja en las funciones de callback de carga
// No es necesario el event listener DOMContentLoaded porque inicializamos
// DataTables después de que se carguen las dependencias

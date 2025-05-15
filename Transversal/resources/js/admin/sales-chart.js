class GraficaBarres {
  constructor(canvas, context, dades, titol, colors, etiquetes) {
    this.canvas = canvas;
    this.ctx = context;
    this.dades = dades;
    this.titol = titol;
    this.colors = colors;
    this.etiquetes = etiquetes;

    this.marge = 40;
    this.amplada = canvas.width;
    this.alcada = canvas.height;

    this.dibuixarGrafica();
  }

  dibuixarGrafica() {
    const ctx = this.ctx;
    const dades = this.dades;
    const colors = this.colors;

    // Fondo blanco
    ctx.fillStyle = "white";
    ctx.fillRect(0, 0, this.amplada, this.alcada);
    
    // Borde alrededor del gráfico
    ctx.strokeStyle = "#000";
    ctx.lineWidth = 1;
    ctx.strokeRect(0, 0, this.amplada, this.alcada);

    const ampleUtil = this.amplada - this.marge * 2;
    const altUtil = this.alcada - this.marge * 2;

    const numBarres = dades.length;
    const ampleBarra = ampleUtil / (numBarres * 1.5);
    const espai = ampleBarra / 2;

    const valorMaxim = Math.max(...dades, 1); // Asegurar que siempre hay un valor máximo
    // Redondear el valor máximo al siguiente múltiplo de 10 para tener líneas de cuadrícula más limpias
    const valorMaximRedondeado = Math.ceil(valorMaxim / 10) * 10;
    const escalaAltura = altUtil / valorMaximRedondeado;

    // Dibujar líneas horizontales y etiquetas de valores
    ctx.font = "12px Arial";
    ctx.fillStyle = "#333";
    ctx.textAlign = "right";
    
    for (let valor = 0; valor <= valorMaximRedondeado; valor += 10) {
      const y = this.alcada - this.marge - valor * escalaAltura;
      this.dibuixarLinia(ctx, this.marge, y, this.amplada - this.marge, y, "#ddd");
      ctx.fillText(valor.toString(), this.marge - 5, y + 4);
    }

    // Dibujar barras
    for (let i = 0; i < numBarres; i++) {
      const valor = dades[i];
      const x = this.marge + i * (ampleBarra + espai);
      const altura = valor * escalaAltura;
      const y = this.alcada - this.marge - altura;

      this.dibuixarBarra(ctx, x, y, ampleBarra, altura, colors[i]);
    }

    // Título centrado en la parte inferior
    ctx.font = "14px Arial";
    ctx.fillStyle = "#000";
    ctx.textAlign = "center";
    ctx.fillText(this.titol, this.amplada / 2, this.alcada - 10);
  }

  dibuixarBarra(ctx, x, y, ample, alt, color) {
    ctx.fillStyle = color;
    ctx.fillRect(x, y, ample, alt);
  }

  dibuixarLinia(ctx, x1, y1, x2, y2, color) {
    ctx.beginPath();
    ctx.moveTo(x1, y1);
    ctx.lineTo(x2, y2);
    ctx.strokeStyle = color;
    ctx.stroke();
  }
}

// Esperar a que el DOM esté completamente cargado
document.addEventListener('DOMContentLoaded', initChart);

// También intentar inicializar inmediatamente
initChart();

function initChart() {
    // Inicializar variables para el gráfico
    let canvas = document.getElementById("canvas");
    let ctx = canvas.getContext("2d");
    let grafica = null;
    
    // Obtener datos del controlador
    let productNames = window.salesChartData?.productNames || [];
    let salesData = window.salesChartData?.salesData || [];
    let chartColors = window.salesChartData?.chartColors || [];
    
    const titol = "Gestión de ventas";
    
    // Hacer el canvas responsive
    function resizeCanvas() {
        const container = canvas.parentElement;
        if (!container) return;
        
        // Obtener el ancho del contenedor padre
        const containerWidth = container.clientWidth;
        
        // Definir una altura máxima para dispositivos móviles
        let canvasHeight = Math.min(window.innerHeight * 0.6, 400);
        
        // Para dispositivos muy pequeños, ajustar aún más la altura
        if (window.innerWidth < 576) {
            canvasHeight = Math.min(canvasHeight, 300);
        }
        
        // Establecer el tamaño del canvas
        canvas.width = containerWidth - 30; // Restar el padding
        canvas.height = canvasHeight;
        
        console.log(`Canvas redimensionado a ${canvas.width}x${canvas.height}`);
        
        // Actualizar el gráfico
        initOrUpdateChart();
    }
    
    // Función para inicializar o actualizar el gráfico
    function initOrUpdateChart() {
        // Resetear completamente el canvas para evitar problemas de renderizado
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        
        // Pequeña pausa para asegurar que el canvas esté listo
        setTimeout(() => {
            if (salesData && salesData.length > 0) {
                grafica = new GraficaBarres(canvas, ctx, salesData, titol, chartColors, productNames);
            } else {
                // Fondo blanco y borde
                ctx.fillStyle = "white";
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                ctx.strokeStyle = "#000";
                ctx.lineWidth = 1;
                ctx.strokeRect(0, 0, canvas.width, canvas.height);
                
                // Mensaje de no hay datos
                const msg = "No hay datos de ventas disponibles";
                ctx.font = "bold 16px sans-serif";
                ctx.textAlign = "center";
                ctx.fillStyle = "#666";
                ctx.fillText(msg, canvas.width/2, canvas.height/2);
            }
        }, 50); // Un pequeño retraso para asegurar que el DOM está listo
    }
    
    // Escuchar cambios de tamaño de ventana
    window.addEventListener('resize', function() {
        // Usar debounce para evitar demasiadas reconstrucciones
        clearTimeout(window.resizeTimeout);
        window.resizeTimeout = setTimeout(function() {
            resizeCanvas();
        }, 200);
    });
    
    // Inicializar el tamaño del canvas
    resizeCanvas();
    
    // Inicializar el gráfico
    initOrUpdateChart();
    
    // Manejar los botones de ordenación
    document.getElementById('sort-desc-btn').addEventListener('click', function() {
        fetchSortedData('sales_desc');
        toggleActiveButton(this);
    });
    
    document.getElementById('sort-asc-btn').addEventListener('click', function() {
        fetchSortedData('sales_asc');
        toggleActiveButton(this);
    });
    
    // Función para activar/desactivar botones
    function toggleActiveButton(activeBtn) {
        // Desactivar todos los botones
        document.querySelectorAll('[data-sort]').forEach(btn => {
            btn.classList.remove('bg-blue-600', 'text-white');
            btn.classList.add('bg-gray-100', 'text-gray-800', 'hover:bg-gray-200');
        });
        
        // Activar el botón seleccionado
        activeBtn.classList.remove('bg-gray-100', 'text-gray-800', 'hover:bg-gray-200');
        activeBtn.classList.add('bg-blue-600', 'text-white');
    }
    
    // Función para obtener datos ordenados mediante AJAX
    function fetchSortedData(sortType) {
        // Mostrar indicador de carga
        document.getElementById('loading-indicator').classList.remove('hidden');
        
        fetch(`/admin/sales?sort=${sortType}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            // Actualizar datos del gráfico
            productNames = data.productNames;
            salesData = data.salesData;
            chartColors = data.chartColors;
            
            // Actualizar la tabla de ventas
            const tableContainer = document.querySelector('.md\\:w-1\\/4');
            if (data.tableData && data.tableData.length > 0) {
                // Construir la tabla dinámicamente
                let tableHTML = `
                    <table class="w-full divide-y divide-gray-200 border rounded">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Curso</th>
                                <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Ventas</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                `;
                
                // Añadir filas con los datos de los productos
                data.tableData.forEach(product => {
                    tableHTML += `
                        <tr>
                            <td class="px-3 py-2 text-sm font-medium text-gray-900 max-w-[150px] truncate">${product.name}</td>
                            <td class="px-3 py-2 text-sm text-gray-900">
                                <span class="text-green-600 font-semibold">${product.sales}</span>
                            </td>
                        </tr>
                    `;
                });
                
                tableHTML += `
                        </tbody>
                    </table>
                `;
                
                tableContainer.innerHTML = tableHTML;
            }
            
            // Actualizar el gráfico
            initOrUpdateChart();
            
            // Ocultar indicador de carga
            document.getElementById('loading-indicator').classList.add('hidden');
        })
        .catch(error => {
            console.error('Error al ordenar los datos:', error);
            document.getElementById('loading-indicator').classList.add('hidden');
        });
    }
}

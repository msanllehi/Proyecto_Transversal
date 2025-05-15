@extends('layouts.layout')
@section('content')
<main class="pt-28 pb-32">
<div class="container mx-auto px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold">Gestión de Ventas</h1>
        <a href="{{ route('admin.dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
            Volver al Panel
        </a>
    </div>
    
    @if(session('status'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('status') }}
    </div>
    @endif
    
    <!-- Controles -->
    <div class="bg-white shadow rounded-lg p-4 sm:p-6 mb-6">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">
            <div>
                <h2 class="text-xl font-semibold mb-4">Ordenar por ventas</h2>
                <div class="flex flex-wrap gap-2">
                    <button type="button" id="sort-desc-btn" 
                       data-sort="sales_desc"
                       class="inline-block px-4 py-2 text-sm font-medium rounded-md shadow-sm 
                              bg-orange-600 text-white hover:bg-orange-700 dark:bg-orange-600 dark:text-white dark:hover:bg-orange-700">
                        Mayor número de ventas
                    </button>
                    <button type="button" id="sort-asc-btn"
                       data-sort="sales_asc" 
                       class="inline-block px-4 py-2 text-sm font-medium rounded-md shadow-sm 
                              bg-orange-600 text-white hover:bg-orange-700 dark:bg-orange-600 dark:text-white dark:hover:bg-orange-700">
                        Menor número de ventas
                    </button>
                </div>
            </div>
            
            <div>
                <h2 class="text-xl font-semibold mb-4">Aplicar descuento</h2>
                <form action="{{ route('admin.sales.apply-discount') }}" method="POST" class="flex flex-col space-y-4">
                    @csrf
                    <div>
                        <label for="discount_percentage" class="block text-sm font-medium text-gray-700 mb-1">Porcentaje de descuento (%):</label>
                        <input type="number" name="discount_percentage" id="discount_percentage" min="1" max="99" required 
                               class="w-full bg-white border-2 border-gray-300 rounded-md shadow-sm ">
                        <p class="text-sm text-gray-500 mt-1">
                            Aplicará el descuento a todos los cursos
                        </p>
                    </div>
                    <div>
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">
                            Aplicar descuento
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Gráfico de ventas -->
    <div class="bg-white shadow rounded-lg p-4 sm:p-6 mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold mb-4">Gráfico de Ventas</h2>
            <!-- Indicador de carga -->
            <div id="loading-indicator" class="hidden">
                <div class="flex items-center">
                    <svg class="animate-spin h-5 w-5 mr-2 text-blue-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    <span class="text-blue-500">Actualizando...</span>
                </div>
            </div>
        </div>
        <div class="flex flex-col md:flex-row gap-6">
            <!-- Tabla de ventas a la izquierda -->
            <div class="md:w-1/4 flex-shrink-0">
                <table class="w-full divide-y divide-gray-200 border rounded">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Curso</th>
                            <th class="px-3 py-2 text-left text-xs font-medium text-gray-500 uppercase">Ventas</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @php
                            $graphProducts = array_filter($products->toArray(), function($product) use ($productSales) {
                                return ($productSales[$product['id']] ?? 0) > 0;
                            });
                        @endphp
                        @foreach($graphProducts as $product)
                            <tr>
                                <td class="px-3 py-2 text-sm font-medium text-gray-900 max-w-[150px] truncate">{{ $product['name'] }}</td>
                                <td class="px-3 py-2 text-sm text-gray-900">
                                    <span class="text-green-600 font-semibold">{{ $productSales[$product['id']] ?? 0 }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Gráfico de barras a la derecha -->
            <div class="md:w-3/4 flex-grow">
                <div class="w-full h-full flex justify-center items-center">
                    <canvas id="canvas" width="600" height="400"></canvas>
                </div>
            </div>
        </div>
    </div>
    
    <div class="bg-white shadow rounded-lg p-4 sm:p-6 mb-2">
        <div class="flex justify-center items-center">
            <a href="{{ route('admin.dashboard') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">
                Volver al Panel
            </a>
        </div>
    </div>
</div>
</main>

<!-- Pasar datos del servidor al JavaScript -->
<script>
    window.salesChartData = {
        productNames: {!! $productNames !!},
        salesData: {!! $salesData !!},
        chartColors: {!! $chartColors !!}
    };
</script>

<!-- Cargar el script externo -->
@vite(['resources/js/admin/sales-chart.js'])
@endsection

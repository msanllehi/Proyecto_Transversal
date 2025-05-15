@extends('layouts.layout')
@section('content')
<main class="pt-28 pb-32">
<div class="container mx-auto pt-16">
    <h1 class="text-2xl font-bold mb-6 text-center">Gestión de Productos</h1>
    <div class="bg-white rounded-lg shadow p-6">
        <table id="datatable-products" class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Imagen</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoría</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subcategoría</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio</th>

                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($products as $product)
                <tr id="product-{{ $product->id }}">
                    <td class="px-6 py-4 whitespace-nowrap">{{ $product->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($product->image)
                            <img src="{{ $product->image }}" alt="{{ $product->name }}" class="h-12 w-16 object-cover rounded">
                        @else
                            <span class="text-gray-400">Sin imagen</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $product->name }}</td>
                    <td class="px-6 py-4 max-w-xs overflow-hidden text-ellipsis">{{ Str::limit($product->description, 50) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $product->category ? $product->category->name : 'No asignada' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $product->subcategory ? $product->subcategory->name : 'No asignada' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <span class="product-price">{{ $product->price }}</span> €
                        <button class="ml-2 text-blue-500 hover:text-blue-700 edit-price-btn" data-id="{{ $product->id }}" data-price="{{ $product->price }}">
                            <i class="fas fa-edit"></i>
                        </button>
                    </td>

                    <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                        <a href="{{ route('admin.products.edit', $product) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">Editar</a>
                        <button class="delete-product bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded" data-id="{{ $product->id }}" data-name="{{ $product->name }}">Eliminar</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="flex items-center justify-center mt-6">
        <a href="{{ route('admin.products.create') }}" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Añadir Producto</a>
    </div>
</div>
@push('scripts')
@vite(['resources/js/admin/product-manager.js'])
@endpush
</main>
@endsection

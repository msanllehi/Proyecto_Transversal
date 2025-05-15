@extends('layouts.layout')
@section('content')
<div class="container mx-auto mt-32 mb-16 flex justify-center">
    <div class="w-full max-w-lg">
        <h1 class="text-2xl font-bold mb-6 text-center">Añadir Producto</h1>
        <form method="POST" action="{{ route('admin.products.store') }}" class="bg-white rounded-lg shadow p-6">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-bold mb-2">Nombre</label>
            <input type="text" name="name" id="name" class="w-full border rounded px-3 py-2 bg-orange-500" required>
        </div>
        <div class="mb-4">
            <label for="description" class="block text-gray-700 font-bold mb-2">Descripción</label>
            <textarea name="description" id="description" class="w-full border rounded px-3 py-2 bg-orange-500" rows="4"></textarea>
        </div>
        <div class="mb-4">
            <label for="price" class="block text-gray-700 font-bold mb-2">Precio (€)</label>
            <input type="number" name="price" id="price" class="w-full border rounded px-3 py-2 bg-orange-500" step="0.01" required>
        </div>
        <div class="mb-4">
            <label for="image" class="block text-gray-700 font-bold mb-2">URL de la imagen</label>
            <input type="text" name="image" id="image" class="w-full border rounded px-3 py-2 bg-orange-500" placeholder="https://example.com/image.jpg">
        </div>

        <div class="mb-4">
            <label for="category_id" class="block text-gray-700 font-bold mb-2">Categoría</label>
            <select name="category_id" id="category_id" class="w-full border rounded px-3 py-2 bg-orange-500">
                <option value="">Selecciona una categoría</option>
                @foreach($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="mb-4">
            <label for="subcategory_id" class="block text-gray-700 font-bold mb-2">Subcategoría</label>
            <select name="subcategory_id" id="subcategory_id" class="w-full border rounded px-3 py-2 bg-orange-500" disabled>
                <option value="">Selecciona primero una categoría</option>
            </select>
        </div>
        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Guardar</button>
        <a href="{{ route('admin.products.index') }}" class="ml-4 text-gray-700 hover:underline">Volver</a>
        </form>
    </div>
</div>
@push('scripts')
@vite(['resources/js/admin/product-category-loader.js'])
@endpush
@endsection

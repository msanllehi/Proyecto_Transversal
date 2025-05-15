@extends('layouts.layout')
@section('content')
<div class="container mx-auto mt-32 mb-16">
    <h1 class="text-2xl font-bold mb-6">Gestión de Subcategorías</h1>
    <div class="bg-white rounded-lg shadow p-6">
        <table id="datatable-subcategories" class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Categoría</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($subcategories as $subcategory)
                <tr id="subcategory-{{ $subcategory->id }}">
                    <td class="px-6 py-4 whitespace-nowrap">{{ $subcategory->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $subcategory->name }}</td>
                    <td class="px-6 py-4 max-w-xs overflow-hidden text-ellipsis">{{ Str::limit($subcategory->description, 50) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <span class="category-name">{{ $subcategory->category->name }}</span>
                            <button class="ml-2 text-blue-500 hover:text-blue-700 change-category-btn" data-id="{{ $subcategory->id }}" data-current="{{ $subcategory->category_id }}">
                                <i class="fas fa-edit"></i>
                            </button>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                        <a href="{{ route('admin.subcategories.edit', $subcategory) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">Editar</a>
                        <button class="delete-subcategory bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded" data-id="{{ $subcategory->id }}" data-name="{{ $subcategory->name }}">Eliminar</button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <a href="{{ route('admin.subcategories.create') }}" class="mt-6 inline-block bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Añadir Subcategoría</a>
</div>

<!-- Modal para cambiar categoría -->
<div id="changeCategoryModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h3 class="text-lg font-bold mb-4">Cambiar Categoría</h3>
        <form id="changeCategoryForm">
            <input type="hidden" id="subcategoryId" name="subcategoryId">
            <div class="mb-4">
                <label for="category_id" class="block text-gray-700 text-sm font-bold mb-2">Categoría:</label>
                <select name="category_id" id="category_id" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                    @foreach(\App\Models\Category::all() as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="flex justify-end space-x-2">
                <button type="button" id="cancelChangeCategory" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded">
                    Cancelar
                </button>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script src="{{ asset('js/datatables-common.js') }}"></script>
@vite(['resources/js/admin/subcategory-manager.js'])
@endpush
@endsection

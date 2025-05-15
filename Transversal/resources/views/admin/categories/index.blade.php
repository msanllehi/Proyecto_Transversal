@extends('layouts.layout')
@section('content')
<div class="container mx-auto mt-32 mb-16">
    <h1 class="text-2xl font-bold mb-6">Gestión de Categorías</h1>
    <div class="bg-white rounded-lg shadow p-6">
        <table id="datatable-categories" class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subcategorías</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($categories as $category)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $category->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $category->name }}</td>
                    <td class="px-6 py-4 max-w-xs overflow-hidden text-ellipsis">{{ Str::limit($category->description, 50) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $category->subcategories->count() }}</td>
                    <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                        <a href="{{ route('admin.categories.edit', $category) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">Editar</a>
                        <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="delete-form" data-name="{{ $category->name }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="mt-6 inline-block bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Añadir Categoría</a>
</div>

@push('scripts')
<script src="{{ asset('js/datatables-common.js') }}"></script>
@vite(['resources/js/admin/category-manager.js'])
@endpush
@endsection

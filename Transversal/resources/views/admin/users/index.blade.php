@extends('layouts.layout')
@section('content')
<main class="pt-28 pb-32">
<div class="container mx-auto pt-16">
    <h1 class="text-2xl font-bold mb-6 text-center">Gestión de Usuarios</h1>
    <div class="bg-white rounded-lg shadow p-6">
        <table id="datatable-users" class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Correo</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rol</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Fecha de nacimiento</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Teléfono</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dirección</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dir. facturación</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ciudad</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Código postal</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($users as $user)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($user->role == 'admin')
                            Administrador
                        @else
                            Usuario
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->birth_date ? date('d/m/Y', strtotime($user->birth_date)) : '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->phone ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->address ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->billing_address ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->city ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $user->postal_code ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                        <a href="{{ route('admin.users.edit', $user) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">Editar</a>
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este usuario?');">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
</main>
@push('scripts')
<script src="{{ asset('js/datatables-common.js') }}"></script>
@endpush
@endsection

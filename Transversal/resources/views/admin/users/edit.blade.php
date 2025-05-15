@extends('layouts.layout')
@section('content')
<main class="pt-28 pb-32 min-h-screen">
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-6 text-center">Editar Usuario</h1>
    <form method="POST" action="{{ route('admin.users.update', $user) }}" class="bg-white rounded-lg shadow p-6 max-w-lg mx-auto">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-bold mb-2">Nombre</label>
            <input type="text" name="name" id="name" class="w-full border rounded px-3 py-2 bg-orange-500" value="{{ $user->name }}" required>
        </div>
        <div class="mb-4">
            <label for="email" class="block text-gray-700 font-bold mb-2">Correo electrónico</label>
            <input type="email" name="email" id="email" class="w-full border rounded px-3 py-2 bg-orange-500" value="{{ $user->email }}" required>
        </div>
        <div class="mb-4">
            <label for="role" class="block text-gray-700 font-bold mb-2">Rol</label>
            <select name="role" id="role" class="w-full border rounded px-3 py-2 bg-orange-500">
                <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>Usuario</option>
                <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Administrador</option>
            </select>
        </div>
        <div class="mb-4">
            <label for="birth_date" class="block text-gray-700 font-bold mb-2">Fecha de nacimiento</label>
            <input type="date" name="birth_date" id="birth_date" class="w-full border rounded px-3 py-2 bg-orange-500" value="{{ $user->birth_date ? date('Y-m-d', strtotime($user->birth_date)) : '' }}">
        </div>
        <div class="mb-4">
            <label for="phone" class="block text-gray-700 font-bold mb-2">Teléfono</label>
            <input type="text" name="phone" id="phone" class="w-full border rounded px-3 py-2 bg-orange-500" value="{{ $user->phone }}">
        </div>
        <div class="mb-4">
            <label for="address" class="block text-gray-700 font-bold mb-2">Dirección</label>
            <input type="text" name="address" id="address" class="w-full border rounded px-3 py-2 bg-orange-500" value="{{ $user->address }}">
        </div>
        <div class="mb-4">
            <label for="billing_address" class="block text-gray-700 font-bold mb-2">Dirección de facturación</label>
            <input type="text" name="billing_address" id="billing_address" class="w-full border rounded px-3 py-2 bg-orange-500" value="{{ $user->billing_address }}">
        </div>
        <div class="mb-4">
            <label for="city" class="block text-gray-700 font-bold mb-2">Ciudad</label>
            <input type="text" name="city" id="city" class="w-full border rounded px-3 py-2 bg-orange-500" value="{{ $user->city }}">
        </div>
        <div class="mb-4">
            <label for="postal_code" class="block text-gray-700 font-bold mb-2">Código postal</label>
            <input type="text" name="postal_code" id="postal_code" class="w-full border rounded px-3 py-2 bg-orange-500" value="{{ $user->postal_code }}">
        </div>
        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Guardar</button>
        <a href="{{ route('admin.users') }}" class="ml-4 text-gray-600 hover:underline">Volver</a>
    </form>
</div>
</main>
@endsection

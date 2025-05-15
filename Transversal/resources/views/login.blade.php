@extends('layouts.layout')
@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white rounded-lg shadow-md w-full max-w-md p-8 mt-16">
        <h2 class="text-2xl font-poppins font-bold text-gray-900 mb-6">Iniciar sesión</h2>
        @if(session('status'))
            <div class="mb-4 text-green-600">{{ session('status') }}</div>
        @endif
        @if($errors->any())
            <div class="mb-4 text-red-600">
                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif
        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf
            <div class="space-y-2">
                <label for="loginEmail" class="block font-medium text-gray-700">Correo Electrónico</label>
                <input type="email" id="loginEmail" name="email" placeholder="correo@correo.com" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500">
            </div>
            <div class="space-y-2">
                <label for="loginPassword" class="block font-medium text-gray-700">Contraseña</label>
                <input type="password" id="loginPassword" name="password" placeholder="Tu contraseña" required class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500">
            </div>
            <div class="flex items-center space-x-2">
                <input type="checkbox" id="remember" name="remember" class="w-4 h-4 border-gray-300 rounded focus:ring-orange-500">
                <label for="remember" class="text-sm text-gray-700">Recordar-me</label>
            </div>
            <button type="submit" class="w-full bg-orange-500 text-white py-2 rounded-md hover:bg-orange-600 transition duration-300 cursor-pointer">Entrar</button>
        </form>
        <div class="mt-4 text-center">
            <a href="/register" class="text-orange-500 hover:underline">¿No tienes cuenta? Regístrate</a>
        </div>
    </div>
</div>
@endsection

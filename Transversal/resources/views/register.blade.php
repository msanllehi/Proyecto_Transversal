@extends('layouts.layout')
@section('content')
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login y Registro</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    @vite('resources/css/app.css')
</head>
<body class="font-roboto text-gray-900 bg-gray-100 ">
    <div id="cookiesBanner" class="fixed bottom-0 left-0 right-0 bg-white p-4 shadow-lg flex justify-between items-center z-50">
        <p class="text-sm">
            Utilizamos cookies para mejorar tu experiencia. Al continuar navegando, aceptas nuestra 
            <a href="/privacy" class="text-orange-500 hover:underline">política de privacidad</a> y el uso de cookies.
        </p>
        <button onclick="aceptarCookies()" class="bg-orange-500 text-white px-4 py-2 rounded-md hover:bg-orange-600 transition duration-300 cursor-pointer">Aceptar</button>
    </div>

    <main class="min-h-screen flex items-center justify-center p-4">
        <div class="bg-white rounded-lg shadow-md w-full max-w-md p-8 pt-28 pb-32">
            <div class="flex border-b-2 border-gray-200 mb-8">
                <button class="tab flex-1 py-2 text-center font-poppins font-semibold text-gray-700 hover:text-orange-500 transition duration-300 cursor-pointer" data-form="login">Iniciar Sesión</button>
                <button class="tab flex-1 py-2 text-center font-poppins font-semibold text-gray-700 hover:text-orange-500 transition duration-300 cursor-pointer" data-form="register">Registro</button>
            </div>

            <form id="loginForm" class="authForm space-y-6" method="POST" action="{{ route('login') }}">
                @csrf
                <h2 class="text-2xl font-poppins font-bold text-gray-900">Iniciar Sesión</h2>
                @if(session('status'))
                    <div class="text-green-600">{{ session('status') }}</div>
                @endif
                @if($errors->any())
                    <div class="text-red-600">
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif
                
                <div class="space-y-2">
                    <label for="loginEmail" class="block font-medium text-gray-700">Correo Electrónico</label>
                    <input type="email" id="loginEmail" name="email" placeholder="correo@correo.com" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500" required value="{{ old('email') }}">
                </div>

                <div class="space-y-2">
                    <label for="loginPassword" class="block font-medium text-gray-700">Contraseña</label>
                    <input type="password" id="loginPassword" name="password" placeholder="Ingresa tu contraseña" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500" required>
                    <p class="text-sm text-gray-600">La contraseña debe tener al menos 8 caracteres, una mayúscula, un número y un carácter especial.</p>
                </div>

                <button type="submit" class="w-full bg-orange-500 text-white py-2 rounded-md hover:bg-orange-600 transition duration-300 cursor-pointer">Iniciar Sesión</button>
            </form>

            <form id="registerForm" class="authForm hidden space-y-6" method="POST" action="{{ route('register') }}">
                @csrf
                <h2 class="text-2xl font-poppins font-bold text-gray-900">Registro</h2>
                @if($errors->any())
                    <div class="text-red-600">
                        @foreach($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif
                
                <div class="space-y-2">
                    <label for="fullName" class="block font-medium text-gray-700">Nombre y Apellidos</label>
                    <input type="text" id="fullName" name="name" placeholder="Nombre y Apellidos" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500" required value="{{ old('name') }}">
                </div>

                <div class="space-y-2">
                    <label for="birthDate" class="block font-medium text-gray-700">Fecha de Nacimiento (DD/MM/YYYY)</label>
                    <input type="text" id="birthDate" name="birth_date" placeholder="dd/mm/aaaa" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500" required value="{{ old('birth_date') }}">
                </div>

                <div class="space-y-2">
                    <label for="phone" class="block font-medium text-gray-700">Número de Teléfono</label>
                    <input type="text" id="phone" name="phone" placeholder="+34 111 11 11 11" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500" required value="{{ old('phone') }}">
                </div>

                <div class="space-y-2">
                    <label for="address" class="block font-medium text-gray-700">Dirección</label>
                    <input type="text" id="address" name="address" placeholder="Calle, Número" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500" required value="{{ old('address') }}">
                </div>
                
                <div class="space-y-2">
                    <label for="billing_address" class="block font-medium text-gray-700">Dirección de Facturación</label>
                    <input type="text" id="billing_address" name="billing_address" placeholder="Calle, Número (opcional)" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500" value="{{ old('billing_address') }}">
                    <p class="text-xs text-gray-500">Dejar en blanco para usar la misma dirección principal</p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label for="city" class="block font-medium text-gray-700">Ciudad</label>
                        <input type="text" id="city" name="city" placeholder="Ciudad" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500" required value="{{ old('city') }}">
                    </div>
                    <div class="space-y-2">
                        <label for="postal_code" class="block font-medium text-gray-700">Código Postal</label>
                        <input type="text" id="postal_code" name="postal_code" placeholder="Código Postal" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500" required value="{{ old('postal_code') }}">
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="email" class="block font-medium text-gray-700">Correo Electrónico</label>
                    <input type="email" id="registerEmail" name="email" placeholder="correo@correo.com" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500" required value="{{ old('email') }}">
                </div>

                <div class="space-y-2">
                    <label for="password" class="block font-medium text-gray-700">Contraseña</label>
                    <input type="password" id="registerPassword" name="password" placeholder="Crea una contraseña" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500" required>
                    <meter id="pass" min="0" max="5" low="2" high="3" optimum="5" value="0" class="w-full h-2"></meter>
                    <p class="text-sm text-gray-600">La contraseña debe tener al menos 8 caracteres, una mayúscula, un número y un carácter especial.</p>
                </div>

                <div class="space-y-2">
                    <label for="confirmPassword" class="block font-medium text-gray-700">Confirmar Contraseña</label>
                    <input type="password" id="registerPasswordConfirm" name="password_confirmation" placeholder="Repite la contraseña" class="w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-orange-500" required>
                </div>

                <div class="flex items-center space-x-2">
                    <input type="checkbox" id="politicas" class="w-4 h-4 border-gray-300 rounded focus:ring-orange-500" required>
                    <label for="politicas" class="text-sm text-gray-700">He leído y acepto la <a href="/privacy" class="text-orange-500 hover:underline">política de privacidad</a></label>
                </div>

                <button type="submit" class="w-full bg-orange-500 text-white py-2 rounded-md hover:bg-orange-600 transition duration-300 cursor-pointer">Registrarse</button>
            </form>
        </div>
    </main>

    <div id="popupCorrecto" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg p-8 max-w-md">
            <h2 class="text-2xl font-poppins font-bold text-gray-900">¡Gracias!</h2>
            <p id="mensajeCorrecto" class="mt-4 text-gray-700">Tu acción se ha completado con éxito.</p>
            <button onclick="cerrarModal()" class="mt-6 w-full bg-gray-500 text-white py-2 rounded-md hover:bg-gray-600 transition duration-300">Cerrar</button>
        </div>
    </div>

    <div id="detailsModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white rounded-lg p-8 max-w-md">

            <button onclick="cerrarDetalles()" class="mt-6 w-full bg-gray-500 text-white py-2 rounded-md hover:bg-gray-600 transition duration-300">Cerrar</button>
        </div>
    </div>

    @vite(['resources/js/app.js', 'resources/js/loginregister.js', 'resources/js/darklight.js', 'resources/js/register-responsive.js'])
</body>
</html>
@endsection
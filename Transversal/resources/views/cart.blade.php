@extends('layouts.layout')
@section('content')
<main class="pt-28 pb-32 min-h-screen">
    <div class="container mx-auto px-4 sm:px-6 mt-5 pt-16">
        <div class="max-w-3xl mx-auto">
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden w-full p-4 sm:p-6 md:p-8">
                <h2 class="text-2xl sm:text-3xl font-bold text-orange-600 mb-6 sm:mb-8 text-center flex items-center justify-center gap-3">
                    <img src="{{ asset('images/carrito.png') }}" alt="Carrito" class="h-6 w-6"/>    
                    Carrito de compras
                </h2>
                
                <!-- Contenido del carrito -->
                <div class="overflow-x-auto">
                    <ul id="cart-items" class="divide-y divide-orange-100 mb-6 w-full"></ul>
                </div>
                
                <!-- Mensaje de carrito vacío -->
                <div id="cart-empty" class="text-gray-500 text-center py-10" style="display:none;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto mb-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <p class="text-lg">El carrito está vacío.</p>
                    <a href="/services" class="mt-4 inline-block text-orange-500 hover:text-orange-600 font-medium">Ver servicios disponibles →</a>
                </div>
                
                <!-- Botones de acción y métodos de pago -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-8">
                    <div class="flex items-center justify-center">
                        <a href="{{ route('checkout') }}" id="checkout-btn" class="w-full sm:w-auto flex items-center justify-center gap-2 bg-gradient-to-r from-green-500 to-green-400 hover:from-green-600 hover:to-green-500 text-white font-bold px-6 sm:px-8 py-3 rounded-xl shadow-lg text-base sm:text-lg transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            Realizar pago
                        </a>
                    </div>
                    <div class="flex items-center justify-center">
                        <p class="text-sm text-gray-500 mb-2">Métodos de pago aceptados:</p>
                        <div class="grid grid-cols-2 gap-4">
                            <div class="flex justify-center">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/4/41/Visa_Logo.png" alt="Visa" class="h-6 sm:h-7 w-auto grayscale hover:grayscale-0 transition" title="Visa">
                            </div>
                            <div class="flex justify-center">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/0/04/Mastercard-logo.png" alt="Mastercard" class="h-6 sm:h-7 w-auto grayscale hover:grayscale-0 transition" title="Mastercard">
                            </div>
                            <div class="flex justify-center">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" alt="PayPal" class="h-6 sm:h-7 w-auto grayscale hover:grayscale-0 transition" title="PayPal">
                            </div>
                            <div class="flex justify-center">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/2/2b/Bizum.svg" alt="Bizum" class="h-6 sm:h-7 w-auto grayscale hover:grayscale-0 transition" title="Bizum">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@vite(['resources/js/app.js', 'resources/js/darklight.js'])
@endsection

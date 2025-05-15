@extends('layouts.layout')
@section('content')
<main class="pt-28 pb-32 min-h-screen">
    <div class="container mx-auto px-6 mt-5 pt-8">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden w-full p-8">
                <h2 class="text-3xl font-bold text-orange-600 mb-8 text-center">
                    Finalizar Compra
                </h2>
                
                <form id="checkout-form" method="POST" action="{{ route('checkout.process') }}" class="space-y-8">
                    @csrf
                    
                    <!-- Resumen del carrito -->
                    <div class="mb-8">
                        <h3 class="text-xl font-semibold mb-4 text-gray-700 border-b pb-2">Resumen de tu compra</h3>
                        <div id="cart-summary" class="divide-y divide-gray-200">
                            <!-- Los items del carrito se cargarán dinámicamente aquí -->
                        </div>
                        <div class="mt-4 text-right">
                            <div class="text-lg font-semibold">Total: <span id="cart-total" class="text-orange-600">0.00 €</span></div>
                        </div>
                    </div>
                    
                    <!-- Datos de envío -->
                    <div class="mb-8">
                        <h3 class="text-xl font-semibold mb-4 text-gray-700 border-b pb-2">Datos de envío</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 font-medium mb-1">Nombre completo</label>
                                <div class="w-full border border-gray-200 bg-orange-500 rounded-lg px-3 py-2">{{ $user->name }}</div>
                            </div>
                            <div>
                                <label class="block text-gray-700 font-medium mb-1">Teléfono de contacto</label>
                                <div class="w-full border border-gray-200 bg-orange-500 rounded-lg px-3 py-2">{{ $user->phone }}</div>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-gray-700 font-medium mb-1">Dirección</label>
                                <div class="w-full border border-gray-200 bg-orange-500 rounded-lg px-3 py-2">{{ $user->address }}</div>
                            </div>
                            <div>
                                <label class="block text-gray-700 font-medium mb-1">Ciudad</label>
                                <div class="w-full border border-gray-200 bg-orange-500 rounded-lg px-3 py-2">{{ $user->city }}</div>
                            </div>
                            <div>
                                <label class="block text-gray-700 font-medium mb-1">Código postal</label>
                                <div class="w-full border border-gray-200 bg-orange-500 rounded-lg px-3 py-2">{{ $user->postal_code }}</div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Datos de facturación -->
                    <div class="mb-8">
                        <h3 class="text-xl font-semibold mb-4 text-gray-700 border-b pb-2">Datos de facturación</h3>
                        <div class="mb-4">
                            <div class="text-gray-700">
                                @if(!$user->billing_address)
                                    Se usarán los mismos datos de envío para la facturación.
                                @else
                                    <div class="grid grid-cols-1 gap-4 mt-4">
                                        <div>
                                            <label class="block text-gray-700 font-medium mb-1">Dirección de facturación</label>
                                            <div class="w-full border border-gray-200 bg-orange-500 rounded-lg px-3 py-2">{{ $user->billing_address }}</div>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <!-- Datos de pago -->
                    <div class="mb-8">
                        <h3 class="text-xl font-semibold mb-4 text-gray-700 border-b pb-2">Método de pago</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="md:col-span-2">
                                <label for="card_number" class="block text-gray-700 font-medium mb-1">Número de tarjeta</label>
                                <input type="text" id="card_number" name="card_number" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="1234 5678 9012 3456" maxlength="19" required>
                                <p class="text-xs text-gray-500 mt-1">16 dígitos máximo</p>
                            </div>
                            <div>
                                <label for="card_expiry" class="block text-gray-700 font-medium mb-1">Fecha de caducidad (MM/AA)</label>
                                <input type="text" id="card_expiry" name="card_expiry" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="MM/AA" maxlength="5" required>
                                <p class="text-xs text-gray-500 mt-1">Formato: MM/AA</p>
                            </div>
                            <div>
                                <label for="card_cvv" class="block text-gray-700 font-medium mb-1">Código de seguridad (CVV)</label>
                                <input type="text" id="card_cvv" name="card_cvv" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" placeholder="123" maxlength="3" required>
                                <p class="text-xs text-gray-500 mt-1">3 dígitos</p>
                            </div>
                            <div class="md:col-span-2">
                                <label for="card_holder" class="block text-gray-700 font-medium mb-1">Nombre del titular</label>
                                <input type="text" id="card_holder" name="card_holder" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-orange-500" required>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mt-4">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/4/41/Visa_Logo.png" alt="Visa" class="h-8 w-auto" title="Visa">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/0/04/Mastercard-logo.png" alt="Mastercard" class="h-8 w-auto" title="Mastercard">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/b/b5/PayPal.svg" alt="PayPal" class="h-8 w-auto" title="PayPal">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/2/2b/Bizum.svg" alt="Bizum" class="h-8 w-auto" title="Bizum">
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-center mt-8">
                        <a href="{{ route('cart') }}" class="text-gray-600 hover:text-gray-800 dark:text-gray-300 dark:hover:text-white flex items-center bg-transparent dark:bg-gray-700 dark:hover:bg-gray-600 px-4 py-2 rounded-lg transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                            </svg>
                            Volver al carrito
                        </a>
                        <button type="submit" class="bg-gradient-to-r from-green-500 to-green-400 hover:from-green-600 hover:to-green-500 text-white font-bold px-8 py-3 rounded-xl shadow-lg text-lg transition dark:from-green-600 dark:to-green-500 dark:hover:from-green-700 dark:hover:to-green-600">
                            Completar compra
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>

@push('scripts')
@vite(['resources/js/checkout.js'])
@endpush
@endsection

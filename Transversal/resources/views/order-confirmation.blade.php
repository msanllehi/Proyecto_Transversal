@extends('layouts.layout')
@section('content')
<main class="pt-28 pb-32 min-h-screen">
    <div class="container mx-auto px-6 mt-5 pt-8">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-2xl shadow-2xl overflow-hidden w-full p-8">
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-green-100 rounded-full mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">¡Gracias por tu compra!</h2>
                    <p class="text-gray-600">Tu pedido ha sido procesado correctamente</p>
                    <p class="text-gray-600 mt-2">Número de pedido: <span class="font-semibold">{{ $order->id }}</span></p>
                </div>
                
                <div class="mb-8">
                    <h3 class="text-xl font-semibold mb-4 text-gray-700 border-b pb-2">Resumen del pedido</h3>
                    <div class="divide-y divide-gray-200">
                        @foreach($order->orderItems as $item)
                        <div class="py-3 flex justify-between">
                            <div>
                                <p class="font-medium">{{ $item->product->name }}</p>
                                <p class="text-sm text-gray-500">{{ $item->quantity }} x {{ number_format($item->price, 2) }} €</p>
                            </div>
                            <div class="font-medium">{{ number_format($item->subtotal, 2) }} €</div>
                        </div>
                        @endforeach
                    </div>
                    <div class="mt-4 text-right border-t pt-4">
                        <div class="text-lg font-semibold">Total: <span class="text-orange-600">{{ number_format($order->total, 2) }} €</span></div>
                    </div>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                    <div>
                        <h3 class="text-xl font-semibold mb-4 text-gray-700 border-b pb-2">Datos de envío</h3>
                        @php
                            $shippingAddress = json_decode($order->shipping_address, true);
                        @endphp
                        <p class="mb-1"><span class="font-medium">Nombre:</span> {{ $shippingAddress['name'] ?? '' }}</p>
                        <p class="mb-1"><span class="font-medium">Dirección:</span> {{ $shippingAddress['address'] ?? '' }}</p>
                        <p class="mb-1"><span class="font-medium">Ciudad:</span> {{ $shippingAddress['city'] ?? '' }}</p>
                        <p class="mb-1"><span class="font-medium">Código postal:</span> {{ $shippingAddress['postal_code'] ?? '' }}</p>
                        <p><span class="font-medium">Teléfono:</span> {{ $shippingAddress['phone'] ?? '' }}</p>
                    </div>
                    
                    <div>
                        <h3 class="text-xl font-semibold mb-4 text-gray-700 border-b pb-2">Método de pago</h3>
                        <p class="mb-1"><span class="font-medium">Método:</span> Tarjeta de crédito</p>
                        <p><span class="font-medium">Tarjeta:</span> **** **** **** {{ substr($order->card_number, -4) }}</p>
                    </div>
                </div>
                
                <div class="text-center">
                    <p class="text-gray-600 mb-6">Hemos enviado un correo electrónico de confirmación a <span class="font-semibold">{{ auth()->user()->email }}</span></p>
                    
                    <div class="mb-6">
                        <h3 class="text-xl font-semibold mb-4 text-gray-700">Factura</h3>
                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="{{ route('invoice.download', $order) }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-6 py-3 rounded-lg transition flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Descargar factura
                            </a>
                            <a href="{{ route('invoice.preview', $order) }}" target="_blank" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-6 py-3 rounded-lg transition flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Ver factura
                            </a>
                        </div>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        <a href="{{ route('home') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-800 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-white font-semibold px-6 py-3 rounded-lg transition">
                            Volver a la página principal
                        </a>
                        <a href="{{ route('orders.show', $order) }}" class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-6 py-3 rounded-lg transition">
                            Ver detalles del pedido
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

@push('scripts')
@vite(['resources/js/order-confirmation.js'])
@endpush
@endsection

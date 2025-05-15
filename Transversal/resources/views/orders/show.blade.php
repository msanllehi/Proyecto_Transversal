@extends('layouts.layout')
@section('content')
<main class="pt-28 pb-32 min-h-screen">
    <div class="container mx-auto px-6 mt-5 pt-8">
        <div class="max-w-4xl mx-auto">
            <div class="flex items-center justify-between mb-8">
                <h1 class="text-3xl font-bold text-gray-800 font-poppins">Detalles del Pedido #{{ $order->id }}</h1>
                <a href="{{ route('orders.index') }}" class="bg-orange-500 hover:bg-orange-600 text-white font-semibold px-4 py-2 rounded-lg transition flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Volver a mis pedidos
                </a>
            </div>
            
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden w-full p-8">
                <div class="flex flex-col md:flex-row justify-between mb-8 pb-8 border-b">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-700 mb-2">Información del Pedido</h2>
                        <p class="text-gray-600">Fecha: <span class="font-medium">{{ $order->created_at->format('d/m/Y H:i') }}</span></p>
                        <p class="text-gray-600">Estado: 
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                Pendiente
                            </span>
                        </p>
                        <p class="text-gray-600">Método de pago: <span class="font-medium">Tarjeta de crédito</span></p>
                        @if($order->card_number)
                            <p class="text-gray-600">Tarjeta: <span class="font-medium">**** **** **** {{ $order->card_number }}</span></p>
                        @endif
                    </div>
                    
                    <div class="mt-6 md:mt-0 flex flex-col items-start md:items-end">
                        <div class="flex space-x-2 mb-4">
                            <a href="{{ route('invoice.download', $order) }}" class="bg-blue-500 hover:bg-blue-600 text-white font-semibold px-4 py-2 rounded-lg transition flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Descargar factura
                            </a>
                            <a href="{{ route('invoice.preview', $order) }}" target="_blank" class="bg-gray-500 hover:bg-gray-600 text-white font-semibold px-4 py-2 rounded-lg transition flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Ver factura
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="mb-8">
                    <h3 class="text-xl font-semibold mb-4 text-gray-700 border-b pb-2">Productos</h3>
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
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
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
                    
                    @if($order->billing_address)
                    <div>
                        <h3 class="text-xl font-semibold mb-4 text-gray-700 border-b pb-2">Datos de facturación</h3>
                        @php
                            $billingAddress = json_decode($order->billing_address, true);
                        @endphp
                        <p class="mb-1"><span class="font-medium">Nombre:</span> {{ $billingAddress['name'] ?? '' }}</p>
                        <p class="mb-1"><span class="font-medium">Dirección:</span> {{ $billingAddress['address'] ?? '' }}</p>
                        <p class="mb-1"><span class="font-medium">Ciudad:</span> {{ $billingAddress['city'] ?? '' }}</p>
                        <p class="mb-1"><span class="font-medium">Código postal:</span> {{ $billingAddress['postal_code'] ?? '' }}</p>
                        <p><span class="font-medium">Teléfono:</span> {{ $billingAddress['phone'] ?? '' }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@extends('layouts.layout')
@section('content')
<main class="pt-28 pb-32">
    <div class="container mx-auto">
        <div class="flex justify-between items-center mb-6 pt-16">
            <h1 class="text-2xl font-bold">Detalles del Pedido #{{ $order->id }}</h1>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Información del cliente -->
            <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Información del Cliente</h2>
            <div class="space-y-2">
                <p><span class="font-medium">Nombre:</span> {{ $order->user->name ?? 'N/A' }}</p>
                <p><span class="font-medium">Email:</span> {{ $order->user->email ?? 'N/A' }}</p>
            </div>
        </div>

        <!-- Información del pedido -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Información del Pedido</h2>
            <div class="space-y-2">
                <p><span class="font-medium">Estado:</span> Pendiente</p>
                <p><span class="font-medium">Fecha:</span> {{ $order->created_at->format('d/m/Y H:i') }}</p>
                <p><span class="font-medium">Total:</span> {{ $order->total }} €</p>
                <p><span class="font-medium">Método de pago:</span> Tarjeta de crédito</p>
                @if($order->card_number)
                <p><span class="font-medium">Tarjeta:</span> **** **** **** {{ substr($order->card_number, -4) }}</p>
                @endif
                @if($order->tracking_number)
                <p><span class="font-medium">Número de seguimiento:</span> {{ $order->tracking_number }}</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Direcciones -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        <!-- Dirección de envío -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Dirección de envío</h2>
            @php
                $shippingAddress = json_decode($order->shipping_address);
            @endphp
            @if($shippingAddress)
                <div class="space-y-2">
                    <p><span class="font-medium">Nombre:</span> {{ $shippingAddress->name ?? 'N/A' }}</p>
                    <p><span class="font-medium">Teléfono:</span> {{ $shippingAddress->phone ?? 'N/A' }}</p>
                    <p><span class="font-medium">Dirección:</span> {{ $shippingAddress->address ?? 'N/A' }}</p>
                    <p><span class="font-medium">Ciudad:</span> {{ $shippingAddress->city ?? 'N/A' }}</p>
                    <p><span class="font-medium">Código postal:</span> {{ $shippingAddress->postal_code ?? 'N/A' }}</p>
                </div>
            @else
                <p>No disponible</p>
            @endif
        </div>

        <!-- Dirección de facturación -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-semibold mb-4">Dirección de facturación</h2>
            @php
                $billingAddress = json_decode($order->billing_address);
            @endphp
            @if($billingAddress)
                <div class="space-y-2">
                    <p><span class="font-medium">Nombre:</span> {{ $billingAddress->name ?? 'N/A' }}</p>
                    <p><span class="font-medium">Teléfono:</span> {{ $billingAddress->phone ?? 'N/A' }}</p>
                    <p><span class="font-medium">Dirección:</span> {{ $billingAddress->address ?? 'N/A' }}</p>
                    <p><span class="font-medium">Ciudad:</span> {{ $billingAddress->city ?? 'N/A' }}</p>
                    <p><span class="font-medium">Código postal:</span> {{ $billingAddress->postal_code ?? 'N/A' }}</p>
                </div>
            @else
                <p>No disponible</p>
            @endif
        </div>
    </div>

    <!-- Productos del pedido -->
    <div class="bg-white rounded-lg shadow p-6 mb-8">
        <h2 class="text-xl font-semibold mb-4">Productos</h2>
        <div class="table-responsive">
            <table id="datatable-order-items" class="min-w-full divide-y divide-gray-200 datatable-responsive">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Producto</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Precio</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cantidad</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($order->orderItems as $item)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            {{ $item->product->name ?? 'Producto no disponible' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->price }} €</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->quantity }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $item->subtotal }} €</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="px-6 py-4 text-right font-bold">Total:</td>
                        <td class="px-6 py-4 font-bold">{{ $order->total }} €</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <!-- Acciones -->
    <div class="bg-white rounded-lg shadow p-6 flex justify-end gap-3">
        <a href="{{ route('admin.orders') }}" class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded">Volver a la lista</a>
        <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="inline-block" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este pedido?');">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">Eliminar pedido</button>
        </form>
    </div>
</div>
</main>

@push('scripts')
<script src="{{ asset('js/datatables-common.js') }}"></script>
@vite(['resources/js/admin/order-details.js'])
@endpush

@endsection

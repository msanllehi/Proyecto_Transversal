@extends('layouts.layout')
@section('content')
<main class="pt-28 pb-32">
<div class="container mx-auto pt-16">
    <h1 class="text-2xl font-bold mb-6 text-center">Gestión de Pedidos</h1>
    <div class="bg-white rounded-lg shadow p-6">
        <table id="datatable-orders" class="min-w-full divide-y divide-gray-200">
            <thead>
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cliente</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($orders as $order)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $order->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $order->user->name ?? '-' }}</td>
                    <td class="px-6 py-4 whitespace-nowrap">Pendiente</td>
                    <td class="px-6 py-4 whitespace-nowrap">{{ $order->total }} €</td>
                    <td class="px-6 py-4 whitespace-nowrap flex gap-2">
                        <a href="{{ route('admin.orders.show', $order) }}" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded">Ver detalles</a>
                        <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este pedido?');">
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

@extends('layouts.layout')
@section('content')
<main class="pt-28 pb-32">
    <div class="container mx-auto pt-16">
        <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-8">
            <h1 class="text-3xl font-bold mb-6 text-center">Mi Perfil</h1>
            
            @if (session('status'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                    {{ session('status') }}
                </div>
            @endif
            
            <form method="POST" action="{{ route('profile.update') }}">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <!-- Información Personal -->
                    <div>
                        <h2 class="text-xl font-semibold mb-4 border-b pb-2">Información Personal</h2>
                        
                        <div class="mb-4">
                            <label for="name" class="block text-gray-700 font-medium mb-2">Nombre completo</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 @error('name') border-red-500 @enderror">
                            @error('name')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="email" class="block text-gray-700 font-medium mb-2">Correo electrónico</label>
                            <input type="email" id="email" value="{{ $user->email }}" class="w-full px-4 py-2 border rounded-lg bg-gray-100 dark:bg-gray-700 dark:text-white cursor-not-allowed" readonly disabled>
                            <p class="text-gray-500 text-sm mt-1">El correo no se puede modificar por motivos de seguridad.</p>
                            <input type="hidden" name="email" value="{{ $user->email }}">
                        </div>
                        
                        <div class="mb-4">
                            <label for="birth_date" class="block text-gray-700 font-medium mb-2">Fecha de nacimiento</label>
                            <input type="text" name="birth_date" id="birth_date" value="{{ old('birth_date', $user->birth_date ? date('d/m/Y', strtotime($user->birth_date)) : '') }}" placeholder="DD/MM/AAAA" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 @error('birth_date') border-red-500 @enderror">
                            @error('birth_date')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="phone" class="block text-gray-700 font-medium mb-2">Teléfono</label>
                            <input type="text" name="phone" id="phone" value="{{ old('phone', $user->phone) }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 @error('phone') border-red-500 @enderror">
                            @error('phone')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    
                    <!-- Direcciones -->
                    <div>
                        <h2 class="text-xl font-semibold mb-4 border-b pb-2">Direcciones</h2>
                        
                        <div class="mb-4">
                            <label for="address" class="block text-gray-700 font-medium mb-2">Dirección de envío</label>
                            <input type="text" name="address" id="address" value="{{ old('address', $user->address) }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 @error('address') border-red-500 @enderror">
                            @error('address')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="billing_address" class="block text-gray-700 font-medium mb-2">Dirección de facturación (opcional)</label>
                            <input type="text" name="billing_address" id="billing_address" value="{{ old('billing_address', $user->billing_address) }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 @error('billing_address') border-red-500 @enderror">
                            <p class="text-gray-500 text-sm mt-1">Dejar en blanco para usar la misma dirección de envío</p>
                            @error('billing_address')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="city" class="block text-gray-700 font-medium mb-2">Ciudad</label>
                            <input type="text" name="city" id="city" value="{{ old('city', $user->city) }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 @error('city') border-red-500 @enderror">
                            @error('city')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="postal_code" class="block text-gray-700 font-medium mb-2">Código postal</label>
                            <input type="text" name="postal_code" id="postal_code" value="{{ old('postal_code', $user->postal_code) }}" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 @error('postal_code') border-red-500 @enderror">
                            @error('postal_code')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>
                
                <!-- Cambio de contraseña -->
                <div class="mb-6">
                    <h2 class="text-xl font-semibold mb-4 border-b pb-2">Cambiar contraseña (opcional)</h2>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="mb-4">
                            <label for="password" class="block text-gray-700 font-medium mb-2">Nueva contraseña</label>
                            <input type="password" name="password" id="password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500 @error('password') border-red-500 @enderror">
                            <p class="text-gray-500 text-sm mt-1">Dejar en blanco para mantener la contraseña actual</p>
                            @error('password')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="password_confirmation" class="block text-gray-700 font-medium mb-2">Confirmar nueva contraseña</label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-orange-500">
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end">
                    <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white font-bold py-2 px-6 rounded-lg transition duration-300">
                        Guardar cambios
                    </button>
                </div>
            </form>
            
            <!-- Historial de pedidos -->
            <div class="mt-12">
                <h2 class="text-xl font-semibold mb-4 border-b pb-2">Mis pedidos recientes</h2>
                
                @if($user->orders && $user->orders->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="min-w-full bg-white">
                            <thead>
                                <tr>
                                    <th class="py-3 px-4 border-b text-left">Nº Pedido</th>
                                    <th class="py-3 px-4 border-b text-left">Fecha</th>
                                    <th class="py-3 px-4 border-b text-left">Total</th>
                                    <th class="py-3 px-4 border-b text-left">Estado</th>
                                    <th class="py-3 px-4 border-b text-left">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($user->orders->sortByDesc('created_at')->take(5) as $order)
                                <tr>
                                    <td class="py-3 px-4 border-b">#{{ $order->id }}</td>
                                    <td class="py-3 px-4 border-b">{{ $order->created_at->format('d/m/Y') }}</td>
                                    <td class="py-3 px-4 border-b">{{ $order->total }} €</td>
                                    <td class="py-3 px-4 border-b">
                                        <span class="px-2 py-1 rounded text-xs 
                                            @if($order->status == 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($order->status == 'processing') bg-blue-100 text-blue-800
                                            @elseif($order->status == 'completed') bg-green-100 text-green-800
                                            @elseif($order->status == 'cancelled') bg-red-100 text-red-800
                                            @else bg-gray-100 text-gray-800
                                            @endif">
                                            {{ ucfirst($order->status ?? 'Pendiente') }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-4 border-b">
                                        <a href="{{ route('orders.show', $order) }}" class="text-blue-500 hover:text-blue-700">Ver detalles</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        <a href="{{ route('orders.index') }}" class="text-orange-500 hover:text-orange-700">Ver todos mis pedidos →</a>
                    </div>
                @else
                    <p class="text-gray-500">No has realizado ningún pedido todavía.</p>
                @endif
            </div>
        </div>
    </div>
</main>
@endsection

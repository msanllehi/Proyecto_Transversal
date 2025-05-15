@extends('layouts.layout')
@section('content')
<main class="pt-28 pb-32 min-h-screen">
<!-- TODO boton añadir carrito en medio-->
        <div class="container mx-auto px-6 mt-5 pt-16">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @foreach($products as $product)
                <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                    <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-56 object-cover"/>
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $product->name }}</h3>
                        <p class="text-gray-600">{{ $product->description }}</p>
                        <div class="flex justify-between mt-4">
                            <a href="{{ route('products.show', $product->id) }}" class="bg-gradient-to-r from-blue-600 via-blue-500 to-blue-400 text-white font-semibold px-4 py-2 rounded-md hover:from-blue-500 hover:to-blue-400 transition duration-300 cursor-pointer">Ver detalles</a>
                            <button class="add-to-cart bg-gradient-to-r from-orange-700 via-orange-600 to-orange-500 text-white font-semibold px-4 py-2 rounded-md hover:from-orange-600 hover:to-orange-500 transition duration-300 cursor-pointer" data-id="{{ $product->id }}" data-name="{{ $product->name }}" data-price="{{ $product->price }}">Añadir al carrito</button>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </main>
@vite(['resources/js/app.js', 'resources/js/darklight.js'])
@endsection
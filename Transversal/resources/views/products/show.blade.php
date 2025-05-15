@extends('layouts.layout')
@section('content')
<main class="pt-28 pb-32 min-h-screen">
    <div class="container mx-auto px-6 mt-5 pt-16">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="md:flex">
                <div class="md:flex-shrink-0">
                    <img src="{{ $product->image }}" alt="{{ $product->name }}" class="h-64 w-full object-cover md:w-96">
                </div>
                <div class="p-8">
                    <div class="flex justify-between items-start">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-800 mb-2">{{ $product->name }}</h1>
                            <p class="text-gray-600 mb-4">{{ $product->description }}</p>
                        </div>
                        <div class="text-right">
                            <p class="text-xl font-bold text-gray-800">{{ number_format($product->price, 2) }}€</p>
                            <button class="add-to-cart mt-2 bg-gradient-to-r from-orange-700 via-orange-600 to-orange-500 text-white font-semibold px-4 py-2 rounded-md hover:from-orange-600 hover:to-orange-500 transition duration-300 cursor-pointer" data-id="{{ $product->id }}" data-name="{{ $product->name }}" data-price="{{ $product->price }}">Añadir al carrito</button>
                        </div>
                    </div>
                    
                    <div class="mt-6">
                        <div class="flex items-center">
                            <div class="flex items-center">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= round($averageRating))
                                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.799-2.034c-.784-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    @else
                                        <svg class="w-5 h-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.799-2.034c-.784-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                        </svg>
                                    @endif
                                @endfor
                            </div>
                            <p class="ml-2 text-sm text-gray-600">{{ number_format($averageRating, 1) }} de 5 ({{ $totalOpinions }} valoraciones)</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Sección de opiniones -->
        <div class="mt-8 bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Opiniones de usuarios</h2>
            
            <!-- Formulario para añadir opinión -->
            <form id="opinion-form" class="mb-6 border-b pb-6" data-api-url="{{ env('OPINIONS_API_URL', 'http://localhost:8080') }}">
                <h3 class="text-lg font-semibold mb-3">Deja tu opinión</h3>
                @if(auth()->check())
                    <input type="hidden" id="product-id" value="{{ $product->id }}">
                    <div class="mb-4">
                        <label for="username" class="block text-sm font-medium text-gray-700">Tu nombre</label>
                        <input type="text" id="username" name="username" value="{{ auth()->user()->name }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Valoración</label>
                        <div class="flex items-center rating">
                            @for ($i = 1; $i <= 5; $i++)
                                <button type="button" data-value="{{ $i }}" class="rating-star text-gray-300 hover:text-yellow-400 focus:outline-none">
                                    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.799-2.034c-.784-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                    </svg>
                                </button>
                            @endfor
                            <input type="hidden" id="rating" name="rating">
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="comment" class="block text-sm font-medium text-gray-700">Comentario (opcional)</label>
                        <textarea id="comment" name="comment" rows="3" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">Enviar opinión</button>
                    </div>
                @else
                    <div class="text-center p-4 bg-gray-50 rounded-md">
                        <p class="text-gray-600">Para dejar una opinión, por favor <a href="{{ route('login') }}" class="text-blue-600 hover:underline">inicia sesión</a> o <a href="{{ route('register') }}" class="text-blue-600 hover:underline">regístrate</a>.</p>
                    </div>
                @endif
            </form>
            
            <!-- Lista de opiniones -->
            <div id="opinions-list">
                @if(isset($opinions['data']) && !empty($opinions['data']))
                    @foreach($opinions['data'] as $opinion)
                        <div class="mb-4 pb-4 border-b last:border-0">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-medium text-gray-900">{{ $opinion['username'] }}</h4>
                                    <div class="flex items-center mt-1">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $opinion['rating'])
                                                <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.799-2.034c-.784-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                </svg>
                                            @else
                                                <svg class="w-4 h-4 text-gray-300" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118l-2.799-2.034c-.784-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path>
                                                </svg>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($opinion['date'])->format('d/m/Y') }}
                                </div>
                            </div>
                            @if(!empty($opinion['comment']))
                                <p class="mt-2 text-gray-600">{{ $opinion['comment'] }}</p>
                            @endif
                        </div>
                    @endforeach
                @else
                    <div class="text-center py-8">
                        <p class="text-gray-500">Todavía no hay opiniones para este producto.</p>
                        <p class="text-gray-500 mt-2">¡Sé el primero en opinar!</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</main>

<!-- Scripts para la funcionalidad de valoraciones -->
@push('scripts')
@vite(['resources/js/product-ratings.js'])
@endpush
@endsection

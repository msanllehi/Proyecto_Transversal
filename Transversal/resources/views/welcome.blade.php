@extends('layouts.layout')

@section('content')
<main class="pt-28 pb-32 min-h-screen">
    <section class="pt-32 pb-20 px-4">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <div>
                    <h1 class="text-5xl font-bold text-gray-900 mb-6">
                        Descubre el placer de la comida casera
                    </h1>
                    <p class="text-xl text-gray-600 mb-8">
                        Conectamos chefs locales con amantes de la buena comida. Platos caseros, frescos y deliciosos entregados en tu puerta.
                    </p>
                    <div class="flex gap-4">
                        <a href="/services" class="bg-orange-600 text-white px-8 py-4 rounded-lg text-lg font-semibold hover:bg-orange-500 transition duration-300">
                            Explorar Cursos
                        </a>
                        <a href="/register" class="border-2 border-orange-600 text-orange-600 px-8 py-4 rounded-lg text-lg font-semibold hover:bg-orange-50 transition duration-300">
                            Ser Chef
                        </a>
                    </div>
                </div>
                <div class="relative">
                    <img src="https://images.unsplash.com/photo-1547592180-85f173990554?ixlib=rb-1.2.1&auto=format&fit=crop&w=800&q=80" alt="Deliciosa comida casera" class="rounded-2xl shadow-2xl" />
                </div>
            </div>
        </div>
    </section>

    <section class="py-20">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-4xl font-bold text-center mb-16">¿Por qué elegir DesperATE?</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                <div class="text-center">
                    <div class="bg-orange-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-hat-chef text-orange-600 text-2xl">
                        <img src="{{ asset('images/chef.png') }}" alt="Sombrero chef" class="h-10 inline">
                        </i>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Chefs Verificados</h3>
                    <p class="text-gray-600">Todos nuestros chefs son profesionales verificados con años de experiencia.</p>
                </div>
                <div class="text-center">
                    <div class="bg-orange-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-clock text-orange-600 text-2xl">
                        <img src="{{ asset('images/reloj.png') }}" alt="Entrega instantánea" class="h-10 inline">
                        </i>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Entrega instantánea</h3>
                    <p class="text-gray-600">Al realizar el pago de un curso, se te enviará todo lo necesario al instante para entrar en el.</p>
                </div>
                <div class="text-center">
                    <div class="bg-orange-100 w-16 h-16 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-star text-orange-600 text-2xl">
                        <img src="{{ asset('images/estrella.png') }}" alt="Logo" class="h-10 inline">
                        </i>
                    </div>
                    <h3 class="text-xl font-bold mb-4">Calidad Garantizada</h3>
                    <p class="text-gray-600">Los mejores cursos realizados por los mejores chefs.</p>
                </div>
            </div>
        </div>
    </section>
</main>
@vite(['resources/js/app.js', 'resources/js/darklight.js'])
@endsection
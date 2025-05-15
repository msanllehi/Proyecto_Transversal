@extends('layouts.layout')

@section('content')
<main class="pt-28 pb-32 min-h-screen">
    <div class="max-w-7xl mx-auto px-6 py-16">
        <div class="text-center mb-12">
            <h1 class="text-4xl font-poppins font-bold text-orange-600 mb-4">Contacto</h1>
            <p class="text-lg text-gray-700 leading-relaxed">¿Tienes alguna pregunta o sugerencia? ¡Nos encantaría escucharte! Conéctate con nosotros a través de nuestras redes sociales o envíanos un mensaje.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-8">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="p-6">
                    <h2 class="text-2xl font-poppins font-semibold text-gray-800 mb-4">Nuestras Redes Sociales</h2>
                    <ul class="text-lg text-gray-700 leading-relaxed">
                        <li class="mb-2"><strong>Instagram:</strong> <a href="https://www.instagram.com/DesperATE_Esp" class="text-orange-600 hover:underline">@DesperATE_Esp</a></li>
                        <li class="mb-2"><strong>Facebook:</strong> <a href="https://www.facebook.com/DesperATE_Esp" class="text-orange-600 hover:underline">DesperATE_Esp</a></li>
                        <li class="mb-2"><strong>X (Twitter):</strong> <a href="https://x.com/DesperATE_Esp" class="text-orange-600 hover:underline">@DesperATE_Esp</a></li>
                        <li class="mb-2"><strong>TikTok:</strong> <a href="https://www.tiktok.com/@DesperATE_Esp" class="text-orange-600 hover:underline">@DesperATE_Esp</a></li>
                    </ul>
                </div>
            </div>

            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="p-6">
                    <h2 class="text-2xl font-poppins font-semibold text-gray-800 mb-4">Envíanos un Mensaje</h2>
                    @if(session('status'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('status') }}
                        </div>
                    @endif
                    <form action="{{ route('contact.submit') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-gray-700 text-lg" for="name">Nombre</label>
                            <input type="text" id="name" name="name" class="w-full mt-2 p-3 border border-gray-300 rounded-lg focus:ring focus:ring-orange-300 bg-orange-500" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-lg" for="email">Correo Electrónico</label>
                            <input type="email" id="email" name="email" class="w-full mt-2 p-3 border border-gray-300 rounded-lg focus:ring focus:ring-orange-300 bg-orange-500" required>
                        </div>
                        <div>
                            <label class="block text-gray-700 text-lg" for="message">Mensaje</label>
                            <textarea id="message" name="message" rows="4" class="w-full mt-2 p-3 border border-gray-300 rounded-lg focus:ring focus:ring-orange-300 bg-orange-500" required></textarea>
                        </div>
                        <button type="submit" class="bg-orange-600 text-white py-3 px-6 rounded-lg font-semibold hover:bg-orange-700 transition">Enviar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</main>
@vite(['resources/js/app.js', 'resources/js/darklight.js'])
@endsection

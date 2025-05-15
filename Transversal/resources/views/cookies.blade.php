@extends('layouts.layout')

@section('content')
<main class="pt-28 pb-32 min-h-screen">
    <div class="container mx-auto px-6">
        <h1 class="text-4xl font-bold text-orange-600 text-center mt-16 mb-12">Política de Cookies</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-8">
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">¿Qué son las cookies?</h2>
                <p class="text-gray-700 leading-relaxed">Las cookies son pequeños archivos de texto que se almacenan en tu dispositivo cuando visitas un sitio web. Se utilizan para mejorar la experiencia del usuario, recordar preferencias y facilitar la navegación en el sitio. Algunas cookies son esenciales para el funcionamiento del sitio, mientras que otras permiten personalizar contenido y anuncios.</p>
            </div>
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Tipos de Cookies</h2>
                <p class="text-gray-700 leading-relaxed"><strong>Cookies esenciales:</strong> Son necesarias para el correcto funcionamiento del sitio web y no pueden desactivarse.</p>
                <p class="text-gray-700 leading-relaxed"><strong>Cookies de rendimiento:</strong> Nos ayudan a mejorar el sitio web analizando el comportamiento de los usuarios.</p>
                <p class="text-gray-700 leading-relaxed"><strong>Cookies de funcionalidad:</strong> Permiten recordar tus preferencias para mejorar tu experiencia.</p>
                <p class="text-gray-700 leading-relaxed"><strong>Cookies de publicidad y terceros:</strong> Utilizadas por redes de publicidad y servicios externos para mostrar anuncios relevantes.</p>
            </div>
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Gestión de Cookies</h2>
                <p class="text-gray-700 leading-relaxed">Puedes gestionar y eliminar cookies desde la configuración de tu navegador. La mayoría de los navegadores permiten bloquear o eliminar cookies específicas. Sin embargo, al deshabilitar algunas cookies, ciertas funciones del sitio pueden verse afectadas.</p>
                <p class="text-gray-700 leading-relaxed">Para gestionar las cookies en los navegadores más populares, consulta los siguientes enlaces:</p>
                <ul class="list-disc list-inside text-gray-700">
                    <li><a href="https://support.google.com/chrome/answer/95647" class="text-orange-600">Google Chrome</a></li>
                    <li><a href="https://support.mozilla.org/es/kb/habilitar-y-deshabilitar-cookies" class="text-orange-600">Mozilla Firefox</a></li>
            </div>
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Cookies de Terceros</h2>
                <p class="text-gray-700 leading-relaxed">En algunos casos, utilizamos cookies de terceros proporcionadas por servicios como Google Analytics para analizar el tráfico del sitio web y mejorar su funcionalidad. Estas cookies permiten recopilar información de forma anónima, como el número de visitantes o las páginas más populares.</p>
            </div>
            <div class="bg-white shadow-lg rounded-lg p-6 col-span-1 md:col-span-2 lg:col-span-2 flex justify-center">
                <div class="max-w-lg">
                    <h2 class="text-2xl font-semibold text-gray-800 mb-4 text-center">Más Información</h2>
                    <p class="text-gray-700 leading-relaxed text-center">Si tienes dudas sobre nuestra política de cookies o necesitas más información sobre cómo gestionarlas, puedes contactarnos en <a href="mailto:contacto@desperate.com" class="text-orange-600">contacto@desperate.com</a>.</p>
                </div>
            </div>
        </div>
    </div>
</main>
@vite(['resources/js/app.js', 'resources/js/darklight.js'])
@endsection

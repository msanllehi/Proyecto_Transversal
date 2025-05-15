@extends('layouts.layout')

@section('content')
<main class="pt-28 pb-32 min-h-screen">
    <div class="container mx-auto px-6">
        <h1 class="text-4xl font-bold text-orange-600 text-center mt-16 mb-12">Aviso Legal</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-8">
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Identificación del Responsable</h2>
                <p class="text-gray-700 leading-relaxed">DesperATE es una plataforma dedicada a la enseñanza culinaria en línea. Para cualquier consulta legal, puedes contactar con nosotros a través de nuestro correo electrónico: contacto@desperate.com.</p>
            </div>
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Propiedad Intelectual</h2>
                <p class="text-gray-700 leading-relaxed">Todo el contenido presente en esta web, incluyendo imágenes, textos y videos, está protegido por derechos de autor y no puede ser reproducido sin autorización expresa.</p>
            </div>
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Protección de Datos</h2>
                <p class="text-gray-700 leading-relaxed">Tus datos personales serán tratados conforme a nuestra política de privacidad. No compartiremos tu información con terceros sin tu consentimiento.</p>
            </div>
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Condiciones de Uso</h2>
                <p class="text-gray-700 leading-relaxed">Al acceder a nuestra web, aceptas nuestras condiciones de uso, que incluyen el respeto a las normas de la comunidad y el uso responsable de los recursos disponibles.</p>
            </div>
        </div>
    </div>
</main>
@vite(['resources/js/app.js', 'resources/js/darklight.js'])
@endsection

@extends('layouts.layout')

@section('content')
<main class="pt-28 pb-32 min-h-screen">
    <div class="container mx-auto px-6">
        <h1 class="text-4xl font-bold text-orange-600 text-center mt-16 mb-12">Política de Privacidad</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-8">
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Recolección de Datos</h2>
                <p class="text-gray-700 leading-relaxed">Recopilamos información personal solo con tu consentimiento y con fines de mejorar la experiencia del usuario en nuestra plataforma.</p>
            </div>
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Uso de la Información</h2>
                <p class="text-gray-700 leading-relaxed">Tus datos se utilizan exclusivamente para fines operativos y de comunicación. No los compartimos con terceros sin tu consentimiento.</p>
            </div>
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Protección y Seguridad</h2>
                <p class="text-gray-700 leading-relaxed">Implementamos medidas de seguridad avanzadas para proteger tu información contra accesos no autorizados.</p>
            </div>
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Derechos del Usuario</h2>
                <p class="text-gray-700 leading-relaxed">Tienes derecho a acceder, rectificar y eliminar tus datos personales en cualquier momento. Contáctanos para ejercer estos derechos.</p>
            </div>
        </div>
    </div>
</main>
@vite(['resources/js/app.js', 'resources/js/darklight.js'])
@endsection

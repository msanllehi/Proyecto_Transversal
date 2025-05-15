@extends('layouts.layout')

@section('content')
<main class="pt-28 pb-32 min-h-screen">
    <div class="container mx-auto px-6">
        <h1 class="text-4xl font-bold text-orange-600 text-center  mt-16 mb-12">Términos y Condiciones</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-8">
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Uso de la Plataforma</h2>
                <p class="text-gray-700 leading-relaxed">Al acceder y utilizar DesperATE, aceptas cumplir con nuestras normas y regulaciones. No se permite el uso indebido de la plataforma ni la difusión de contenido inapropiado.</p>
            </div>
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Registro y Cuentas</h2>
                <p class="text-gray-700 leading-relaxed">Para acceder a ciertos servicios, es necesario registrarse con información veraz y actualizada. Nos reservamos el derecho de suspender cuentas que infrinjan nuestras normas.</p>
            </div>
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Pagos y Reembolsos</h2>
                <p class="text-gray-700 leading-relaxed">Los cursos adquiridos en DesperATE son de pago único y no reembolsables, salvo en casos excepcionales bajo revisión del equipo de soporte.</p>
            </div>
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h2 class="text-2xl font-semibold text-gray-800 mb-4">Modificaciones en los Términos</h2>
                <p class="text-gray-700 leading-relaxed">Nos reservamos el derecho de modificar estos términos en cualquier momento. Los usuarios serán notificados sobre cambios importantes en nuestras condiciones de uso.</p>
            </div>
        </div>
    </div>
</main>
@vite(['resources/js/app.js', 'resources/js/darklight.js'])
@endsection

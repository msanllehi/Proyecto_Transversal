@extends('layouts.layout')

@section('content')
<main class="pt-28 pb-32 min-h-screen">
    <div class="max-w-7xl mx-auto px-6 py-16">
        <div class="text-center">
            <h1 class="text-4xl font-poppins font-bold text-orange-600 mb-4">Sobre DesperATE</h1>
            <!-- Descripción-->
            <p class="text-lg text-gray-700 leading-relaxed">En DesperATE somos una comunidad dedicada a hacer que la cocina sea accesible y divertida para todos. Creemos que cualquiera puede aprender a cocinar, sin importar su nivel de experiencia, y estamos aquí para guiarte en el proceso.</p>
        </div>
        <div class="flex justify-center items-center mt-6">
            <!-- Flecha hacia abajo izq -->
            <div class="mr-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
            </div>
            <div class="w-3/4">
            <!-- Video -->
            <video controls class="w-full h-auto">
                <source src="{{ asset('videos/Desperate.mp4') }}" type="video/mp4">
            </video>
            </div>
            <!-- Flecha hacia abajo der -->
            <div class="ml-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-700" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-8">
            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="p-6">
                    <!-- Subtítulo-->
                    <h2 class="text-2xl font-poppins font-semibold text-gray-800 mb-4">Nuestra Misión</h2>
                    <!-- Descripción-->
                    <p class="text-lg text-gray-700 leading-relaxed mb-4">Nacimos de la idea de que aprender a cocinar no debería ser complicado ni intimidante. Por eso, hemos creado una plataforma de cursos prácticos y directos, donde puedes avanzar a tu propio ritmo y elegir entre una variedad de temas, desde técnicas básicas hasta recetas internacionales.</p>
                    <p class="text-lg text-gray-700 leading-relaxed mb-4">Además, nuestra comunidad en línea ofrece un espacio para compartir logros y encontrar inspiración. Nos enorgullece hacer que el aprendizaje culinario sea simple, accesible y al día con las últimas tendencias.</p>
                </div>
            </div>

            <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                <div class="p-6">
                    <!-- Subtítulo-->
                    <h2 class="text-2xl font-poppins font-semibold text-gray-800 mb-4">Únete a Nosotros</h2>
                    <!-- Invitación a unirse -->
                    <p class="text-lg text-gray-700 leading-relaxed mb-4">En DesperATE, creemos que cocinar es más que una habilidad: es una forma de expresión y crecimiento personal. Únete a nuestra comunidad y despierta el chef que llevas dentro. Te ayudaremos a desarrollar tus habilidades culinarias mientras disfrutas del proceso.</p>
                </div>
            </div>
        </div>
    </div>
</main>
@vite(['resources/js/app.js', 'resources/js/darklight.js'])
@endsection
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>DesperATE</title>
    @vite('resources/css/app.css')
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Poppins:wght@600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
        }
        .font-poppins {
            font-family: 'Poppins', sans-serif;
        }
        /* CSS para el botón para cambiar de oscuro a claro y viceeversa */
        .mode-toggle {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: #f97316;
            color: white;
            border: none;
            border-radius: 50%;
            width: 50px;
            height: 50px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            z-index: 1000;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
        }

        .mode-toggle:hover {
            transform: scale(1.1);
        }

        /* Styles para el modo oscuro */
        body.dark-mode {
            background-color: #121212;
            color: #ffffff;
        }

        body.dark-mode main {
            background-color: #121212;
        }

        body.dark-mode h1, 
        body.dark-mode h2, 
        body.dark-mode h3 {
            color: #ffffff;
        }

        body.dark-mode p {
            color: #e0e0e0;
        }

        body.dark-mode .text-gray-900,
        body.dark-mode .text-gray-800 {
            color: #ffffff !important;
        }

        body.dark-mode .text-gray-600,
        body.dark-mode .text-gray-700 {
            color: #cccccc !important;
        }

        body.dark-mode .bg-orange-100 {
            background-color: #2c2c2c !important;
        }

        body.dark-mode .border-orange-600 {
            border-color: #f97316 !important;
        }

        body.dark-mode .text-orange-600 {
            color: #f97316 !important;
        }

        body.dark-mode .hover\:bg-orange-50:hover {
            background-color: #2c2c2c !important;
        }

        /* Estilos para las cards en modo oscuro */
        body.dark-mode .bg-white {
            background-color: #1e1e1e !important;
        }

        body.dark-mode .shadow-lg {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3), 0 4px 6px -2px rgba(0, 0, 0, 0.1) !important;
        }

        /* Estilos para las listas en modo oscuro */
        body.dark-mode ul.list-disc li {
            color: #cccccc !important;
        }
    </style>
<!-- Icono Sol y Luna para modo oscuro y claro -->
<button id="modeToggle" class="mode-toggle mt-4" title="Cambiar modo">
    <svg id="sunIcon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="block dark:hidden">
        <circle cx="12" cy="12" r="5"></circle>
        <line x1="12" y1="1" x2="12" y2="3"></line>
        <line x1="12" y1="21" x2="12" y2="23"></line>
        <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"></line>
        <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"></line>
        <line x1="1" y1="12" x2="3" y2="12"></line>
        <line x1="21" y1="12" x2="23" y2="12"></line>
        <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"></line>
        <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"></line>
    </svg>
    <svg id="moonIcon" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="hidden dark:block">
        <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"></path>
    </svg>
</button>
</head>
<body class="bg-white text-gray-900 flex flex-col min-h-screen {{ auth()->check() ? 'user-authenticated' : '' }}">

    <nav class="bg-gradient-to-r from-orange-700 via-orange-600 to-orange-500 p-6 shadow-md fixed top-0 left-0 w-full z-50">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <a href="/" class="text-3xl font-poppins font-bold text-white tracking-wide flex items-center gap-2">
                <img src="{{ asset('images/Desperate.png') }}" alt="Logo" class="h-10 inline">
            </a>
            
            <!-- Menú para pantallas medianas y grandes -->
            <div class="hidden md:flex space-x-4 lg:space-x-8 text-lg font-medium text-white items-center">
                <a href="/about" class="hover:text-green-400 transition duration-300">Presentación</a>
                <a href="/services" class="hover:text-green-400 transition duration-300">Servicios</a>
                <a href="/contact" class="hover:text-green-400 transition duration-300">Contacto</a>
                
                @auth
                <div class="relative" id="userMenu">
                    <button id="userMenuButton" class="hover:text-green-400 transition duration-300 flex items-center">
                        Mi Cuenta
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>
                    <div id="userMenuDropdown" class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg py-1 z-50 hidden transition-opacity duration-200">
                        <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-black dark:text-white dark:hover:bg-gray-700">Mi Perfil</a>
                        <a href="{{ route('orders.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-black dark:text-white dark:hover:bg-gray-700">Historial de Pedidos</a>
                        @if(Auth::user() && Auth::user()->role === 'admin')
                        <a href="/admin/dashboard" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-black dark:text-white dark:hover:bg-gray-700">Panel de Admin</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" class="block">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-black dark:text-white dark:hover:bg-gray-700">Cerrar sesión</button>
                        </form>
                    </div>
                </div>
                
                @vite(['resources/js/user-menu.js'])
                @else
                <a href="/register" class="bg-gradient-to-r from-green-600 via-green-500 to-green-600 text-white font-semibold px-4 py-2 rounded-md hover:from-green-500 hover:to-green-400 transition duration-300 cursor-pointer inline-flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/>
                        <circle cx="12" cy="7" r="4"/>
                    </svg>
                    Iniciar Sesión
                </a>
                @endauth
                
                <a href="/cart" class="inline-flex items-center hover:text-green-400 transition duration-300 relative">
                    <img src="{{ asset('images/carrito.png') }}" alt="Carrito" class="h-6 w-6"/>
                    <span id="cart-count-badge" class="absolute -top-2 -right-2 bg-green-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center shadow-lg border-2 border-white" style="display:none;">0</span>
                </a>
            </div>
            
            <!-- Botón de menú para móviles -->
            <div class="md:hidden flex items-center">
                <a href="/cart" class="mr-4 inline-flex items-center hover:text-green-400 transition duration-300 relative">
                    <img src="{{ asset('images/carrito.png') }}" alt="Carrito" class="h-6 w-6"/>
                    <span id="mobile-cart-count-badge" class="absolute -top-2 -right-2 bg-green-500 text-white text-xs font-bold rounded-full w-5 h-5 flex items-center justify-center shadow-lg border-2 border-white" style="display:none;">0</span>
                </a>
                <button id="mobile-menu-button" class="text-white focus:outline-none">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
        
        <!-- Menú móvil (oculto por defecto) -->
        <div id="mobile-menu" class="hidden md:hidden mt-4 pt-2 border-t border-orange-400">
            <div class="flex flex-col space-y-2 text-white">
                <a href="/about" class="py-2 hover:text-green-400 transition duration-300">Presentación</a>
                <a href="/services" class="py-2 hover:text-green-400 transition duration-300">Servicios</a>
                <a href="/contact" class="py-2 hover:text-green-400 transition duration-300">Contacto</a>
                
                @auth
                <a href="{{ route('profile.show') }}" class="py-2 hover:text-green-400 transition duration-300">Mi Perfil</a>
                <a href="{{ route('orders.index') }}" class="py-2 hover:text-green-400 transition duration-300">Historial</a>
                @if(Auth::user() && Auth::user()->role === 'admin')
                <a href="/admin/dashboard" class="py-2 hover:text-green-400 transition duration-300">Admin</a>
                @endif
                <form method="POST" action="{{ route('logout') }}" class="py-2">
                    @csrf
                    <button type="submit" class="text-white hover:text-green-400 transition duration-300">Cerrar sesión</button>
                </form>
                @else
                <a href="/register" class="py-2 hover:text-green-400 transition duration-300">Iniciar Sesión</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="flex-grow pb-16">
    @yield('content')
</main>

    <footer class="bg-gray-800 text-white text-center py-4 bottom-0 w-full">
        <div class="container mx-auto px-6">
            <p class="text-sm">
                &copy; 2025 DesperATE | 
                <a href="/legal" class="text-green-400 hover:text-white transition duration-300">Aviso Jurídico</a> | 
                <a href="/cookies" class="text-green-400 hover:text-white transition duration-300">Política de Cookies</a> | 
                <a href="/terms" class="text-green-400 hover:text-white transition duration-300">Términos y Condiciones</a> |
                <a href="/privacy" class="text-green-400 hover:text-white transition duration-300">Política de privacidad</a>
            </p>
        </div>
    </footer>
        
    @vite(['resources/js/app.js', 'resources/js/darklight.js', 'resources/js/comment-reminder.js'])
    @stack('scripts')
</body>
</html>

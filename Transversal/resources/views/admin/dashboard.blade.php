@extends('layouts.layout')
@section('content')
<main class="pt-28 pb-32">
<div class="container mx-auto pt-16">
    <div class="flex items-center justify-center">
        <h1 class="text-3xl font-bold mb-6">Panel de Administración</h1>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mb-8">
        <a href="{{ route('admin.products.index') }}" class="bg-orange-500 text-white rounded-lg p-8 flex flex-col items-center hover:bg-orange-600 transition">
            <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 7h18M3 12h18M3 17h18"/></svg>
            <span class="font-semibold">Productos</span>
        </a>
        <a href="{{ route('admin.users') }}" class="bg-green-500 text-white rounded-lg p-8 flex flex-col items-center hover:bg-green-600 transition">
            <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="7" r="4"/><path d="M5.5 21v-2A4.5 4.5 0 0 1 10 14.5h4A4.5 4.5 0 0 1 18.5 19v2"/></svg>
            <span class="font-semibold">Usuarios</span>
        </a>
        <a href="{{ route('admin.orders') }}" class="bg-blue-500 text-white rounded-lg p-8 flex flex-col items-center hover:bg-blue-600 transition">
            <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="7" width="18" height="13" rx="2"/><path d="M16 3v4M8 3v4M3 11h18"/></svg>
            <span class="font-semibold">Pedidos</span>
        </a>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-8">
        <a href="{{ route('admin.categories.index') }}" class="bg-purple-500 text-white rounded-lg p-8 flex flex-col items-center hover:bg-purple-600 transition">
            <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 20h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2h-7.93a2 2 0 0 1-1.66-.9l-.82-1.2A2 2 0 0 0 7.93 3H4a2 2 0 0 0-2 2v13c0 1.1.9 2 2 2Z"/></svg>
            <span class="font-semibold">Categorías</span>
        </a>
        <a href="{{ route('admin.subcategories.index') }}" class="bg-pink-500 text-white rounded-lg p-8 flex flex-col items-center hover:bg-pink-600 transition">
            <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"></path><path d="M12 10v6m-3-3h6"/></svg>
            <span class="font-semibold">Subcategorías</span>
        </a>
        <a href="{{ route('admin.sales') }}" class="bg-teal-500 text-white rounded-lg p-8 flex flex-col items-center hover:bg-teal-600 transition">
            <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 20V10M18 20V4M6 20v-4"/></svg>
            <span class="font-semibold">Ventas</span>
        </a>
    </div>
</div>
</main>
@endsection

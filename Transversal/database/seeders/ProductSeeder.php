<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener categorías y subcategorías
        $cocina = Category::where('name', 'Cocina')->first();
        $reposteria = Category::where('name', 'Repostería')->first();
        
        if (!$cocina || !$reposteria) {
            return; // Si no existen las categorías, no podemos continuar
        }
        
        $subcategoriaCocina = Subcategory::where('name', 'General')->where('category_id', $cocina->id)->first();
        $subcategoriaReposteria = Subcategory::where('name', 'General')->where('category_id', $reposteria->id)->first();
        
        if (!$subcategoriaCocina || !$subcategoriaReposteria) {
            return; // Si no existen las subcategorías, no podemos continuar
        }
        
        // Primero, asignar los productos existentes a las categorías correctas
        $reposteriaCourses = ['Curso de Reposteria Avanzada', 'Curso de Presentación'];
        
        // Asignar cursos de repostería a la categoría de repostería
        Product::whereIn('name', $reposteriaCourses)->update([
            'category_id' => $reposteria->id,
            'subcategory_id' => $subcategoriaReposteria->id
        ]);
        
        // Asignar el resto de cursos a la categoría de cocina
        Product::whereNotIn('name', $reposteriaCourses)->update([
            'category_id' => $cocina->id,
            'subcategory_id' => $subcategoriaCocina->id
        ]);
        
        // Productos a crear o actualizar
        $products = [
            [
                'name' => 'Curso de Cocina Avanzada',
                'description' => 'Descubre novedosas formas de cocina con nuestros chefs.',
                'price' => 99.95,
                'image' => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836',
                'stock' => 10,
                'category_id' => $cocina->id,
                'subcategory_id' => $subcategoriaCocina->id,
            ],
            [
                'name' => 'Curso de Presentación',
                'description' => 'Descubre a diseñar y decorar tu platillo como es debido.',
                'price' => 79.95,
                'image' => 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0',
                'stock' => 8,
                'category_id' => $reposteria->id,
                'subcategory_id' => $subcategoriaReposteria->id,
            ],
            [
                'name' => 'Curso de Cocción',
                'description' => 'Descubre el punto perfecto de la cocina.',
                'price' => 69.95,
                'image' => 'https://images.unsplash.com/photo-1600565193348-f74bd3c7ccdf?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'stock' => 15,
                'category_id' => $cocina->id,
                'subcategory_id' => $subcategoriaCocina->id,
            ],
            [
                'name' => 'Curso de Reposteria Avanzada',
                'description' => 'Descubre la dulzura de la reposteria.',
                'price' => 89.95,
                'image' => 'https://plus.unsplash.com/premium_photo-1667899297624-dd0a246b1384?q=80&w=1887&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'stock' => 12,
                'category_id' => $reposteria->id,
                'subcategory_id' => $subcategoriaReposteria->id,
            ],
            [
                'name' => 'Curso de Conserva y Elaboración',
                'description' => 'Descubre un mundo esencial de la vida de un chef.',
                'price' => 59.95,
                'image' => 'https://images.unsplash.com/photo-1498837167922-ddd27525d352?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'stock' => 20,
                'category_id' => $cocina->id,
                'subcategory_id' => $subcategoriaCocina->id,
            ],
            [
                'name' => 'Curso de Salsas',
                'description' => 'Descubre como darle vida a cualquier plato.',
                'price' => 49.95,
                'image' => 'https://images.unsplash.com/photo-1563599175592-c58dc214deff?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D',
                'stock' => 25,
                'category_id' => $cocina->id,
                'subcategory_id' => $subcategoriaCocina->id,
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                ['name' => $product['name']],
                $product
            );
        }
    }
}

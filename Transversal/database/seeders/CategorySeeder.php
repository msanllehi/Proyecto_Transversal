<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear solo las dos categorías necesarias si no existen
        $categories = [
            [
                'name' => 'Cocina',
                'description' => 'Cursos relacionados con la cocina y la gastronomía',
            ],
            [
                'name' => 'Repostería',
                'description' => 'Cursos relacionados con la repostería y la pastelería',
            ],
        ];

        // Eliminar todas las categorías que no sean Cocina o Repostería
        Category::whereNotIn('name', ['Cocina', 'Repostería'])->delete();

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['name' => $category['name']],
                $category
            );
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener las categorías
        $cocina = Category::where('name', 'Cocina')->first();
        $reposteria = Category::where('name', 'Repostería')->first();
        
        if ($cocina && $reposteria) {
            // Eliminar todas las subcategorías que no pertenezcan a las categorías que queremos mantener
            Subcategory::whereNotIn('category_id', [$cocina->id, $reposteria->id])->delete();
            
            // Subcategorías para Cocina
            $subcategoriesCocina = [
                [
                    'name' => 'General',
                    'description' => 'Cursos generales de cocina',
                    'category_id' => $cocina->id,
                ],
            ];
            
            // Subcategorías para Repostería
            $subcategoriesReposteria = [
                [
                    'name' => 'General',
                    'description' => 'Cursos generales de repostería',
                    'category_id' => $reposteria->id,
                ],
            ];
            
            // Crear subcategorías si no existen
            foreach ($subcategoriesCocina as $subcategory) {
                Subcategory::updateOrCreate(
                    [
                        'name' => $subcategory['name'],
                        'category_id' => $subcategory['category_id']
                    ],
                    $subcategory
                );
            }
            
            foreach ($subcategoriesReposteria as $subcategory) {
                Subcategory::updateOrCreate(
                    [
                        'name' => $subcategory['name'],
                        'category_id' => $subcategory['category_id']
                    ],
                    $subcategory
                );
            }
        }
    }
}

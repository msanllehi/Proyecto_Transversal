<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        
        Category::create($data);
        
        return redirect()->route('admin.categories.index')
            ->with('status', 'Categoria creada correctament!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return view('admin.categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        
        $category->update($data);
        
        return redirect()->route('admin.categories.index')
            ->with('status', 'Categoria actualitzada correctament!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        // Verificar si hay subcategorías asociadas
        if ($category->subcategories()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'No es pot eliminar una categoria amb subcategories associades!');
        }
        
        // Verificar si hay productos asociados
        if ($category->products()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'No es pot eliminar una categoria amb productes associats!');
        }
        
        $category->delete();
        
        return redirect()->route('admin.categories.index')
            ->with('status', 'Categoria eliminada correctament!');
    }
}

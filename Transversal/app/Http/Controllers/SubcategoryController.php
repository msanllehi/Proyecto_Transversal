<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subcategories = Subcategory::with('category')->get();
        return view('admin.subcategories.index', compact('subcategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.subcategories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
        ]);
        
        Subcategory::create($data);
        
        return redirect()->route('admin.subcategories.index')
            ->with('status', 'Subcategoria creada correctament!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Subcategory $subcategory)
    {
        return view('admin.subcategories.show', compact('subcategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Subcategory $subcategory)
    {
        $categories = Category::all();
        return view('admin.subcategories.edit', compact('subcategory', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Subcategory $subcategory)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
        ]);
        
        $subcategory->update($data);
        
        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Subcategoria actualitzada correctament!']);
        }
        
        return redirect()->route('admin.subcategories.index')
            ->with('status', 'Subcategoria actualitzada correctament!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Subcategory $subcategory)
    {
        // Verificar si hay productos asociados
        if ($subcategory->products()->count() > 0) {
            if (request()->ajax()) {
                return response()->json([
                    'success' => false, 
                    'message' => 'No es pot eliminar una subcategoria amb productes associats!'
                ], 422);
            }
            
            return redirect()->route('admin.subcategories.index')
                ->with('error', 'No es pot eliminar una subcategoria amb productes associats!');
        }
        
        $subcategory->delete();
        
        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Subcategoria eliminada correctament!']);
        }
        
        return redirect()->route('admin.subcategories.index')
            ->with('status', 'Subcategoria eliminada correctament!');
    }
    
    /**
     * Cambia la categoría de una subcategoría mediante AJAX
     */
    public function changeCategory(Request $request, Subcategory $subcategory)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
        ]);
        
        $subcategory->update([
            'category_id' => $request->category_id,
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Categoria actualitzada correctament!',
            'category_name' => $subcategory->category->name,
        ]);
    }
}

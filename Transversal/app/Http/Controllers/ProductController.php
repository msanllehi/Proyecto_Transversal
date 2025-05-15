<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index() {
        $products = Product::all();
        return view('admin.products.index', compact('products'));
    }
    public function create() {
        $categories = Category::all();
        $subcategories = Subcategory::all();
        return view('admin.products.create', compact('categories', 'subcategories'));
    }
    public function store(Request $request) {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|string|url',

            'category_id' => 'nullable|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
        ]);
        
        // Verificar que la subcategoría pertenezca a la categoría seleccionada
        if (!empty($data['category_id']) && !empty($data['subcategory_id'])) {
            $subcategory = Subcategory::find($data['subcategory_id']);
            if ($subcategory->category_id != $data['category_id']) {
                return redirect()->back()->withInput()->withErrors(['subcategory_id' => 'La subcategoría seleccionada no pertenece a la categoría seleccionada']);
            }
        }
        
        Product::create($data);
        return redirect()->route('admin.products.index')->with('status','Producte creat!');
    }
    public function edit(Product $product) {
        $categories = Category::all();
        $subcategories = Subcategory::all();
        return view('admin.products.edit', compact('product', 'categories', 'subcategories'));
    }
    public function update(Request $request, Product $product) {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|string|url',

            'category_id' => 'nullable|exists:categories,id',
            'subcategory_id' => 'nullable|exists:subcategories,id',
        ]);
        
        // Verificar que la subcategoría pertenezca a la categoría seleccionada
        if (!empty($data['category_id']) && !empty($data['subcategory_id'])) {
            $subcategory = Subcategory::find($data['subcategory_id']);
            if ($subcategory->category_id != $data['category_id']) {
                return redirect()->back()->withInput()->withErrors(['subcategory_id' => 'La subcategoría seleccionada no pertenece a la categoría seleccionada']);
            }
        }
        
        if ($request->ajax()) {
            $product->update($data);
            return response()->json(['success' => true, 'message' => 'Producte actualitzat correctament!']);
        }
        
        $product->update($data);
        return redirect()->route('admin.products.index')->with('status','Producte actualitzat!');
    }
    public function destroy(Product $product) {
        $product->delete();
        
        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Producte eliminat correctament!']);
        }
        
        return redirect()->route('admin.products.index')->with('status','Producte eliminat!');
    }
    

    
    /**
     * Obtiene las subcategorías de una categoría mediante AJAX
     */
    public function getSubcategories(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
        ]);
        
        $subcategories = Subcategory::where('category_id', $request->category_id)->get();
        
        return response()->json([
            'success' => true,
            'subcategories' => $subcategories,
        ]);
    }
    
    /**
     * Muestra los detalles de un producto incluyendo las valoraciones
     */
    public function show(Product $product)
    {
        // Obtener valoraciones desde la API de opiniones
        $opinions = $this->getProductOpinions($product->id);
        
        // Obtener valoración media del producto
        $averageRating = 0;
        $totalOpinions = 0;
        
        if (isset($opinions['data']) && !empty($opinions['data'])) {
            $totalOpinions = count($opinions['data']);
            $sumRatings = 0;
            
            foreach ($opinions['data'] as $opinion) {
                $sumRatings += $opinion['rating'];
            }
            
            $averageRating = $totalOpinions > 0 ? $sumRatings / $totalOpinions : 0;
        }
        
        return view('products.show', compact('product', 'opinions', 'averageRating', 'totalOpinions'));
    }
    
    /**
     * Obtiene las opiniones de un producto desde la API
     */
    private function getProductOpinions($productId)
    {
        try {
            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', env('OPINIONS_API_URL', 'http://localhost:8080') . '/api/opinions/' . $productId, [
                'headers' => ['Accept' => 'application/json'],
            ]);
            
            return json_decode($response->getBody(), true);
        } catch (\Exception $e) {
            // En caso de error, devolver un array vacío
            return ['success' => false, 'data' => [], 'message' => 'Error al obtener opiniones: ' . $e->getMessage()];
        }
    }
}

<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function dashboard()
    {
        return view('admin.dashboard');
    }

    // Product management (CRUD)
    public function index() { return view('admin.products.index', ['products' => Product::all()]); }
    public function create() { return view('admin.products.create'); }
    public function store(Request $request) {/*...*/}
    public function show(Product $product) { return view('admin.products.show', compact('product')); }
    public function edit(Product $product) { return view('admin.products.edit', compact('product')); }
    public function update(Request $request, Product $product) {/*...*/}
    public function destroy(Product $product) {/*...*/}

    // User management
    public function users() { return view('admin.users.index', ['users' => User::all()]); }
    
    public function editUser(User $user) { 
        return view('admin.users.edit', compact('user')); 
    }
    
    public function updateUser(Request $request, User $user) {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role' => 'required|in:user,admin',
            'birth_date' => 'nullable|date',
        ]);
        
        $user->update($data);
        
        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Usuario actualizado correctamente!']);
        }
        
        return redirect()->route('admin.users')->with('status', 'Usuario actualizado correctamente!');
    }
    
    public function destroyUser(User $user) {
        // No permitir eliminar al propio usuario administrador
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users')->with('error', '¡No puedes eliminar tu propio usuario!');
        }
        
        $user->delete();
        
        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => '¡Usuario eliminado correctamente!']);
        }
        
        return redirect()->route('admin.users')->with('status', '¡Usuario eliminado correctamente!');
    }

    // Orders management
    public function orders() { return view('admin.orders.index', ['orders' => Order::all()]); }
    
    public function showOrder(Order $order) {
        return view('admin.orders.show', ['order' => $order]);
    }
    
    public function updateOrder(Request $request, Order $order) {
        $data = $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);
        
        $order->update($data);
        
        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Pedido actualizado correctamente']);
        }
        
        return redirect()->route('admin.orders.show', $order)->with('status', 'Pedido actualizado correctamente');
    }
    
    public function destroyOrder(Order $order) {
        $order->delete();
        
        if (request()->ajax()) {
            return response()->json(['success' => true, 'message' => 'Pedido eliminado correctamente']);
        }
        
        return redirect()->route('admin.orders')->with('status', 'Pedido eliminado correctamente');
    }
    
    // Gestión de ventas
    public function sales(Request $request) {
        // Obtenemos todos los productos
        $products = Product::all();
        
        // Calcular las ventas de cada producto
        $productSales = [];
        
        foreach ($products as $product) {
            $sales = OrderItem::where('product_id', $product->id)
                ->join('orders', 'orders.id', '=', 'order_items.order_id')
                ->where(function($query) {
                    $query->where('orders.status', '!=', 'cancelled')
                          ->orWhereNull('orders.status');
                })
                ->sum('order_items.quantity');
            
            $productSales[$product->id] = $sales;
        }
        
        // Ordenar productos por ventas
        $sort = $request->query('sort', 'sales_desc'); // valor por defecto: mayor número de ventas primero
        
        if ($sort === 'sales_asc') {
            // Ordenar productos por ventas ascendente
            $products = $products->sortBy(function($product) use ($productSales) {
                return $productSales[$product->id] ?? 0;
            });
        } else {
            // Ordenar productos por ventas descendente (por defecto)
            $products = $products->sortByDesc(function($product) use ($productSales) {
                return $productSales[$product->id] ?? 0;
            });
        }
        
        // Preparar datos para el gráfico DESPUÉS de ordenar los productos
        $productNames = [];
        $salesData = [];
        $colors = ['lightgreen', 'red', 'green', 'magenta', 'blue', 'yellow'];
        $chartColors = [];
        $colorIndex = 0;
        
        foreach ($products as $product) {
            $sales = $productSales[$product->id] ?? 0;
            if ($sales > 0) {
                $productNames[] = $product->name;
                $salesData[] = $sales;
                $chartColors[] = $colors[$colorIndex % count($colors)];
                $colorIndex++;
            }
        }
        
        // Si es una solicitud AJAX, devolver solo los datos necesarios
        if ($request->ajax()) {
            // Filtrar productos para la tabla
            $graphProducts = [];
            foreach ($products as $product) {
                $sales = $productSales[$product->id] ?? 0;
                if ($sales > 0) {
                    $graphProducts[] = [
                        'id' => $product->id,
                        'name' => $product->name,
                        'sales' => $sales
                    ];
                }
            }
            
            return response()->json([
                'productNames' => $productNames,
                'salesData' => $salesData,
                'chartColors' => $chartColors,
                'tableData' => $graphProducts
            ]);
        }
        
        // Si es una solicitud normal, devolver la vista completa
        return view('admin.sales.index', [
            'products' => $products,
            'productSales' => $productSales,
            'productNames' => json_encode($productNames),
            'salesData' => json_encode($salesData),
            'chartColors' => json_encode($chartColors),
            'graphProducts' => array_filter($products->toArray(), function($product) use ($productSales) {
                return ($productSales[$product['id']] ?? 0) > 0;
            })
        ]);
    }
    
    // Aplicar descuento a todos los productos
    public function applyDiscount(Request $request) {
        $request->validate([
            'discount_percentage' => 'required|numeric|min:1|max:99'
        ]);
        
        $discountPercentage = $request->discount_percentage;
        $discountMultiplier = (100 - $discountPercentage) / 100;
        
        // Paso 1: Obtener todos los productos y sus nuevos precios antes de actualizarlos
        $products = Product::all();
        $productNewPrices = [];
        
        foreach ($products as $product) {
            $newPrice = $product->price * $discountMultiplier;
            $productNewPrices[$product->id] = round($newPrice, 2);
        }
        
        // Paso 2: Aplicar descuento a todos los productos
        DB::table('products')
            ->update([
                'price' => DB::raw("price * $discountMultiplier")
            ]);
        
        // Paso 3: Actualizar los items en los carritos de los usuarios
        $cartItems = \App\Models\CartItem::all();
        
        foreach ($cartItems as $item) {
            if (isset($productNewPrices[$item->product_id])) {
                $item->price = $productNewPrices[$item->product_id];
                $item->subtotal = $item->price * $item->quantity;
                $item->save();
            }
        }
        
        // Paso 4: Actualizar los totales de los carritos
        $carts = \App\Models\Cart::all();
        foreach ($carts as $cart) {
            $cart->updateTotal();
        }
            
        return redirect()->route('admin.sales')
            ->with('status', "Descuento del {$discountPercentage}% aplicado correctamente a todos los cursos y carritos.");
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderConfirmation;

class CheckoutController extends Controller
{
    public function index()
    {
        // Verificar que el usuario esté autenticado
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para realizar una compra');
        }
        
        // Obtener los datos del usuario autenticado
        $user = auth()->user();
        
        return view('checkout', compact('user'));
    }
    
    public function process(Request $request)
    {
        // Verificar que el usuario esté autenticado
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para realizar una compra');
        }
        
        // Validar los datos del formulario (solo los datos de la tarjeta)
        $validated = $request->validate([
            'card_number' => 'required|string|max:19',
            'card_expiry' => 'required|string|max:5',
            'card_cvv' => 'required|string|max:4',
            'card_holder' => 'required|string|max:255',
        ]);
        
        // Obtener los productos del carrito (simulado desde localStorage)
        // En una implementación real, esto vendría de la base de datos
        $cartItems = json_decode($request->input('cart_items', '[]'), true);
        
        if (empty($cartItems)) {
            return redirect()->route('cart')->with('error', 'Tu carrito está vacío');
        }
        
        // Calcular el total
        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        // Obtener los datos del usuario
        $user = auth()->user();
        
        // Crear la orden
        $order = new Order();
        $order->user_id = $user->id;
        $order->status = 'pending';
        $order->total = $total;
        
        // Guardar datos de envío usando los datos del usuario
        $shippingAddress = [
            'name' => $user->name,
            'phone' => $user->phone,
            'address' => $user->address,
            'city' => $user->city,
            'postal_code' => $user->postal_code,
        ];
        
        // Usar los datos de facturación del usuario
        if ($user->billing_address) {
            $billingAddress = [
                'name' => $user->name,
                'phone' => $user->phone,
                'address' => $user->billing_address,
                'city' => $user->city,
                'postal_code' => $user->postal_code,
            ];
            $order->billing_address = json_encode($billingAddress);
        }
        
        $order->shipping_address = json_encode($shippingAddress);
        
        // Para debugging
        \Log::info('Shipping Address: ' . $order->shipping_address);
        $order->payment_method = 'credit_card';
        
        // Guardar los últimos 4 dígitos de la tarjeta (por seguridad)
        $cardNumber = preg_replace('/\D/', '', $validated['card_number']);
        $order->card_number = substr($cardNumber, -4);
        
        $order->save();
        
        // Crear los items de la orden
        foreach ($cartItems as $item) {
            $product = Product::find($item['id']);
            
            if ($product) {
                $orderItem = new OrderItem();
                $orderItem->order_id = $order->id;
                $orderItem->product_id = $product->id;
                $orderItem->quantity = $item['quantity'];
                $orderItem->price = $product->price;
                $orderItem->subtotal = $product->price * $item['quantity'];
                
                // Verificar si la columna has_to_comment existe antes de usarla
                try {
                    $orderItem->has_to_comment = true; // Marcar como pendiente de comentario
                } catch (\Exception $e) {
                    // La columna no existe todavía, lo ignoramos por ahora
                    \Log::warning('Columna has_to_comment no encontrada en la tabla order_items');
                }
                
                $orderItem->save();
            }
        }
        
        // Enviar correo de confirmación
        try {
            Mail::to(auth()->user()->email)->send(new OrderConfirmation($order));
        } catch (\Exception $e) {
            // Log el error pero continuar con el proceso
            \Log::error('Error enviando correo de confirmación: ' . $e->getMessage());
        }
        
        // Redirigir a la página de confirmación
        return redirect()->route('checkout.confirmation', $order)->with('success', '¡Tu pedido ha sido procesado correctamente!');
    }
    
    public function confirmation(Order $order)
    {
        // Verificar que el usuario actual es el propietario de la orden
        if ($order->user_id !== auth()->id()) {
            abort(403);
        }
        
        return view('order-confirmation', compact('order'));
    }
}

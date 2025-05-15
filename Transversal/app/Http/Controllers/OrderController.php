<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Response;

class OrderController extends Controller
{
    public function index()
    {
        // Obtener los pedidos del usuario autenticado
        $orders = Order::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        
        // Devolver la vista con los pedidos (incluso si está vacío)
        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // Verificar que el pedido pertenece al usuario autenticado
        if ($order->user_id !== Auth::id()) {
            abort(403, 'No tienes permiso para ver este pedido');
        }
        
        // Comprobar si el pedido existe y tiene items
        if (!$order || !$order->orderItems || $order->orderItems->isEmpty()) {
            return redirect()->route('orders.index')
                ->with('error', 'El pedido solicitado no existe o no contiene productos');
        }
        
        return view('orders.show', compact('order'));
    }
    
    /**
     * Obtiene los productos pendientes de comentar para el usuario autenticado
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCommentReminders()
    {
        // Obtener los items de pedidos que el usuario debe comentar
        $itemsToComment = OrderItem::whereHas('order', function($query) {
            $query->where('user_id', Auth::id());
        })
        ->where('has_to_comment', true)
        ->whereNull('commented_at')
        ->with(['product', 'order'])
        ->get();
        
        // Formatear los datos para la respuesta
        $formattedItems = $itemsToComment->map(function($item) {
            return [
                'id' => $item->id,
                'product_id' => $item->product_id,
                'product_name' => $item->product->name,
                'product_image' => $item->product->image,
                'order_id' => $item->order_id,
                'order_date' => $item->order->created_at->format('d/m/Y'),
            ];
        });
        
        return Response::json([
            'has_items_to_comment' => $formattedItems->count() > 0,
            'items' => $formattedItems
        ]);
    }
    
    /**
     * Procesa la decisión del usuario sobre si desea comentar un producto
     *
     * @param Request $request
     * @param OrderItem $orderItem
     * @return \Illuminate\Http\JsonResponse
     */
    public function commentDecision(Request $request, OrderItem $orderItem)
    {
        // Verificar que el item pertenece al usuario autenticado
        if ($orderItem->order->user_id !== Auth::id()) {
            return Response::json(['success' => false, 'message' => 'No tienes permiso para realizar esta acción'], 403);
        }
        
        // Validar la decisión
        $request->validate([
            'decision' => 'required|in:comment,skip,postpone',
        ]);
        
        $decision = $request->input('decision');
        
        switch ($decision) {
            case 'comment':
                // El usuario quiere comentar - actualizamos el flag pero dejará de ser recordado cuando realmente comente
                // Marcamos como "en proceso de comentario" para no volver a preguntar inmediatamente
                $orderItem->has_to_comment = false;
                $orderItem->save();
                
                return Response::json([
                    'success' => true,
                    'redirect' => route('products.show', $orderItem->product_id) . '#opinion-form'
                ]);
                
            case 'skip':
                // El usuario no quiere comentar - actualizar flag
                $orderItem->has_to_comment = false;
                $orderItem->commented_at = now();
                $orderItem->save();
                return Response::json(['success' => true, 'message' => 'Has decidido no comentar este producto']);
                
            case 'postpone':
                // El usuario quiere ser recordado más tarde - no hacer nada
                return Response::json(['success' => true, 'message' => 'Te recordaremos más tarde']);
                
            default:
                return Response::json(['success' => false, 'message' => 'Decisión no válida'], 400);
        }
    }
}

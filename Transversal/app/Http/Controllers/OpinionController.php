<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GuzzleHttp\Client;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class OpinionController extends Controller
{
    /**
     * Envía una nueva opinión a la API de opiniones
     */
    public function store(Request $request, $productId)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        try {
            $client = new Client();
            $response = $client->request('POST', env('OPINIONS_API_URL', 'http://localhost:8080') . '/api/opinions/' . $productId, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'Accept' => 'application/json',
                ],
                'json' => [
                    'username' => $request->username,
                    'rating' => $request->rating,
                    'comment' => $request->comment,
                ],
            ]);
            
            $result = json_decode($response->getBody(), true);
            
            // Actualizar el estado de los commentarios pendientes para este producto
            if (Auth::check()) {
                $orderItems = OrderItem::whereHas('order', function($query) {
                    $query->where('user_id', Auth::id());
                })
                ->where('product_id', $productId)
                ->where('has_to_comment', true)
                ->whereNull('commented_at')
                ->get();
                
                foreach ($orderItems as $item) {
                    $item->has_to_comment = false;
                    $item->commented_at = now();
                    $item->save();
                }
            }
            
            if ($request->ajax()) {
                return response()->json($result);
            }
            
            return redirect()->back()->with('status', 'Tu opinión ha sido enviada correctamente.');
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => 'Error al enviar la opinión: ' . $e->getMessage()], 500);
            }
            
            return redirect()->back()->withErrors(['error' => 'Error al enviar la opinión: ' . $e->getMessage()]);
        }
    }
}

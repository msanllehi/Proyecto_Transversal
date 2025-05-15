<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    /**
     * Genera y descarga una factura en PDF para un pedido específico
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function download(Order $order)
    {
        // Verificar que el usuario actual es el propietario de la orden o es admin
        if ($order->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403);
        }
        
        $pdf = PDF::loadView('pdf.invoice', compact('order'));
        
        return $pdf->download('factura-' . $order->id . '.pdf');
    }
    
    /**
     * Muestra una vista previa de la factura en el navegador
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function preview(Order $order)
    {
        // Verificar que el usuario actual es el propietario de la orden o es admin
        if ($order->user_id !== auth()->id() && auth()->user()->role !== 'admin') {
            abort(403);
        }
        
        $pdf = PDF::loadView('pdf.invoice', compact('order'));
        
        return $pdf->stream('factura-' . $order->id . '.pdf');
    }
}

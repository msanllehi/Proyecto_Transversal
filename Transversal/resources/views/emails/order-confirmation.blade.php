<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Confirmación de pedido</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            padding: 20px 0;
            border-bottom: 1px solid #eee;
        }
        .logo {
            max-width: 150px;
        }
        h1 {
            color: #f97316;
            margin-top: 0;
        }
        .order-info {
            margin: 20px 0;
            padding: 15px;
            background-color: #f9f9f9;
            border-radius: 5px;
        }
        .order-items {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .order-items th, .order-items td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        .order-items th {
            background-color: #f5f5f5;
        }
        .total {
            text-align: right;
            font-weight: bold;
            font-size: 18px;
            margin-top: 20px;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            text-align: center;
            font-size: 12px;
            color: #777;
        }
        .button {
            display: inline-block;
            background-color: #f97316;
            color: white;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 20px;
        }
        .shipping-info {
            margin: 20px 0;
        }
        .shipping-info h3 {
            margin-bottom: 10px;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>¡Gracias por tu compra!</h1>
        <p>Hemos recibido tu pedido correctamente</p>
    </div>
    
    <div class="order-info">
        <p><strong>Número de pedido:</strong> #{{ $order->id }}</p>
        <p><strong>Fecha:</strong> {{ $order->created_at->format('d/m/Y H:i') }}</p>
        <p><strong>Estado:</strong> {{ ucfirst($order->status) }}</p>
    </div>
    
    <h2>Resumen de tu pedido</h2>
    
    <table class="order-items">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderItems as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->price, 2) }} €</td>
                <td>{{ number_format($item->subtotal, 2) }} €</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    
    <div class="total">
        Total: {{ number_format($order->total, 2) }} €
    </div>
    
    <div class="shipping-info">
        <h3>Información de envío</h3>
        @php
            $shippingAddress = json_decode($order->shipping_address, true);
        @endphp
        <p><strong>Nombre:</strong> {{ $shippingAddress['name'] }}</p>
        <p><strong>Dirección:</strong> {{ $shippingAddress['address'] }}</p>
        <p><strong>Ciudad:</strong> {{ $shippingAddress['city'] }}</p>
        <p><strong>Código postal:</strong> {{ $shippingAddress['postal_code'] }}</p>
        <p><strong>Teléfono:</strong> {{ $shippingAddress['phone'] }}</p>
    </div>
    
    <div style="text-align: center; margin-top: 30px;">
        <a href="{{ route('orders.show', $order) }}" class="button" style="background-color: #f97316; margin-right: 10px;">Ver detalles del pedido</a>
        <a href="{{ route('invoice.download', $order) }}" class="button" style="background-color: #3b82f6;">Descargar factura</a>
    </div>
    
    <div class="footer">
        <p>Si tienes alguna pregunta sobre tu pedido, no dudes en contactarnos.</p>
        <p>&copy; {{ date('Y') }} Tu Empresa. Todos los derechos reservados.</p>
    </div>
</body>
</html>

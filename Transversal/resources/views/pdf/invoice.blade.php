<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura #{{ $order->id }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&family=Poppins:wght@600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .font-poppins {
            font-family: 'Poppins', sans-serif;
        }
        .invoice-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .invoice-title {
            font-size: 24px;
            font-weight: bold;
            color: #f97316;
            margin-bottom: 5px;
        }
        .invoice-subtitle {
            font-size: 14px;
            color: #666;
        }
        .invoice-info {
            margin-bottom: 20px;
        }
        .invoice-info-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .invoice-info-label {
            font-weight: bold;
            width: 150px;
        }
        .invoice-info-value {
            flex: 1;
        }
        .invoice-details {
            margin-bottom: 30px;
        }
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .invoice-table th {
            background-color: #f5f5f5;
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .invoice-table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }
        .invoice-table .text-right {
            text-align: right;
        }
        .invoice-total {
            text-align: right;
            font-size: 18px;
            font-weight: bold;
            margin-top: 20px;
        }
        .invoice-footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #666;
        }
        .address-block {
            margin-bottom: 20px;
        }
        .address-title {
            font-weight: bold;
            margin-bottom: 5px;
        }
        .page-break {
            page-break-after: always;
        }
        .logo {
            max-width: 200px;
            margin-bottom: 20px;
        }
        .company-info {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <div class="invoice-header">
        <div class="invoice-title font-poppins">FACTURA</div>
        <div class="invoice-subtitle">Número de pedido: {{ $order->id }}</div>
        <div class="invoice-subtitle">Fecha: {{ $order->created_at->format('d/m/Y') }}</div>
    </div>
    
    <div class="company-info">
        <div style="font-weight: bold;">DESPERATE S.L.</div>
        <div>Calle Calafell, 123</div>
        <div>43820, Calafell</div>
        <div>NIF: B12345678</div>
        <div>Teléfono: 123 45 67 89</div>
        <div>Email: info@desperate.com</div>
    </div>
    
    <div class="invoice-info">
        
        <div class="address-block">
            <div class="address-title font-poppins">ENVIAR A:</div>
            @php
                $shippingAddress = json_decode($order->shipping_address, true);
                $billingAddress = json_decode($order->billing_address ?? $order->shipping_address, true);
            @endphp
            <div><strong>Nombre:</strong> {{ $shippingAddress['name'] }}</div>
            <div><strong>Dirección:</strong> {{ $shippingAddress['address'] }}</div>
            <div><strong>Código postal:</strong> {{ $shippingAddress['postal_code'] }}</div>
            <div><strong>Ciudad:</strong> {{ $shippingAddress['city'] }}</div>
            <div><strong>Teléfono:</strong> {{ $shippingAddress['phone'] }}</div>
        </div>
    </div>
    
    <div class="invoice-details">
        <table class="invoice-table">
            <thead>
                <tr>
                    <th>Producto</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order->orderItems as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td class="text-right">{{ number_format($item->price, 2) }} €</td>
                    <td class="text-right">{{ number_format($item->subtotal, 2) }} €</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        
        <div class="invoice-total">
            <div>Base imponible: {{ number_format($order->total / 1.21, 2) }} €</div>
            <div>IVA (21%): {{ number_format($order->total - ($order->total / 1.21), 2) }} €</div>
            <div style="font-size: 10px; color: #777;">Ya incluido en el precio del producto</div>
            <div style="font-size: 20px; margin-top: 10px;" class="font-poppins">TOTAL: {{ number_format($order->total, 2) }} €</div>
        </div>
    </div>
    
    <div class="invoice-footer">
        <p>Esta factura sirve como comprobante de pago. Gracias por su compra.</p>
        <p>Para cualquier consulta relacionada con esta factura, por favor contacte con nuestro servicio de atención al cliente.</p>
    </div>
</body>
</html>

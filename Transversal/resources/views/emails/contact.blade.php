<!DOCTYPE html>
<html>
<head>
    <title>Nuevo mensaje de contacto</title>
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
            background-color: #f97316;
            color: white;
            padding: 15px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .content {
            padding: 20px;
            border: 1px solid #ddd;
            border-top: none;
            border-radius: 0 0 5px 5px;
        }
        .field {
            margin-bottom: 15px;
        }
        .label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }
        .footer {
            text-align: center;
            margin-top: 20px;
            font-size: 0.8em;
            color: #666;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Nuevo mensaje de contacto</h1>
    </div>

    <div class="content">
        <div class="field">
            <span class="label">Nombre:</span>
            <span>{{ $data['name'] }}</span>
        </div>

        <div class="field">
            <span class="label">Email:</span>
            <span>{{ $data['email'] }}</span>
        </div>

        <div class="field">
            <span class="label">Mensaje:</span>
            <p>{{ $data['message'] }}</p>
        </div>
    </div>

    <div class="footer">
        <p>Este mensaje fue enviado desde el formulario de contacto de DesperATE.</p>
    </div>
</body>
</html>

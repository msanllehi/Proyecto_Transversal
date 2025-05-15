<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifica tu correo</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 0; }
        .container { background: #fff; max-width: 500px; margin: 40px auto; padding: 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); }
        .btn { background: #ff6600; color: #fff; padding: 10px 24px; border-radius: 4px; text-decoration: none; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <h2>¡Bienvenido/a a la tienda online!</h2>
        <p>Gracias por registrarte. Antes de poder acceder, debes verificar tu correo electrónico.</p>
        <p>
            <a href="{{ $url }}" class="btn">Verificar mi correo</a>
        </p>
        <p>Si no has solicitado este registro, ignora este mensaje.</p>
    </div>
</body>
</html>

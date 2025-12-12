<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Restablecer Contraseña - Olla y Sazón</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .header {
            background: linear-gradient(135deg, #0f1117 0%, #1a1a2e 100%);
            color: #ffd700;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 28px;
            font-weight: bold;
        }
        .header .icon {
            font-size: 40px;
            margin-bottom: 10px;
        }
        .content {
            padding: 40px 30px;
            color: #333;
            line-height: 1.6;
        }
        .content h2 {
            color: #333;
            margin-bottom: 20px;
        }
        .button {
            display: inline-block;
            background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
            color: #000;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            margin: 20px 0;
            text-align: center;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px 30px;
            text-align: center;
            color: #666;
            font-size: 14px;
        }
        .warning {
            background-color: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 15px;
            border-radius: 5px;
            margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="icon">🍽️</div>
            <h1>Olla y Sazón</h1>
            <p>Restablecer Contraseña</p>
        </div>
        
        <div class="content">
            <h2>¡Hola!</h2>
            
            <p>Recibiste este correo porque solicitaste restablecer la contraseña de tu cuenta en Olla y Sazón.</p>
            
            <div style="text-align: center;">
                <a href="{{ $url }}" class="button">Restablecer Contraseña</a>
            </div>
            
            <div class="warning">
                <strong>⚠️ Importante:</strong> Este enlace expirará en 60 minutos por seguridad.
            </div>
            
            <p>Si no solicitaste restablecer tu contraseña, puedes ignorar este correo de forma segura.</p>
            
            <p>Si tienes problemas haciendo clic en el botón, copia y pega la siguiente URL en tu navegador:</p>
            <p style="word-break: break-all; color: #666; font-size: 14px;">{{ $url }}</p>
        </div>
        
        <div class="footer">
            <p>© {{ date('Y') }} Olla y Sazón. Todos los derechos reservados.</p>
            <p>Este es un correo automático, por favor no respondas a este mensaje.</p>
        </div>
    </div>
</body>
</html>
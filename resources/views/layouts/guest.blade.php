<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

        <!-- Scripts -->
        <script src="https://cdn.tailwindcss.com"></script>
        <link rel="stylesheet" href="{{ asset('css/global-background.css') }}">
        @stack('styles')
    </head>
    <body class="font-sans antialiased">
        <div class="auth-container">
            <div class="auth-box">
                <div class="auth-logo">
                    <i class="fas fa-utensils"></i>
                    <h1>Olla y Sazón</h1>
                    <p>
                        @if(request()->routeIs('login'))
                            Inicia sesión en tu cuenta
                        @elseif(request()->routeIs('register'))
                            Crea tu cuenta
                        @elseif(request()->routeIs('password.request'))
                            Recuperar contraseña
                        @elseif(request()->routeIs('password.reset'))
                            Restablecer contraseña
                        @else
                            Bienvenido
                        @endif
                    </p>
                </div>
                {{ $slot }}
            </div>
        </div>

        <style>
        .auth-container {
            min-height: 100vh;
            background: linear-gradient(120deg, #fff 60%, #181828 100%);
            background-attachment: fixed;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .auth-box {
            background: linear-gradient(180deg, #111827 0%, #0b0f1a 100%);
            border: 2px solid rgba(255, 215, 0, 0.3);
            border-radius: 20px;
            padding: 40px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(255, 215, 0, 0.1) inset;
            backdrop-filter: blur(15px);
        }

        .auth-logo {
            text-align: center;
            margin-bottom: 30px;
        }

        .auth-logo i {
            font-size: 3rem;
            color: #ffd700;
            margin-bottom: 15px;
            display: block;
        }

        .auth-logo h1 {
            font-family: 'Playfair Display', serif;
            font-size: 2.2rem;
            font-weight: 700;
            color: #ffd700;
            margin: 0 0 10px 0;
        }

        .auth-logo p {
            color: #9ca3af;
            font-size: 1rem;
            margin: 0;
        }

        .register-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-group label {
            color: #e5e7eb;
            font-weight: 600;
            font-size: 0.9rem;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            padding: 14px 16px;
            border: 2px solid rgba(255, 215, 0, 0.2);
            border-radius: 10px;
            font-size: 1rem;
            background: rgba(0, 0, 0, 0.3);
            color: #ffffff;
            transition: all 0.3s ease;
        }

        .form-group input:focus,
        .form-group select:focus {
            outline: none;
            border-color: #ffd700;
            box-shadow: 0 0 0 3px rgba(255, 215, 0, 0.1);
            background: rgba(0, 0, 0, 0.5);
        }

        .form-group input::placeholder {
            color: #6b7280;
        }

        .submit-btn {
            background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
            color: #000;
            border: none;
            padding: 16px 24px;
            border-radius: 10px;
            font-size: 1.1rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .submit-btn:hover {
            background: linear-gradient(135deg, #ffed4e 0%, #ffd700 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(255, 215, 0, 0.3);
        }

        .terms {
            text-align: center;
            margin-top: 25px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 215, 0, 0.2);
        }

        .terms p {
            color: #9ca3af;
            font-size: 0.9rem;
            margin: 0;
        }

        .terms a {
            color: #ffd700;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .terms a:hover {
            color: #ffed4e;
        }

        .error-message {
            color: #ef4444;
            font-size: 0.8rem;
            margin-top: 5px;
        }

        .success-message {
            background: rgba(34, 197, 94, 0.1);
            border: 1px solid rgba(34, 197, 94, 0.3);
            color: #22c55e;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 0.9rem;
        }

        .forgot-password-link {
            text-align: center;
            margin-top: 15px;
        }

        .forgot-password-link a {
            color: #9ca3af;
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s ease;
        }

        .forgot-password-link a:hover {
            color: #ffd700;
        }

        /* Checkbox styling */
        input[type="checkbox"] {
            width: auto !important;
            margin-right: 8px;
        }

        /* Responsive */
        @media (max-width: 480px) {
            .auth-box {
                padding: 30px 20px;
                margin: 10px;
            }
            
            .auth-logo h1 {
                font-size: 1.8rem;
            }
        }
        </style>
        @stack('scripts')
    </body>
</html>

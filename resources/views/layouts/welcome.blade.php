<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }} - Olla y Sazón</title>
    
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    
    <link rel="stylesheet" href="{{ asset('css/home-original.css') }}">
    <link rel="stylesheet" href="{{ asset('css/global-background.css') }}">
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
            background: linear-gradient(120deg, #fff 60%, #181828 100%);
            background-attachment: fixed;
            color: white;
            text-align: center;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                radial-gradient(circle at 20% 30%, rgba(255, 255, 255, 0.3) 2px, transparent 2px),
                radial-gradient(circle at 80% 70%, rgba(255, 255, 255, 0.2) 3px, transparent 3px);
            z-index: -1;
            animation: bokeh 20s infinite linear;
        }
        
        @keyframes bokeh {
            0% { transform: translateX(0); }
            100% { transform: translateX(-100px); }
        }

        .circulos-principales {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 100px;
            padding: 100px;
            flex-wrap: wrap;
        }

        .circulo {
            position: relative;
            border-radius: 100%;
            overflow: hidden;
            text-align: center;
            font-weight: bold;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-shrink: 0;
        }

        .circulo img {
            position: absolute;
            width: 100%;
            height: 100%;
            object-fit: cover;
            z-index: 0;
        }

        .circulo span {
            position: relative;
            z-index: 1;
            text-shadow: 1px 1px 3px black;
            font-family: sans-serif;
            text-transform: uppercase;
            text-align: center;
            line-height: 1.2;
        }

        .circulo.small {
            width: 250px;
            height: 250px;
        }

        .circulo.small span {
            font-size: 20px;
            padding: 30px;
        }

        .circulo.central {
            width: 500px;
            height: 500px;
        }

        .circulo.central span {
            font-size: 40px;
            padding: 60px;
        }

        .bloques {
            display: flex;
            justify-content: center;
            gap: 50px;
            margin-bottom: 60px;
            flex-wrap: wrap;
        }

        .bloque {
            width: 500px;
            height: 300px;
            border-radius: 15px;
            display: flex;
            justify-content: center;
            align-items: center;
            text-decoration: none;
            color: white;
            font-size: 20px;
            font-weight: bold;
            transition: transform 0.3s;
        }

        .bloque:hover {
            transform: scale(1.05);
        }

        .bloque-contenedor {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .titulo-bloque {
            font-size: 40px;
            font-weight: bold;
            margin-bottom: 10px;
            color: white;
        }

        .bloque img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 15px;
        }

        .noticias {
            padding: 60px 30px;
            text-align: center;
            background-color: rgba(0, 0, 0, 0.8);
        }

        .section-title {
            font-size: 3em;
            color: gold;
            margin-bottom: 50px;
            text-transform: uppercase;
        }

        .cuadros-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
            gap: 40px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .cuadro {
            background-color: #1a1a1a;
            border: 2px solid gold;
            border-radius: 16px;
            padding: 25px;
            transition: transform 0.3s ease;
            position: relative;
            text-align: center;
        }

        .cuadro:hover {
            transform: scale(1.03);
            box-shadow: 0 0 25px gold;
        }

        .cuadro-icon {
            font-size: 2.8em;
            color: gold;
            margin-bottom: 18px;
        }

        .cuadro img {
            width: 100%;
            height: 240px;
            object-fit: cover;
            border-radius: 12px;
            margin-bottom: 15px;
        }

        .cuadro-content h3 {
            font-size: 1.8em;
            color: #fff;
            margin-bottom: 12px;
        }

        .cuadro-content p {
            font-size: 1.1em;
            color: #ddd;
            margin-bottom: 12px;
        }

        .cuadro-badge {
            background-color: gold;
            color: #000;
            font-size: 0.9em;
            font-weight: bold;
            padding: 6px 14px;
            border-radius: 20px;
            display: inline-block;
            margin-top: 8px;
        }

        .footer {
            background: #333;
            color: white;
            padding: 50px 30px 20px;
            font-size: 1.1rem;
            text-align: center;
        }

        .footer-content {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 3rem;
            margin-bottom: 2rem;
        }

        .footer-section {
            flex: 1 1 250px;
            max-width: 300px;
            margin: 0 auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .footer-section h3 {
            font-family: 'Playfair Display', serif;
            margin-bottom: 1rem;
            color: #d4a574;
            font-size: 1.4rem;
        }

        .footer-section p {
            color: #ccc;
            line-height: 1.8;
        }

        .info-item {
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
            gap: 10px;
        }

        .info-item img {
            width: 24px;
            height: 24px;
        }

        .social-links {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 12px;
            margin-top: 10px;
            flex-wrap: wrap;
        }

        .social-links img {
            width: 28px;
            height: 28px;
            object-fit: contain;
            transition: transform 0.3s ease;
        }

        .social-links img:hover {
            transform: scale(1.1);
        }

        .footer-bottom {
            text-align: center;
            border-top: 1px solid #444;
            padding-top: 15px;
            font-size: 0.95rem;
            color: #aaa;
        }

        .cuadro-link {
            text-decoration: none;
            color: inherit;
        }
    </style>
</head>
<body>
    @yield('content')
</body>
</html>
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
        
        <!-- Auth Styles -->
        @if(request()->routeIs('login'))
            <link rel="stylesheet" href="{{ asset('css/login.css') }}">
        @elseif(request()->routeIs('register'))
            <link rel="stylesheet" href="{{ asset('css/registro.css') }}">
        @endif

        <!-- Scripts -->
        <script src="https://cdn.tailwindcss.com"></script>
        @stack('styles')
    </head>
    <body class="font-sans text-gray-900 antialiased">
        @if(request()->routeIs('login') || request()->routeIs('register'))
            <div class="register-container">
                <div class="register-box">
                    <div class="logo">
                        <h1><i class="fas fa-utensils"></i> Restaurante</h1>
                        <p>{{ request()->routeIs('login') ? 'Inicia sesión en tu cuenta' : 'Crea tu cuenta' }}</p>
                    </div>
                    {{ $slot }}
                </div>
            </div>
        @else
            <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
                <div>
                    <a href="/" wire:navigate>
                        <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                    </a>
                </div>

                <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                    {{ $slot }}
                </div>
            </div>
        @endif
        @stack('scripts')
    </body>
</html>

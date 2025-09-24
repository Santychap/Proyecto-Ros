<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net" />
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600;700&family=Playfair+Display:wght@400;700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Tom Select CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select/dist/css/tom-select.css" rel="stylesheet" />

    <!-- Dashboard Styles -->
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/global-background.css') }}">

    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
    @stack('styles')
</head>
<body class="font-sans antialiased" style="background: linear-gradient(120deg, #fff 60%, #181828 100%); background-attachment: fixed; color: #181828;">
    <div class="min-h-screen bg-gray-100">
        <livewire:layout.navigation />

        @if (isset($header))
            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endif

        <main>
            @hasSection('content')
                @yield('content')
            @else
                {{ $slot }}
            @endif
        </main>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/tom-select/dist/js/tom-select.complete.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const userSelect = document.getElementById("user_id");
            if (userSelect) {
                new TomSelect(userSelect, {
                    create: false,
                    placeholder: "Buscar cliente por nombre o correo...",
                    sortField: {
                        field: "text",
                        direction: "asc"
                    }
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>

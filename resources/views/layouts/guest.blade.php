<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="grid min-h-screen lg:grid-cols-2">

            {{-- Image à gauche (masquée sur mobile) --}}
            <div class="relative hidden lg:block">
                <div class="absolute inset-0 bg-cover bg-center"
                     style="background-image:url('{{ asset('images/login-bg.jpg') }}');"></div>
            </div>

            {{-- Formulaire à droite --}}
            <div class="flex items-center justify-center bg-gray-50 px-6 py-12">
                <div class="w-full max-w-md">
                    <div class="mb-8 flex justify-center">
                        <a href="/"><img src="{{ asset('images/logo.png') }}" alt="{{ config('app.name', 'Karnou Agence') }}" class="h-10 w-auto"></a>
                    </div>

                    <div class="rounded-2xl bg-white p-8 shadow-sm ring-1 ring-gray-100 sm:p-10">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

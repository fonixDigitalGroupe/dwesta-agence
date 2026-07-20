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

            {{-- Image à gauche + texte (masquée sur mobile) --}}
            <div class="relative hidden lg:block">
                <div class="absolute inset-0 bg-cover bg-center"
                     style="background-image:url('{{ asset('images/login-bg.jpg') }}');"></div>
                {{-- Voile sombre pour la lisibilité du texte --}}
                <div class="absolute inset-0" style="background:linear-gradient(to top, rgba(0,0,0,0.65) 0%, rgba(0,0,0,0.15) 55%, rgba(0,0,0,0.05) 100%);"></div>
                {{-- Texte --}}
                <div class="absolute inset-x-0 bottom-0 p-12">
                    <h2 class="text-4xl font-bold leading-tight text-white" style="text-wrap:balance;">
                        Gérez votre agence<br>en toute simplicité
                    </h2>
                </div>
            </div>

            {{-- Formulaire à droite --}}
            <div class="flex items-center justify-center bg-gray-50 px-6 py-12">
                <div class="w-full max-w-md">
                    <div class="rounded-lg bg-white p-8 shadow-sm ring-1 ring-gray-100 sm:p-10">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

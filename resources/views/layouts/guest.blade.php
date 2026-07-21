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
                <div class="absolute inset-0" style="background:linear-gradient(to top, rgba(0,0,0,0.55) 0%, rgba(0,0,0,0.40) 50%, rgba(0,0,0,0.30) 100%);"></div>
                {{-- Marque en haut à gauche --}}
                <div class="absolute left-0 top-0 p-10">
                    <span class="text-2xl font-extrabold uppercase tracking-wide text-white">Karnou <span style="color:#FF6B00;">Agence</span></span>
                </div>
                {{-- Texte (centré verticalement) --}}
                <div class="absolute inset-0 flex flex-col justify-center p-12">
                    <div class="max-w-md">
                        <span class="text-xs font-semibold uppercase tracking-widest text-white/70">Portail Agence &amp; Points Relais</span>
                        <h2 class="mt-4 text-4xl font-bold leading-tight text-white" style="text-wrap:balance;">
                            Gérez votre agence en toute simplicité
                        </h2>
                        <p class="mt-4 text-lg leading-relaxed text-white/80">
                            Réception, suivi et remise de vos colis, paiements sécurisés, tout au même endroit.
                        </p>
                    </div>
                </div>
            </div>

            {{-- Formulaire à droite --}}
            <div class="flex items-center justify-center bg-white px-6 py-12">
                <div class="w-full max-w-md">
                    <div class="rounded-lg bg-white p-8 sm:p-10">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

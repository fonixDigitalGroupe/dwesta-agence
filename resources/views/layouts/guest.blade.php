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
        {{-- Header avec le logo Karnou (même que l'admin) --}}
        @php
            $karnouLogo = \App\Models\Setting::get('logo');
            $karnouLogoUrl = $karnouLogo
                ? rtrim(config('services.karnou_media_url', 'https://www.karnou.com/storage'), '/') . '/' . ltrim($karnouLogo, '/')
                : asset('images/logo.png');
        @endphp
        <header class="flex items-center justify-between border-b border-gray-200 bg-white px-6 py-3">
            <a href="/"><img src="{{ $karnouLogoUrl }}" alt="Karnou" class="h-8 w-auto"></a>
            <nav class="hidden items-center gap-7 sm:flex">
                <a href="https://www.karnou.com" target="_blank" rel="noopener" class="text-sm font-medium text-gray-600 transition hover:text-[#FF6B00]">Marketplace Karnou</a>
                <a href="https://www.karnou.com/contact" target="_blank" rel="noopener" class="text-sm font-medium text-gray-600 transition hover:text-[#FF6B00]">Contact</a>
                <a href="https://www.karnou.com/faq" target="_blank" rel="noopener" class="text-sm font-medium text-gray-600 transition hover:text-[#FF6B00]">Aide</a>
            </nav>
        </header>

        <div class="grid lg:grid-cols-2" style="min-height: calc(100vh - 58px);">

            {{-- Image à gauche + texte (masquée sur mobile) --}}
            <div class="relative hidden lg:block">
                <div class="absolute inset-0 bg-cover bg-center"
                     style="background-image:url('{{ asset('images/login-bg.jpg') }}');"></div>
                {{-- Voile sombre pour la lisibilité du texte --}}
                <div class="absolute inset-0" style="background:linear-gradient(to top, rgba(0,37,99,0.72) 0%, rgba(0,74,173,0.50) 55%, rgba(0,74,173,0.38) 100%);"></div>
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
            <div class="flex items-center justify-center bg-gray-100 px-6 py-12">
                <div class="w-full max-w-md">
                    <div class="rounded-xl bg-white p-8 shadow-sm ring-1 ring-gray-200 sm:p-10">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

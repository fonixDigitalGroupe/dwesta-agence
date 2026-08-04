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
        <style>[x-cloak]{display:none !important;}</style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        {{-- Header avec le logo Karnou (même que l'admin) --}}
        @php
            $karnouLogo = \App\Models\Setting::get('logo');
            $karnouLogoUrl = $karnouLogo
                ? rtrim(config('services.karnou_media_url', 'https://www.karnou.com/storage'), '/') . '/' . ltrim($karnouLogo, '/')
                : asset('images/logo.png');
        @endphp
        <header x-data="{ open: false }" class="relative flex items-center justify-between border-b border-gray-200 bg-white px-6 py-3">
            <a href="/"><img src="{{ $karnouLogoUrl }}" alt="Karnou" class="h-6 w-auto"></a>

            {{-- Bouton hamburger (mobile uniquement) --}}
            <button type="button" @click="open = !open" class="inline-flex items-center justify-center rounded-md p-2 text-gray-600 hover:bg-gray-100 hover:text-[#FF6B00] sm:hidden" aria-label="Menu">
                <svg x-show="!open" class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                <svg x-show="open" x-cloak class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>

            {{-- Menu déroulant mobile --}}
            <div x-show="open" x-cloak @click.outside="open = false" x-transition class="absolute right-4 top-full z-50 mt-1 w-56 overflow-hidden rounded-lg border border-gray-200 bg-white shadow-lg sm:hidden">
                <a href="https://www.karnou.com" target="_blank" rel="noopener" class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-[#FF6B00]">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                    Marketplace Karnou
                </a>
                <a href="https://www.karnou.com/contact" target="_blank" rel="noopener" class="flex items-center gap-3 border-t border-gray-100 px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-[#FF6B00]">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-10 5L2 7"/></svg>
                    Contact
                </a>
                <a href="https://www.karnou.com/faq" target="_blank" rel="noopener" class="flex items-center gap-3 border-t border-gray-100 px-4 py-3 text-sm font-medium text-gray-700 hover:bg-gray-50 hover:text-[#FF6B00]">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    Aide
                </a>
            </div>

            <nav class="hidden items-center gap-7 sm:flex">
                <a href="https://www.karnou.com" target="_blank" rel="noopener" class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 transition hover:text-[#FF6B00]">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"/><path d="M3 6h18"/><path d="M16 10a4 4 0 0 1-8 0"/></svg>
                    Marketplace Karnou
                </a>
                <a href="https://www.karnou.com/contact" target="_blank" rel="noopener" class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 transition hover:text-[#FF6B00]">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="2" y="4" width="20" height="16" rx="2"/><path d="m22 7-10 5L2 7"/></svg>
                    Contact
                </a>
                <a href="https://www.karnou.com/faq" target="_blank" rel="noopener" class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 transition hover:text-[#FF6B00]">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M9.09 9a3 3 0 0 1 5.83 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
                    Aide
                </a>
            </nav>
        </header>

        {{-- Fil d'Ariane sous le header, aligné à gauche --}}
        <nav class="flex items-center gap-1.5 border-b border-gray-100 bg-gray-100 px-6 py-2.5 text-xs text-gray-500">
            <a href="/" class="transition hover:text-[#FF6B00]">Accueil</a>
            <span class="text-gray-300">&rsaquo;</span>
            <span class="font-medium text-gray-700">Identification</span>
        </nav>

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

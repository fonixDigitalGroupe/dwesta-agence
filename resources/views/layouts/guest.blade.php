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
        <div class="min-h-screen grid lg:grid-cols-2">

            {{-- ===== Panneau visuel (gauche) : image d'entreprise africaine ===== --}}
            <div class="relative hidden lg:flex flex-col justify-between p-12 text-white overflow-hidden">
                {{-- Photo de fond : déposez votre image dans public/images/login-bg.jpg --}}
                <div class="absolute inset-0 bg-cover bg-center scale-105"
                     style="background-image:url('{{ asset('images/login-bg.jpg') }}');"></div>

                {{-- Teinte bleu marque en fusion "multiply" : la photo reste visible mais bleutée --}}
                <div class="absolute inset-0" style="background:#004aad; mix-blend-mode:multiply; opacity:0.82;"></div>

                {{-- Assombrissement bas → haut pour garder le texte lisible --}}
                <div class="absolute inset-0"
                     style="background:linear-gradient(to top, rgba(0,25,66,0.88) 0%, rgba(0,42,110,0.35) 45%, rgba(0,74,173,0.15) 100%);"></div>

                {{-- Marque --}}
                <div class="relative z-10 flex items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-11 w-11 rounded-lg object-contain bg-white/10 p-1 backdrop-blur">
                    <span class="text-xl font-semibold tracking-tight">{{ config('app.name', 'Dwesta') }}</span>
                </div>

                {{-- Message principal --}}
                <div class="relative z-10 max-w-md">
                    <h1 class="text-4xl font-bold leading-tight tracking-tight">
                        Votre portail agence,<br>en toute confiance.
                    </h1>
                    <p class="mt-4 text-white/80 leading-relaxed">
                        Gérez vos annonces, vos points relais et vos clients depuis une plateforme
                        pensée pour les professionnels africains.
                    </p>

                    <ul class="mt-8 space-y-3 text-sm text-white/90">
                        <li class="flex items-center gap-3">
                            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-brand-orange/20 text-brand-orange">✓</span>
                            Gestion centralisée de vos annonces
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-brand-orange/20 text-brand-orange">✓</span>
                            Suivi des points relais et livraisons
                        </li>
                        <li class="flex items-center gap-3">
                            <span class="flex h-6 w-6 items-center justify-center rounded-full bg-brand-orange/20 text-brand-orange">✓</span>
                            Paiements sécurisés & séquestre
                        </li>
                    </ul>
                </div>

                {{-- Pied --}}
                <div class="relative z-10 text-xs text-white/60">
                    © {{ date('Y') }} {{ config('app.name', 'Dwesta') }}. Tous droits réservés.
                </div>
            </div>

            {{-- ===== Formulaire (droite) ===== --}}
            <div class="flex items-center justify-center bg-gray-50 px-6 py-12 sm:px-12">
                <div class="w-full max-w-md">
                    {{-- Logo visible sur mobile (où le panneau de gauche est masqué) --}}
                    <div class="mb-8 flex items-center gap-3 lg:hidden">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="h-10 w-10 object-contain">
                        <span class="text-lg font-semibold text-gray-900">{{ config('app.name', 'Dwesta') }}</span>
                    </div>

                    <div class="rounded-2xl bg-white p-8 shadow-sm ring-1 ring-gray-100 sm:p-10">
                        {{ $slot }}
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>

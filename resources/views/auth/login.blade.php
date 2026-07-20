<x-guest-layout>
    <!-- En-tête -->
    <div class="mb-8">
        <h2 class="text-2xl font-bold tracking-tight text-gray-900">Bon retour 👋</h2>
        <p class="mt-1 text-sm text-gray-500">Connectez-vous pour accéder à votre espace agence.</p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Adresse e-mail')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="vous@exemple.com" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between">
                <x-input-label for="password" :value="__('Mot de passe')" />
                @if (Route::has('password.request'))
                    <a class="text-sm font-medium text-brand-blue hover:text-brand-blue-dark" href="{{ route('password.request') }}">
                        {{ __('Mot de passe oublié ?') }}
                    </a>
                @endif
            </div>

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password"
                            placeholder="••••••••" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <label for="remember_me" class="inline-flex items-center">
            <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-brand-blue shadow-sm focus:ring-brand-blue" name="remember">
            <span class="ms-2 text-sm text-gray-600">{{ __('Se souvenir de moi') }}</span>
        </label>

        <!-- Bouton pleine largeur -->
        <button type="submit"
                class="flex w-full items-center justify-center rounded-lg bg-gradient-to-r from-brand-orange to-brand-orange-dark px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:brightness-105 focus:outline-none focus:ring-2 focus:ring-brand-orange focus:ring-offset-2">
            {{ __('Se connecter') }}
        </button>

        @if (Route::has('register'))
            <p class="text-center text-sm text-gray-500">
                Pas encore de compte ?
                <a href="{{ route('register') }}" class="font-semibold text-brand-blue hover:text-brand-blue-dark">Créer un compte</a>
            </p>
        @endif
    </form>
</x-guest-layout>

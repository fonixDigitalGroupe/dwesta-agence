<x-guest-layout breadcrumb="Mot de passe oublié">
    {{-- Titre de section (style Karnou : titre + filet sous le texte) --}}
    <h2 class="mb-4 border-b border-gray-100 pb-3 text-lg font-bold text-gray-900">Mot de passe oublié</h2>

    <p class="mb-6 text-sm leading-relaxed text-gray-600">
        Vous avez oublié votre mot de passe ? Aucun problème. Indiquez votre adresse e-mail
        et nous vous enverrons un lien permettant d'en choisir un nouveau.
    </p>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
        @csrf

        {{-- E-mail (label flottant) --}}
        <div>
            <div class="relative">
                <input id="email" name="email" type="email" placeholder=" " required autofocus autocomplete="username" value="{{ old('email') }}"
                       class="peer w-full rounded border border-gray-300 bg-white px-3 pb-2 pt-5 text-sm text-gray-900 outline-none transition focus:border-gray-400 focus:ring-0" />
                <label for="email"
                       class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-sm text-gray-500 transition-all
                              peer-focus:top-2 peer-focus:translate-y-0 peer-focus:text-xs peer-focus:font-semibold peer-focus:text-gray-800
                              peer-[:not(:placeholder-shown)]:top-2 peer-[:not(:placeholder-shown)]:translate-y-0 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:font-semibold peer-[:not(:placeholder-shown)]:text-gray-700">
                    E-mail
                </label>
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <button type="submit" class="w-full rounded bg-[#FF6B00] px-4 py-3 text-sm font-semibold text-white transition hover:bg-[#e65f00]">
            Envoyer le lien de réinitialisation
        </button>

        <p class="text-center text-sm text-gray-600">
            <a href="{{ route('login') }}" class="font-medium text-[#FF6B00] hover:underline">Retour à la connexion</a>
        </p>
    </form>
</x-guest-layout>

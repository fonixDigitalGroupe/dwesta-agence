<x-guest-layout>
    {{-- Titre de section (style Karnou : titre + filet sous le texte) --}}
    <h2 class="mb-6 border-b border-gray-100 pb-3 text-lg font-bold text-gray-900">Identification</h2>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        {{-- E-mail (label flottant) --}}
        <div>
            <div class="relative">
                <input id="email" name="email" type="email" placeholder=" " required autofocus autocomplete="username" value="{{ old('email') }}"
                       class="peer w-full rounded border border-gray-300 bg-white px-3 pb-2 pt-5 text-sm text-gray-900 outline-none transition focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/10" />
                <label for="email"
                       class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-sm text-gray-500 transition-all
                              peer-focus:top-2 peer-focus:translate-y-0 peer-focus:text-xs peer-focus:font-semibold peer-focus:text-brand-blue
                              peer-[:not(:placeholder-shown)]:top-2 peer-[:not(:placeholder-shown)]:translate-y-0 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:font-semibold peer-[:not(:placeholder-shown)]:text-gray-700">
                    E-mail
                </label>
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        {{-- Mot de passe (label flottant + œil afficher/masquer) --}}
        <div>
            <div class="relative">
                <input id="password" name="password" type="password" placeholder=" " required autocomplete="current-password"
                       class="peer w-full rounded border border-gray-300 bg-white px-3 pb-2 pt-5 pr-11 text-sm text-gray-900 outline-none transition focus:border-brand-blue focus:ring-2 focus:ring-brand-blue/10" />
                <label for="password"
                       class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-sm text-gray-500 transition-all
                              peer-focus:top-2 peer-focus:translate-y-0 peer-focus:text-xs peer-focus:font-semibold peer-focus:text-brand-blue
                              peer-[:not(:placeholder-shown)]:top-2 peer-[:not(:placeholder-shown)]:translate-y-0 peer-[:not(:placeholder-shown)]:text-xs peer-[:not(:placeholder-shown)]:font-semibold peer-[:not(:placeholder-shown)]:text-gray-700">
                    Mot de passe
                </label>
                <button type="button" title="Afficher / masquer"
                        onclick="const p=document.getElementById('password'); p.type = p.type==='password' ? 'text' : 'password';"
                        class="absolute right-2 top-1/2 -translate-y-1/2 flex items-center rounded p-1.5 text-gray-500 transition hover:bg-brand-blue/5 hover:text-brand-blue">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                        <circle cx="12" cy="12" r="3"></circle>
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        {{-- Mot de passe oublié (orange, style Karnou) --}}
        @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="inline-block text-sm font-medium text-brand-orange hover:underline">
                J'ai oublié mon mot de passe
            </a>
        @endif

        {{-- Se souvenir de moi --}}
        <label for="remember_me" class="flex items-center">
            <input id="remember_me" type="checkbox" name="remember" class="rounded border-gray-300 text-brand-blue shadow-sm focus:ring-brand-blue">
            <span class="ms-2 text-sm text-gray-600">Rester connecté</span>
        </label>

        {{-- Bouton bleu (style Karnou) --}}
        <div>
            <button type="submit"
                    class="inline-flex w-full items-center justify-center rounded bg-[#0071BC] px-8 py-3.5 text-sm font-bold text-white transition hover:bg-[#005b96] hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-[#0071BC] focus:ring-offset-2">
                Me connecter
            </button>
        </div>
    </form>
</x-guest-layout>

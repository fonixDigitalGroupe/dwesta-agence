<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- En-tête --}}
            <div class="mb-6 flex flex-wrap items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-bold text-slate-900">Tableau de bord</h1>
                    <p class="text-sm text-slate-500 mt-1">{{ $currentAgency->nom ?? 'Votre agence' }}</p>
                </div>
                <a href="{{ route('operations.stock') }}"
                   class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg bg-[#004aad] text-white text-sm font-semibold hover:bg-[#003a8a] transition">
                    <i class="fas fa-warehouse"></i> Gérer le stock
                </a>
            </div>

            @php
                $nExpected = $expectedPackages->count();
                $nStock    = $inStockPackages->count();
                $nTotal    = $nExpected + $nStock;
            @endphp

            {{-- Cartes KPI --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
                {{-- Colis attendus --}}
                <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Colis attendus</p>
                            <p class="mt-2 text-3xl font-black text-slate-900">{{ $nExpected }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-lg bg-blue-50 text-[#004aad] flex items-center justify-center text-xl"><i class="fas fa-truck"></i></div>
                    </div>
                    <a href="{{ route('operations.stock', ['tab' => 'incoming']) }}" class="mt-3 inline-block text-xs font-semibold text-[#004aad]">Voir les arrivées →</a>
                </div>

                {{-- En stock --}}
                <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Colis en stock</p>
                            <p class="mt-2 text-3xl font-black text-slate-900">{{ $nStock }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-lg bg-orange-50 text-[#FF6B00] flex items-center justify-center text-xl"><i class="fas fa-boxes-stacked"></i></div>
                    </div>
                    <a href="{{ route('operations.stock', ['tab' => 'stock']) }}" class="mt-3 inline-block text-xs font-semibold text-[#FF6B00]">Voir le stock →</a>
                </div>

                {{-- Total à traiter --}}
                <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">À traiter</p>
                            <p class="mt-2 text-3xl font-black text-slate-900">{{ $nTotal }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-lg bg-slate-100 text-slate-700 flex items-center justify-center text-xl"><i class="fas fa-clipboard-list"></i></div>
                    </div>
                    <p class="mt-3 text-xs text-slate-400">Attendus + en stock</p>
                </div>
            </div>

            {{-- Listes --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- Colis en stock --}}
                <div class="bg-white border border-slate-200 rounded-xl shadow-sm">
                    <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                        <h2 class="font-bold text-slate-900">Colis en stock</h2>
                        <a href="{{ route('operations.stock', ['tab' => 'stock']) }}" class="text-xs font-semibold text-[#004aad]">Tout voir →</a>
                    </div>
                    <div class="divide-y divide-slate-100">
                        @forelse($inStockPackages->take(6) as $order)
                            <div class="px-5 py-3 flex items-center justify-between gap-3">
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-slate-900 truncate">{{ $order->reference }}</p>
                                    <p class="text-xs text-slate-500 truncate">
                                        {{ $order->buyer->prenom ?? '' }} {{ $order->buyer->nom ?? $order->buyer->name ?? '' }}
                                        @if($order->buyer->telephone ?? false) · {{ $order->buyer->telephone }} @endif
                                    </p>
                                </div>
                                <span class="text-xs text-slate-400 whitespace-nowrap">{{ $order->created_at->format('d/m/Y') }}</span>
                            </div>
                        @empty
                            <div class="px-5 py-10 text-center text-sm text-slate-400">Aucun colis en stock.</div>
                        @endforelse
                    </div>
                </div>

                {{-- Dernières remises --}}
                <div class="bg-white border border-slate-200 rounded-xl shadow-sm">
                    <div class="px-5 py-4 border-b border-slate-100 flex items-center justify-between">
                        <h2 class="font-bold text-slate-900">Dernières remises</h2>
                        <a href="{{ route('operations.stock', ['tab' => 'history']) }}" class="text-xs font-semibold text-[#004aad]">Historique →</a>
                    </div>
                    <div class="divide-y divide-slate-100">
                        @forelse($recentReleases as $order)
                            <div class="px-5 py-3 flex items-center justify-between gap-3">
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-slate-900 truncate">{{ $order->reference }}</p>
                                    <p class="text-xs text-slate-500 truncate">
                                        {{ $order->buyer->prenom ?? '' }} {{ $order->buyer->nom ?? $order->buyer->name ?? '' }}
                                    </p>
                                </div>
                                <span class="text-xs font-medium text-green-600 whitespace-nowrap">Livré</span>
                            </div>
                        @empty
                            <div class="px-5 py-10 text-center text-sm text-slate-400">Aucune remise récente.</div>
                        @endforelse
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>

<x-app-layout>
    <div class="max-w-7xl mx-auto">

        <h1 class="text-xl font-bold text-slate-900 mb-5">Statistiques</h1>

        {{-- Filtres (automatiques) --}}
        <form method="GET" class="bg-white border border-slate-200 rounded-xl p-4 mb-6">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 items-end">
                <div>
                    <label class="block text-xs font-semibold text-slate-500 mb-1">Date de début</label>
                    <input type="date" name="date_debut" value="{{ $start }}" onchange="this.form.submit()" class="w-full rounded-lg border-slate-300 text-sm focus:border-slate-400 focus:ring-0">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 mb-1">Date de fin</label>
                    <input type="date" name="date_fin" value="{{ $end }}" onchange="this.form.submit()" class="w-full rounded-lg border-slate-300 text-sm focus:border-slate-400 focus:ring-0">
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-500 mb-1">Statut</label>
                    <select name="statut" onchange="this.form.submit()" class="w-full rounded-lg border-slate-300 text-sm focus:border-slate-400 focus:ring-0">
                        <option value="tous" {{ $statut == 'tous' ? 'selected' : '' }}>Tous</option>
                        <option value="approche" {{ $statut == 'approche' ? 'selected' : '' }}>En approche</option>
                        <option value="stock" {{ $statut == 'stock' ? 'selected' : '' }}>En stock</option>
                        <option value="livre" {{ $statut == 'livre' ? 'selected' : '' }}>Livrés</option>
                        <option value="litige" {{ $statut == 'litige' ? 'selected' : '' }}>Signalés</option>
                    </select>
                </div>
            </div>
        </form>

        {{-- Cartes récap (style dashboard) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
            <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">En approche</p>
                        <p class="mt-2 text-3xl font-black text-slate-900">{{ $counts['approche'] }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-blue-50 text-[#004aad] flex items-center justify-center text-xl"><i class="fas fa-truck"></i></div>
                </div>
            </div>
            <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">En stock</p>
                        <p class="mt-2 text-3xl font-black text-slate-900">{{ $counts['stock'] }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-orange-50 text-[#FF6B00] flex items-center justify-center text-xl"><i class="fas fa-boxes-stacked"></i></div>
                </div>
            </div>
            <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Livrés</p>
                        <p class="mt-2 text-3xl font-black text-slate-900">{{ $counts['livre'] }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-green-50 text-green-600 flex items-center justify-center text-xl"><i class="fas fa-circle-check"></i></div>
                </div>
            </div>
            <div class="bg-white border border-slate-200 rounded-xl p-5 shadow-sm">
                <div class="flex items-start justify-between">
                    <div>
                        <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">Signalés</p>
                        <p class="mt-2 text-3xl font-black text-slate-900">{{ $counts['litige'] }}</p>
                    </div>
                    <div class="w-12 h-12 rounded-lg bg-red-50 text-red-600 flex items-center justify-center text-xl"><i class="fas fa-triangle-exclamation"></i></div>
                </div>
            </div>
        </div>

        {{-- Tableau --}}
        <div class="bg-white border border-slate-200 rounded-xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 text-slate-500 text-xs uppercase">
                            <th class="text-left font-semibold px-4 py-3">Référence</th>
                            <th class="text-left font-semibold px-4 py-3">Client</th>
                            <th class="text-left font-semibold px-4 py-3">Statut</th>
                            <th class="text-left font-semibold px-4 py-3">Traité par</th>
                            <th class="text-left font-semibold px-4 py-3">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($orders ?? [] as $order)
                            @php
                                $cat = in_array($order->statut, ['en_attente','paye','pret_expedition','en_route']) ? 'approche'
                                     : ($order->statut === 'disponible' ? 'stock'
                                     : ($order->statut === 'livre' ? 'livre'
                                     : ($order->statut === 'litige' ? 'litige' : 'autre')));
                                $badges = [
                                    'approche' => ['En approche', 'bg-blue-50 text-blue-700'],
                                    'stock'    => ['En stock', 'bg-orange-50 text-[#b8560f]'],
                                    'livre'    => ['Livré', 'bg-green-50 text-green-700'],
                                    'litige'   => ['Signalé', 'bg-red-50 text-red-600'],
                                    'autre'    => [ucfirst(str_replace('_',' ',$order->statut)), 'bg-slate-100 text-slate-600'],
                                ];
                                [$bLabel, $bClass] = $badges[$cat];
                                $agentUser = match($cat) {
                                    'stock'  => $order->receivedBy,
                                    'livre'  => $order->deliveredBy,
                                    'litige' => optional($order->litiges->firstWhere('statut', 'en_cours'))->reporter,
                                    default  => null,
                                };
                                $agentName = $agentUser ? (trim(($agentUser->prenom ?? '').' '.($agentUser->nom ?? $agentUser->name ?? '')) ?: '—') : '—';
                            @endphp
                            <tr class="hover:bg-slate-50">
                                <td class="px-4 py-3 font-medium text-slate-800">{{ $order->reference }}</td>
                                <td class="px-4 py-3 text-slate-600">
                                    {{ trim(($order->buyer->prenom ?? '').' '.($order->buyer->nom ?? $order->buyer->name ?? '')) ?: '—' }}
                                    <div class="text-xs text-slate-400">{{ $order->buyer->telephone ?? '' }}</div>
                                </td>
                                <td class="px-4 py-3"><span class="{{ $bClass }} px-2.5 py-1 rounded-md text-xs font-semibold">{{ $bLabel }}</span></td>
                                <td class="px-4 py-3 text-slate-600">{{ $agentName }}</td>
                                <td class="px-4 py-3 text-slate-500 whitespace-nowrap">{{ $order->created_at->format('d/m/Y') }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="px-4 py-12 text-center text-slate-400">Aucun colis sur cette période.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($orders && $orders->hasPages())
            <div class="mt-4">{{ $orders->links() }}</div>
        @endif

    </div>
</x-app-layout>

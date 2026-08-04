<x-app-layout>
@push('styles')
<style>
    .oc-wrap { max-width: 1150px; margin: 0 auto; }
    .oc-panel { background: #fff; border: 1px solid #e7e7e7; padding: 24px; border-radius: 6px; }
    .amazon-card { background: #fff; border: 1px solid #f0f0f0; border-radius: 6px; box-shadow: 0 1px 2px rgba(0,0,0,0.03); padding: 16px 22px 22px; margin-bottom: 20px; }
    .section-title { font-size: 0.82rem; font-weight: 700; color: #111; margin-bottom: 16px; padding-bottom: 10px; border-bottom: 1px solid #f0f0f0; text-transform: uppercase; letter-spacing: 0.03em; }
    .section-title i { color: #FF6B00; margin-right: 6px; }
    .btn-sec { background: #fff; border: 1px solid #ddd; color: #444; padding: 7px 15px; border-radius: 6px; font-size: 0.85rem; font-weight: 600; text-decoration: none; cursor: pointer; display: inline-flex; align-items: center; gap: 8px; transition: all .2s; }
    .btn-sec:hover { background: #f7f7f7; border-color: #ccc; color: #111; }
    .info-row { display: grid; grid-template-columns: 160px 1fr; gap: 12px; margin-bottom: 11px; font-size: 0.85rem; }
    .info-label { color: #666; font-weight: 500; }
    .info-value { color: #111; font-weight: 600; }
    .status-badge { padding: 4px 14px; border-radius: 14px; font-size: 0.72rem; font-weight: 800; display: inline-block; text-transform: uppercase; }
    .grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px; }
    .table-articles { width: 100%; border-collapse: collapse; border: 1px solid #e7e7e7; margin-top: 6px; }
    .table-articles th { background: #f3f5f8; padding: 10px 14px; text-align: left; font-size: 0.7rem; font-weight: 800; color: #333; text-transform: uppercase; border-bottom: 1px solid #e7e7e7; }
    .table-articles td { padding: 12px 14px; font-size: 0.85rem; border-bottom: 1px solid #eee; vertical-align: middle; }
    .article-img { width: 50px; height: 50px; object-fit: cover; border: 1px solid #eee; border-radius: 4px; background: #fff; }
    .timeline { display: flex; flex-direction: column; }
    .tl-item { display: flex; gap: 14px; align-items: flex-start; position: relative; padding-bottom: 18px; }
    .tl-item:last-child { padding-bottom: 0; }
    .tl-dot { width: 12px; height: 12px; border-radius: 50%; border: 2px solid #ddd; background: #fff; margin-top: 3px; z-index: 1; flex: none; }
    .tl-dot.done { background: #3f7d18; border-color: #3f7d18; }
    .tl-dot.current { background: #FF6B00; border-color: #FF6B00; }
    .tl-item:not(:last-child)::after { content: ''; position: absolute; left: 5px; top: 15px; width: 2px; height: calc(100% - 12px); background: #eee; }
    .tl-text { font-size: 0.82rem; font-weight: 500; color: #999; }
    .tl-text.done { color: #111; font-weight: 600; }
    .tl-text.current { color: #FF6B00; font-weight: 700; }
    .bill { width: 340px; margin-left: auto; margin-top: 14px; border-top: 1px solid #f0f0f0; padding-top: 14px; }
    .bill-row { display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 0.85rem; color: #444; }
    .bill-total { display: flex; justify-content: space-between; color: #111; font-weight: 800; font-size: 1rem; margin-top: 6px; border-top: 2px solid #333; padding-top: 8px; }
    @media (max-width: 768px) { .grid-2 { grid-template-columns: 1fr; } .oc-panel { padding: 14px; } .info-row { grid-template-columns: 130px 1fr; } }
</style>
@endpush

@php
    $money = fn ($v) => number_format((float) $v, 0, ',', ' ') . ' FCFA';
    $mediaBase = rtrim(config('services.karnou_media_url', 'https://www.karnou.com/storage'), '/') . '/';
    $recDate = $order->received_at ?? $order->updated_at;
    $echeance = $recDate ? $recDate->copy()->addDays(7) : null;
    $sellerUser = $order->seller && $order->seller->user ? $order->seller->user : null;
    $sellerName = $sellerUser ? trim(($sellerUser->prenom ?? '') . ' ' . ($sellerUser->nom ?? '')) : ($order->seller->identite ?? 'Inconnu');
    $badgeStyle = match($order->statut) {
        'livre', 'paye'                  => 'background:#f7fff0; color:#3f7d18; border:1px solid #c7e5a1;',
        'pret_expedition', 'disponible'  => 'background:#fff8f3; color:#b8560f; border:1px solid #fbd8b4;',
        'en_route'                       => 'background:#f0f7ff; color:#004aad; border:1px solid #c2e0ff;',
        'annule', 'litige'               => 'background:#fff5f5; color:#c40000; border:1px solid #f9c2c2;',
        default                          => 'background:#f6f6f6; color:#555; border:1px solid #ddd;',
    };
@endphp

<div class="oc-wrap">
    <div class="oc-panel">

        {{-- En-tête --}}
        <div style="display:flex; justify-content:space-between; align-items:center; flex-wrap:wrap; gap:12px; margin-bottom:24px; padding-bottom:18px; border-bottom:1px solid #f0f0f0;">
            <div style="display:flex; align-items:center; gap:14px;">
                <a href="{{ route('operations.stock', ['tab' => 'stock']) }}" class="btn-sec" style="padding:6px 12px;">
                    <i class="fas fa-chevron-left"></i> Retour
                </a>
                <h1 style="font-size:1.2rem; font-weight:600; color:#111; margin:0;">Commande {{ $order->reference }}</h1>
            </div>
            <span class="status-badge" style="{{ $badgeStyle }}">{{ $order->statut_label }}</span>
        </div>

        {{-- Infos + Suivi --}}
        <div class="grid-2">
            <div class="amazon-card" style="margin-bottom:0;">
                <h2 class="section-title"><i class="fas fa-circle-info"></i>Informations générales</h2>
                <div class="info-row"><span class="info-label">Référence</span><span class="info-value">{{ $order->reference }}</span></div>
                <div class="info-row"><span class="info-label">Date de commande</span><span class="info-value">{{ $order->created_at->format('d/m/Y à H:i') }}</span></div>
                <div class="info-row"><span class="info-label">Mode d'expédition</span><span class="info-value">{{ $order->mode_livraison ? ucfirst(str_replace('_',' ',$order->mode_livraison)) : '—' }}</span></div>
                <div class="info-row"><span class="info-label">Réception</span><span class="info-value">{{ $recDate ? $recDate->format('d/m/Y') : '—' }}</span></div>
                <div class="info-row"><span class="info-label">Échéance</span><span class="info-value" style="color: {{ ($echeance && now()->greaterThan($echeance)) ? '#c0392b' : '#3f7d18' }};">{{ $echeance ? $echeance->format('d/m/Y') : '—' }}</span></div>
                @if($order->paiement_methode)
                    @php $mLabel = ['espece' => 'Espèces', 'mobile' => 'Mobile Money', 'carte' => 'Carte'][$order->paiement_methode] ?? $order->paiement_methode; @endphp
                    <div class="info-row"><span class="info-label">Encaissement</span><span class="info-value">{{ $mLabel }}@if($order->paiement_reference) · réf. {{ $order->paiement_reference }}@endif</span></div>
                @endif
            </div>

            <div class="amazon-card" style="margin-bottom:0;">
                <h2 class="section-title"><i class="fas fa-truck-fast"></i>Suivi de la commande</h2>
                @php
                    $steps = [
                        'en_attente' => 'En attente de paiement',
                        'paye' => 'Payé — à préparer',
                        'pret_expedition' => 'Prêt pour expédition',
                        'en_route' => 'En cours de livraison',
                        'disponible' => 'Disponible au point relais',
                        'livre' => 'Livré',
                    ];
                    $statuses = array_keys($steps);
                    $currentIdx = array_search($order->statut, $statuses);
                @endphp
                <div class="timeline">
                    @foreach($steps as $key => $lbl)
                        @php
                            $isDone = $currentIdx !== false && array_search($key, $statuses) < $currentIdx;
                            $isCurrent = $order->statut === $key;
                        @endphp
                        <div class="tl-item">
                            <div class="tl-dot {{ $isDone ? 'done' : ($isCurrent ? 'current' : '') }}"></div>
                            <span class="tl-text {{ $isDone ? 'done' : ($isCurrent ? 'current' : '') }}">{{ $lbl }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Client + Vendeur --}}
        <div class="grid-2">
            <div class="amazon-card" style="margin-bottom:0;">
                <h2 class="section-title"><i class="fas fa-user"></i>Client</h2>
                <div class="info-row"><span class="info-label">Nom complet</span><span class="info-value" style="color:#004aad;">{{ trim(($order->buyer->prenom ?? '').' '.($order->buyer->nom ?? $order->buyer->name ?? '')) ?: 'Inconnu' }}</span></div>
                <div class="info-row"><span class="info-label">Téléphone</span><span class="info-value">{{ $order->buyer->telephone ?? '—' }}</span></div>
                <div class="info-row"><span class="info-label">Email</span><span class="info-value">{{ $order->buyer->email ?? '—' }}</span></div>
                <div class="info-row"><span class="info-label">Adresse de livraison</span><span class="info-value" style="font-weight:500; font-style:italic;">{{ $order->adresse_livraison ?? '—' }}</span></div>
            </div>

            <div class="amazon-card" style="margin-bottom:0;">
                <h2 class="section-title"><i class="fas fa-store"></i>Vendeur</h2>
                <div class="info-row"><span class="info-label">Nom</span><span class="info-value" style="color:#004aad;">{{ $sellerName }}</span></div>
                <div class="info-row"><span class="info-label">Téléphone</span><span class="info-value">{{ $sellerUser->telephone ?? '—' }}</span></div>
                <div class="info-row"><span class="info-label">Type</span><span class="info-value">{{ $order->seller ? strtoupper($order->seller->type ?? '—') : '—' }}</span></div>
            </div>
        </div>

        {{-- Articles + facturation --}}
        <div class="amazon-card">
            <h2 class="section-title"><i class="fas fa-box-open"></i>Articles commandés</h2>
            <div style="overflow-x:auto;">
                <table class="table-articles">
                    <thead>
                        <tr>
                            <th style="width:60px;">Image</th>
                            <th>Produit</th>
                            <th style="text-align:center;">Qté</th>
                            <th style="text-align:right;">P.U.</th>
                            <th style="text-align:right;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($order->items as $item)
                            @php $photo = $item->annonce ? $item->annonce->medias->first() : null; @endphp
                            <tr>
                                <td>@if($photo)<img src="{{ $mediaBase . ltrim($photo->chemin, '/') }}" class="article-img" alt="">@endif</td>
                                <td>
                                    <div style="font-weight:700; color:#111;">{{ $item->annonce->titre ?? 'Produit retiré' }}</div>
                                    @if($item->annonce && $item->annonce->description)
                                        <div style="font-size:0.75rem; color:#888; margin-top:2px;">{{ \Illuminate\Support\Str::limit(strip_tags($item->annonce->description), 90) }}</div>
                                    @endif
                                </td>
                                <td style="text-align:center; font-weight:600;">{{ $item->quantite }}</td>
                                <td style="text-align:right;">{{ $money($item->prix_unitaire) }}</td>
                                <td style="text-align:right; font-weight:800;">{{ $money($item->prix_unitaire * $item->quantite) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" style="text-align:center; color:#999; padding:24px;">Aucun article.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="bill">
                <div class="bill-row"><span>Sous-total produits</span><span style="font-weight:600;">{{ $money($order->total_produits) }}</span></div>
                <div class="bill-row"><span>Frais de livraison</span><span style="font-weight:600;">{{ $money($order->frais_port) }}</span></div>
                @if(!is_null($order->commission_plateforme))
                    <div class="bill-row" style="color:#c40000;"><span>Commission</span><span style="font-weight:600;">−{{ $money($order->commission_plateforme) }}</span></div>
                @endif
                <div class="bill-total"><span>Total</span><span>{{ $money($order->total_final) }}</span></div>
            </div>
        </div>

        {{-- Actions --}}
        <div style="display:flex; justify-content:flex-end; gap:12px; border-top:1px solid #f0f0f0; margin-top:22px; padding-top:18px;">
            <a href="{{ route('colis.pdf', $order->id) }}" target="_blank" class="btn-sec"><i class="fas fa-file-pdf"></i> Télécharger le PDF</a>
        </div>

    </div>
</div>
</x-app-layout>

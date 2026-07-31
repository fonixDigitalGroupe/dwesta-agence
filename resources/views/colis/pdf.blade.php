<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        @page { margin: 0; }
        body { font-family: DejaVu Sans, sans-serif; color: #2a2f3a; font-size: 12px; line-height: 1.5; }
        .page { padding: 0 34px 34px; }

        /* Bandeau haut bleu */
        .banner { background: #004aad; color: #fff; padding: 24px 34px; margin: 0 -34px 22px; }
        .banner table { width: 100%; }
        .banner .name { font-size: 22px; font-weight: bold; }
        .banner .sub { font-size: 10px; color: #bcd3f5; margin-top: 3px; }
        .banner .ref { font-size: 16px; font-weight: bold; text-align: right; }
        .banner .badge { display: inline-block; margin-top: 6px; padding: 3px 12px; border-radius: 20px; font-size: 9px; font-weight: bold; text-transform: uppercase; background: #FF6B00; color: #fff; }

        /* Titres de section */
        .section { background: #eef3fb; color: #004aad; border-left: 4px solid #FF6B00; padding: 6px 12px; font-size: 11px; font-weight: bold; text-transform: uppercase; letter-spacing: .5px; margin: 18px 0 10px; }

        .cols { width: 100%; }
        .cols td { vertical-align: top; width: 50%; padding-right: 16px; }
        .info td { padding: 3px 0; vertical-align: top; }
        .info .lbl { color: #8a90a0; width: 44%; }
        .info .val { color: #14181f; font-weight: bold; }

        /* Produits */
        .items { width: 100%; border-collapse: collapse; margin-top: 4px; }
        .items th { background: #004aad; color: #fff; font-size: 9.5px; text-transform: uppercase; text-align: left; padding: 8px 10px; }
        .items td { padding: 9px 10px; border-bottom: 1px solid #eceff3; vertical-align: middle; }
        .items tr:nth-child(even) td { background: #f9fbfd; }
        .prod-img { width: 44px; height: 44px; object-fit: cover; border: 1px solid #e5e9f0; border-radius: 4px; }
        .prod-title { font-weight: bold; color: #14181f; }
        .prod-desc { color: #98a0af; font-size: 9.5px; margin-top: 2px; }
        .right { text-align: right; } .center { text-align: center; }

        /* Totaux */
        .totals { width: 46%; float: right; margin-top: 14px; border: 1px solid #e5e9f0; border-radius: 6px; overflow: hidden; }
        .totals td { padding: 7px 14px; font-size: 12px; }
        .totals .lbl { color: #6b7280; } .totals .val { text-align: right; font-weight: bold; color: #14181f; }
        .totals .grand td { background: #004aad; color: #fff; font-size: 14px; font-weight: bold; }

        .foot { clear: both; margin-top: 46px; border-top: 2px solid #004aad; padding-top: 10px; color: #98a0af; font-size: 9.5px; text-align: center; }
    </style>
</head>
<body>
@php
    $money = fn ($v) => number_format((float) $v, 0, ',', ' ') . ' FCFA';
    $recDate = $order->received_at ?? $order->updated_at;
    $echeance = $recDate ? $recDate->copy()->addDays(7) : null;
    $sellerUser = $order->seller && $order->seller->user ? $order->seller->user : null;
    $sellerName = $sellerUser ? trim(($sellerUser->prenom ?? '') . ' ' . ($sellerUser->nom ?? '')) : ($order->seller->identite ?? 'Inconnu');
    $mediaBase = rtrim(config('services.karnou_media_url', 'https://www.karnou.com/storage'), '/') . '/';
@endphp

    {{-- Bandeau --}}
    <div class="banner">
        <table>
            <tr>
                <td>
                    <div class="name">{{ $agence->nom ?? 'Point Relais' }}</div>
                    <div class="sub">Fiche colis · {{ $order->created_at->format('d/m/Y à H:i') }}</div>
                </td>
                <td>
                    <div class="ref">{{ $order->reference }}</div>
                    <div style="text-align:right;"><span class="badge">{{ $order->statut_label }}</span></div>
                </td>
            </tr>
        </table>
    </div>

    <div class="page">

        {{-- Client / Vendeur --}}
        <table class="cols">
            <tr>
                <td>
                    <div class="section">Client</div>
                    <table class="info">
                        <tr><td class="lbl">Nom</td><td class="val">{{ trim(($order->buyer->prenom ?? '').' '.($order->buyer->nom ?? $order->buyer->name ?? '')) ?: 'Inconnu' }}</td></tr>
                        <tr><td class="lbl">Téléphone</td><td class="val">{{ $order->buyer->telephone ?? '—' }}</td></tr>
                        <tr><td class="lbl">Email</td><td class="val">{{ $order->buyer->email ?? '—' }}</td></tr>
                    </table>
                </td>
                <td>
                    <div class="section">Vendeur</div>
                    <table class="info">
                        <tr><td class="lbl">Nom</td><td class="val">{{ $sellerName }}{{ ($order->seller && $order->seller->type === 'professionnel') ? ' (PRO)' : '' }}</td></tr>
                        <tr><td class="lbl">Téléphone</td><td class="val">{{ $sellerUser->telephone ?? '—' }}</td></tr>
                    </table>
                </td>
            </tr>
        </table>

        {{-- Livraison --}}
        <div class="section">Livraison</div>
        <table class="info">
            <tr><td class="lbl" style="width:22%;">Mode</td><td class="val">{{ $order->mode_livraison ? ucfirst(str_replace('_',' ',$order->mode_livraison)) : '—' }}</td></tr>
            <tr><td class="lbl">Adresse</td><td class="val">{{ $order->adresse_livraison ?? '—' }}</td></tr>
            <tr><td class="lbl">Point relais</td><td class="val">{{ $agence->nom ?? '' }} — {{ $agence->adresse ?? '' }}</td></tr>
            <tr><td class="lbl">Réception</td><td class="val">{{ $recDate ? $recDate->format('d/m/Y') : '—' }}</td></tr>
            <tr><td class="lbl">Échéance</td><td class="val" style="color: {{ ($echeance && now()->greaterThan($echeance)) ? '#c0392b' : '#3f7d18' }};">{{ $echeance ? $echeance->format('d/m/Y') : '—' }}</td></tr>
        </table>

        {{-- Produits --}}
        <div class="section">Produits</div>
        <table class="items">
            <thead>
                <tr>
                    <th style="width:54px;"></th>
                    <th>Produit</th>
                    <th class="center" style="width:44px;">Qté</th>
                    <th class="right" style="width:92px;">P.U.</th>
                    <th class="right" style="width:100px;">Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($order->items as $item)
                    @php
                        $annonce = $item->annonce;
                        $media = $annonce ? $annonce->medias->first() : null;
                        $imgData = null;
                        if ($media && $media->chemin) {
                            $bin = @file_get_contents($mediaBase . ltrim($media->chemin, '/'));
                            if ($bin !== false) {
                                $imgData = 'data:' . ($media->mime_type ?: 'image/jpeg') . ';base64,' . base64_encode($bin);
                            }
                        }
                    @endphp
                    <tr>
                        <td>@if($imgData)<img src="{{ $imgData }}" class="prod-img" alt="">@endif</td>
                        <td>
                            <div class="prod-title">{{ $annonce->titre ?? 'Produit' }}</div>
                            @if($annonce && $annonce->description)
                                <div class="prod-desc">{{ \Illuminate\Support\Str::limit(strip_tags($annonce->description), 110) }}</div>
                            @endif
                        </td>
                        <td class="center">{{ $item->quantite }}</td>
                        <td class="right">{{ $money($item->prix_unitaire) }}</td>
                        <td class="right"><strong>{{ $money($item->prix_unitaire * $item->quantite) }}</strong></td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="center" style="color:#999;padding:20px;">Aucun produit.</td></tr>
                @endforelse
            </tbody>
        </table>

        {{-- Totaux --}}
        <table class="totals">
            <tr><td class="lbl">Sous-total produits</td><td class="val">{{ $money($order->total_produits) }}</td></tr>
            <tr><td class="lbl">Frais de livraison</td><td class="val">{{ $money($order->frais_port) }}</td></tr>
            @if(!is_null($order->commission_plateforme))
                <tr><td class="lbl">Commission</td><td class="val">{{ $money($order->commission_plateforme) }}</td></tr>
            @endif
            <tr class="grand"><td>TOTAL</td><td style="text-align:right;">{{ $money($order->total_final) }}</td></tr>
        </table>

        <div class="foot">
            Document généré le {{ now()->format('d/m/Y à H:i') }} · {{ $agence->nom ?? 'Karnou Agence' }} · Réseau Karnou
        </div>
    </div>
</body>
</html>

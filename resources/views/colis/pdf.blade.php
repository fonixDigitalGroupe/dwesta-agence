<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: DejaVu Sans, sans-serif; color: #222; font-size: 12px; line-height: 1.55; }
        .page { padding: 40px 44px; }

        /* En-tête */
        .head { width: 100%; border-bottom: 2px solid #222; padding-bottom: 16px; margin-bottom: 22px; }
        .head td { vertical-align: top; }
        .brand { font-size: 20px; font-weight: bold; color: #111; letter-spacing: .5px; }
        .brand-sub { font-size: 10px; color: #777; margin-top: 3px; }
        .doc { text-align: right; }
        .doc .title { font-size: 15px; font-weight: bold; color: #111; letter-spacing: 2px; }
        .doc .meta { font-size: 10.5px; color: #555; margin-top: 5px; }
        .doc .meta b { color: #111; }
        .status { display: inline-block; margin-top: 6px; padding: 2px 10px; border: 1px solid #ccc; border-radius: 3px; font-size: 9px; font-weight: bold; text-transform: uppercase; color: #444; }

        /* Sections */
        .section { font-size: 10.5px; font-weight: bold; text-transform: uppercase; letter-spacing: 1px; color: #111; border-bottom: 1px solid #ddd; padding-bottom: 5px; margin: 20px 0 10px; }

        .cols { width: 100%; }
        .cols td { vertical-align: top; width: 50%; padding-right: 20px; }
        .info td { padding: 2px 0; vertical-align: top; }
        .info .lbl { color: #888; width: 42%; }
        .info .val { color: #111; font-weight: bold; }

        /* Produits */
        .items { width: 100%; border-collapse: collapse; margin-top: 4px; }
        .items th { background: #f4f4f4; color: #333; font-size: 9.5px; text-transform: uppercase; text-align: left; padding: 8px 10px; border-bottom: 1px solid #ccc; }
        .items td { padding: 9px 10px; border-bottom: 1px solid #eee; vertical-align: middle; }
        .prod-img { width: 44px; height: 44px; object-fit: cover; border: 1px solid #e5e5e5; border-radius: 3px; }
        .prod-title { font-weight: bold; color: #111; }
        .prod-desc { color: #999; font-size: 9.5px; margin-top: 2px; }
        .right { text-align: right; } .center { text-align: center; }

        /* Totaux */
        .totals { width: 44%; float: right; margin-top: 14px; }
        .totals td { padding: 6px 4px; font-size: 12px; }
        .totals .lbl { color: #666; } .totals .val { text-align: right; color: #111; }
        .totals .grand td { border-top: 2px solid #222; font-weight: bold; font-size: 14px; padding-top: 9px; }

        .foot { clear: both; margin-top: 48px; border-top: 1px solid #ddd; padding-top: 10px; color: #999; font-size: 9.5px; text-align: center; }
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

    <div class="page">

        {{-- En-tête --}}
        <table class="head">
            <tr>
                <td>
                    <div class="brand">{{ $agence->nom ?? 'Point Relais' }}</div>
                    <div class="brand-sub">{{ $agence->adresse ?? '' }}@if($agence->telephone ?? false) · {{ $agence->telephone }} @endif</div>
                </td>
                <td class="doc">
                    <div class="title">FICHE COLIS</div>
                    <div class="meta">Référence : <b>{{ $order->reference }}</b></div>
                    <div class="meta">Date : <b>{{ $order->created_at->format('d/m/Y') }}</b></div>
                    <div><span class="status">{{ $order->statut_label }}</span></div>
                </td>
            </tr>
        </table>

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
            <tr><td class="lbl">Échéance</td><td class="val">{{ $echeance ? $echeance->format('d/m/Y') : '—' }}</td></tr>
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
            <tr class="grand"><td>TOTAL</td><td class="right">{{ $money($order->total_final) }}</td></tr>
        </table>

        <div class="foot">
            Document généré le {{ now()->format('d/m/Y à H:i') }} · {{ $agence->nom ?? 'Point Relais' }}
        </div>
    </div>
</body>
</html>

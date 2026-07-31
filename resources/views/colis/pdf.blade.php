<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: DejaVu Sans, sans-serif; color: #222; font-size: 12px; line-height: 1.5; }
        .wrap { padding: 8px 4px; }
        .head { border-bottom: 3px solid #004aad; padding-bottom: 12px; margin-bottom: 18px; }
        .head-title { color: #004aad; font-size: 22px; font-weight: bold; }
        .head-sub { color: #777; font-size: 11px; margin-top: 2px; }
        .head-ref { float: right; text-align: right; }
        .head-ref .ref { font-size: 14px; font-weight: bold; color: #111; }
        .badge { display: inline-block; padding: 3px 10px; border-radius: 4px; font-size: 10px; font-weight: bold; background: #e8f1fb; color: #0b62c4; }

        h2.section { font-size: 12px; text-transform: uppercase; letter-spacing: 1px; color: #004aad; border-bottom: 1px solid #e5e5e5; padding-bottom: 4px; margin: 18px 0 8px; }
        table { width: 100%; border-collapse: collapse; }
        .info td { vertical-align: top; padding: 3px 0; }
        .info .lbl { color: #888; width: 42%; }
        .info .val { color: #111; font-weight: bold; }
        .cols { width: 100%; }
        .cols td { vertical-align: top; width: 50%; padding-right: 14px; }

        .items { margin-top: 6px; }
        .items th { background: #f3f5f8; color: #444; font-size: 10px; text-transform: uppercase; text-align: left; padding: 7px 8px; border-bottom: 2px solid #e5e5e5; }
        .items td { padding: 8px; border-bottom: 1px solid #eee; vertical-align: top; }
        .items .prod-img { width: 46px; height: 46px; object-fit: cover; border: 1px solid #eee; border-radius: 4px; }
        .items .prod-title { font-weight: bold; color: #111; }
        .items .prod-desc { color: #888; font-size: 10px; margin-top: 2px; }
        .right { text-align: right; }
        .center { text-align: center; }

        .totals { margin-top: 12px; width: 40%; float: right; }
        .totals td { padding: 5px 8px; }
        .totals .lbl { color: #666; }
        .totals .val { text-align: right; font-weight: bold; }
        .totals .grand td { border-top: 2px solid #004aad; color: #004aad; font-size: 14px; padding-top: 8px; }

        .foot { clear: both; margin-top: 40px; border-top: 1px solid #e5e5e5; padding-top: 10px; color: #999; font-size: 10px; text-align: center; }
    </style>
</head>
<body>
@php
    $money = fn ($v) => number_format((float) $v, 0, ',', ' ') . ' FCFA';
    $recDate = $order->received_at ?? $order->updated_at;
    $echeance = $recDate ? $recDate->copy()->addDays(7) : null;
    $sellerUser = $order->seller && $order->seller->user ? $order->seller->user : null;
    $sellerName = $sellerUser ? trim(($sellerUser->prenom ?? '') . ' ' . ($sellerUser->nom ?? '')) : ($order->seller->identite ?? 'Inconnu');
@endphp
<div class="wrap">

    {{-- En-tête --}}
    <div class="head">
        <div class="head-ref">
            <div class="ref">{{ $order->reference }}</div>
            <div style="margin-top:4px;"><span class="badge">{{ $order->statut_label }}</span></div>
        </div>
        <div class="head-title">{{ $agence->nom ?? 'Point Relais' }}</div>
        <div class="head-sub">Fiche colis · {{ $order->created_at->format('d/m/Y à H:i') }}</div>
    </div>

    {{-- Client / Vendeur --}}
    <table class="cols">
        <tr>
            <td>
                <h2 class="section">Client</h2>
                <table class="info">
                    <tr><td class="lbl">Nom</td><td class="val">{{ trim(($order->buyer->prenom ?? '') . ' ' . ($order->buyer->nom ?? $order->buyer->name ?? '')) ?: 'Inconnu' }}</td></tr>
                    <tr><td class="lbl">Téléphone</td><td class="val">{{ $order->buyer->telephone ?? '—' }}</td></tr>
                    <tr><td class="lbl">Email</td><td class="val">{{ $order->buyer->email ?? '—' }}</td></tr>
                </table>
            </td>
            <td>
                <h2 class="section">Vendeur</h2>
                <table class="info">
                    <tr><td class="lbl">Nom</td><td class="val">{{ $sellerName }}{{ ($order->seller && $order->seller->type === 'professionnel') ? ' (PRO)' : '' }}</td></tr>
                    <tr><td class="lbl">Téléphone</td><td class="val">{{ $sellerUser->telephone ?? '—' }}</td></tr>
                </table>
            </td>
        </tr>
    </table>

    {{-- Livraison --}}
    <h2 class="section">Livraison</h2>
    <table class="info">
        <tr><td class="lbl" style="width:21%;">Mode</td><td class="val">{{ $order->mode_livraison ?? '—' }}</td></tr>
        <tr><td class="lbl">Adresse</td><td class="val">{{ $order->adresse_livraison ?? '—' }}</td></tr>
        <tr><td class="lbl">Point relais</td><td class="val">{{ $agence->nom ?? '' }} — {{ $agence->adresse ?? '' }}</td></tr>
        <tr><td class="lbl">Réception</td><td class="val">{{ $recDate ? $recDate->format('d/m/Y') : '—' }}</td></tr>
        <tr><td class="lbl">Échéance</td><td class="val">{{ $echeance ? $echeance->format('d/m/Y') : '—' }}</td></tr>
    </table>

    {{-- Produits --}}
    <h2 class="section">Produits</h2>
    <table class="items">
        <thead>
            <tr>
                <th style="width:56px;"></th>
                <th>Produit</th>
                <th class="center" style="width:50px;">Qté</th>
                <th class="right" style="width:90px;">P.U.</th>
                <th class="right" style="width:100px;">Total</th>
            </tr>
        </thead>
        <tbody>
            @forelse($order->items as $item)
                @php
                    $annonce = $item->annonce;
                    $media = $annonce ? $annonce->medias->first() : null;
                    $imgData = null;
                    if ($media && $media->chemin && \Illuminate\Support\Facades\Storage::disk('public')->exists($media->chemin)) {
                        $imgData = 'data:' . ($media->mime_type ?: 'image/jpeg') . ';base64,' . base64_encode(\Illuminate\Support\Facades\Storage::disk('public')->get($media->chemin));
                    }
                    $ligne = (float) $item->prix_unitaire * (int) $item->quantite;
                @endphp
                <tr>
                    <td>
                        @if($imgData)
                            <img src="{{ $imgData }}" class="prod-img" alt="">
                        @endif
                    </td>
                    <td>
                        <div class="prod-title">{{ $annonce->titre ?? 'Produit' }}</div>
                        @if($annonce && $annonce->description)
                            <div class="prod-desc">{{ \Illuminate\Support\Str::limit(strip_tags($annonce->description), 120) }}</div>
                        @endif
                    </td>
                    <td class="center">{{ $item->quantite }}</td>
                    <td class="right">{{ $money($item->prix_unitaire) }}</td>
                    <td class="right">{{ $money($ligne) }}</td>
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
        <tr class="grand"><td class="lbl" style="color:#004aad;">TOTAL</td><td class="val">{{ $money($order->total_final) }}</td></tr>
    </table>

    <div class="foot">
        Document généré le {{ now()->format('d/m/Y à H:i') }} · {{ $agence->nom ?? 'Karnou Agence' }} · Réseau Karnou
    </div>
</div>
</body>
</html>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        @page { margin: 0; }
        body { font-family: Helvetica, Arial, sans-serif; color: #111; font-size: 11px; line-height: 1.45; }
        .page { padding: 34px 40px; }

        .logo { height: 34px; }
        .site { font-size: 9px; color: #777; margin-top: 2px; }
        .title { font-size: 17px; font-weight: bold; color: #111; margin: 16px 0 12px; }

        .topinfo { width: 100%; margin-bottom: 14px; }
        .topinfo td { vertical-align: top; width: 33.33%; font-size: 10px; padding-right: 12px; }
        .topinfo .k { color: #666; font-weight: bold; }

        /* Sections encadrées */
        .box { width: 100%; border: 1px solid #111; border-collapse: collapse; margin-bottom: 16px; }
        .box .section { background: #f0f0f0; text-align: center; font-weight: bold; font-size: 11px; padding: 6px; border-bottom: 1px solid #111; }
        .box td { border: 1px solid #111; padding: 7px 10px; font-size: 10.5px; vertical-align: top; }
        .box td.k { width: 24%; color: #333; }
        .box td.v { width: 30%; font-weight: bold; color: #111; }
        .box td.addr { width: 46%; }
        .box td.addr .at { color: #666; font-weight: bold; margin-bottom: 3px; }

        /* Produits */
        table.prod { width: 100%; border: 1px solid #111; border-collapse: collapse; }
        table.prod .section { background: #f0f0f0; text-align: center; font-weight: bold; font-size: 11px; padding: 6px; border: 1px solid #111; }
        table.prod th { background: #fff; border: 1px solid #111; padding: 7px 8px; font-size: 9.5px; text-align: center; font-weight: bold; }
        table.prod td { border: 1px solid #111; padding: 7px 8px; font-size: 10.5px; vertical-align: middle; }
        table.prod td.name { text-align: left; }
        .pimg { width: 34px; height: 34px; object-fit: cover; border: 1px solid #ddd; }

        .recu { margin-top: 22px; font-size: 11px; font-weight: bold; }
        .sign-line { margin-top: 26px; border-top: 1px solid #999; width: 240px; }
    </style>
</head>
<body>
@php
    $money = fn ($v) => number_format((float) $v, 0, ',', ' ');
    $recDate = $order->received_at ?? $order->updated_at;
    $sellerUser = $order->seller && $order->seller->user ? $order->seller->user : null;
    $sellerName = $sellerUser ? trim(($sellerUser->prenom ?? '') . ' ' . ($sellerUser->nom ?? '')) : ($order->seller->identite ?? 'Inconnu');
    $mediaBase = rtrim(config('services.karnou_media_url', 'https://www.karnou.com/storage'), '/') . '/';
    $paiement = (($order->gestion_paiement ?? 'commande') === 'commande') ? 'Payé en ligne' : 'COD (à la livraison)';

    $logoRel = \App\Models\Setting::get('logo');
    $logoData = null;
    if ($logoRel) { $lb = @file_get_contents($mediaBase . ltrim($logoRel, '/')); if ($lb !== false) { $logoData = 'data:image/png;base64,' . base64_encode($lb); } }
@endphp
    <div class="page">

        {{-- Logo + site --}}
        @if($logoData)<img src="{{ $logoData }}" class="logo">@else<div class="title" style="margin:0;">KARNOU</div>@endif
        <div class="site">www.karnou.com</div>

        {{-- Titre --}}
        <div class="title">BORDEREAU DE LIVRAISON</div>

        {{-- Infos hautes --}}
        <table class="topinfo">
            <tr>
                <td>
                    <span class="k">Point relais :</span> {{ $agence->nom ?? '' }}<br>
                    <span class="k">Adresse :</span> {{ $agence->adresse ?? '-' }}
                </td>
                <td>
                    <span class="k">Vendeur :</span> {{ $sellerName }}{{ ($order->seller && $order->seller->type === 'professionnel') ? ' (PRO)' : '' }}<br>
                    <span class="k">Tél. vendeur :</span> {{ $sellerUser->telephone ?? '-' }}
                </td>
                <td>
                    <span class="k">Date :</span> {{ $order->created_at->format('d M Y') }}<br>
                    <span class="k">Réception :</span> {{ $recDate ? $recDate->format('d/m/Y') : '-' }}
                </td>
            </tr>
        </table>

        {{-- Détails de la commande --}}
        <table class="box">
            <tr><td class="section" colspan="3">Détails de la commande</td></tr>
            <tr>
                <td class="k">Date de commande</td>
                <td class="v">{{ $order->created_at->format('d M Y') }}</td>
                <td class="addr" rowspan="6">
                    <div class="at">Adresse :</div>
                    {{ trim(($order->buyer->prenom ?? '').' '.($order->buyer->nom ?? $order->buyer->name ?? '')) ?: 'Client' }}<br>
                    {{ $order->buyer->telephone ?? '' }}<br>
                    Point relais : {{ $agence->nom ?? '' }}<br>
                    {{ $order->adresse_livraison ?? '' }}
                </td>
            </tr>
            <tr><td class="k">N° de commande</td><td class="v">{{ $order->reference }}</td></tr>
            <tr><td class="k">Type de paiement</td><td class="v">{{ $paiement }}</td></tr>
            <tr><td class="k">Montant</td><td class="v">{{ $money($order->total_final) }} FCFA</td></tr>
            <tr><td class="k">Frais de livraison</td><td class="v">{{ $money($order->frais_port) }} FCFA</td></tr>
            <tr><td class="k">Nom du client</td><td class="v">{{ trim(($order->buyer->prenom ?? '').' '.($order->buyer->nom ?? $order->buyer->name ?? '')) ?: '-' }}</td></tr>
        </table>

        {{-- Détails du produit --}}
        <table class="prod">
            <tr><td class="section" colspan="6">Détails du produit</td></tr>
            <tr>
                <th class="name" style="text-align:left;">Nom du produit</th>
                <th style="width:64px;">Variation</th>
                <th style="width:66px;">Nombre de produits</th>
                <th style="width:78px;">Remise/Code Promo</th>
                <th style="width:80px;">Prix Unitaire</th>
                <th style="width:86px;">Total</th>
            </tr>
            @forelse($order->items as $item)
                @php
                    $variation = optional($item->variante)->nom ?? optional($item->variante)->valeur ?? optional($item->variante)->libelle ?? '-';
                @endphp
                <tr>
                    <td class="name">{{ $item->annonce->titre ?? 'Produit' }}</td>
                    <td style="text-align:center;">{{ $variation }}</td>
                    <td style="text-align:center;">{{ $item->quantite }}</td>
                    <td style="text-align:right;">0,00</td>
                    <td style="text-align:right;">{{ $money($item->prix_unitaire) }}</td>
                    <td style="text-align:right;">{{ $money($item->prix_unitaire * $item->quantite) }}</td>
                </tr>
            @empty
                <tr><td colspan="6" style="text-align:center;color:#999;padding:16px;">Aucun produit.</td></tr>
            @endforelse
            <tr>
                <td colspan="5" style="text-align:right;font-weight:bold;">TOTAL</td>
                <td style="text-align:right;font-weight:bold;">{{ $money($order->total_final) }} FCFA</td>
            </tr>
        </table>

        {{-- Reçu par --}}
        <div class="recu">REÇU PAR :</div>
        <div class="sign-line"></div>

    </div>
</body>
</html>

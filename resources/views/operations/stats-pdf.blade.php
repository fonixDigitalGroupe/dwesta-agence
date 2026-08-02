<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        @page { margin: 0; }
        body { font-family: DejaVu Sans, sans-serif; color: #2b2f36; font-size: 11.5px; line-height: 1.5; }
        .page { padding: 46px 48px; }

        /* En-tête */
        .head { width: 100%; }
        .head td { vertical-align: bottom; }
        .brand { font-size: 19px; font-weight: bold; color: #14181f; letter-spacing: .2px; }
        .brand-sub { font-size: 9.5px; color: #8a90a0; margin-top: 4px; }
        .report-title { text-align: right; font-size: 13px; font-weight: bold; letter-spacing: 3px; color: #14181f; }
        .report-kicker { text-align: right; font-size: 9px; letter-spacing: 2px; color: #9aa0ac; text-transform: uppercase; margin-bottom: 3px; }
        .rule { height: 2px; background: #14181f; margin: 14px 0 0; }

        /* Bandeau d'informations */
        .meta { width: 100%; border-collapse: collapse; margin: 18px 0 22px; }
        .meta td { border: 1px solid #e6e8ec; padding: 9px 12px; width: 25%; }
        .meta .lbl { font-size: 8px; letter-spacing: 1px; text-transform: uppercase; color: #9aa0ac; }
        .meta .val { font-size: 12px; font-weight: bold; color: #14181f; margin-top: 2px; }

        /* Tableau */
        table.list { width: 100%; border-collapse: collapse; }
        table.list th { background: #14181f; color: #fff; font-size: 8.5px; letter-spacing: .6px; text-transform: uppercase; text-align: left; padding: 9px 12px; }
        table.list td { padding: 9px 12px; border-bottom: 1px solid #edeff2; font-size: 11px; color: #3a3f47; }
        table.list tr:nth-child(even) td { background: #fafbfc; }
        table.list td.ref { font-weight: bold; color: #14181f; }
        .badge { display: inline-block; padding: 2px 9px; border-radius: 3px; font-size: 8.5px; font-weight: bold; letter-spacing: .3px; }

        .foot { margin-top: 26px; padding-top: 9px; border-top: 1px solid #e6e8ec; color: #9aa0ac; font-size: 9px; }
        .foot td { color: #9aa0ac; font-size: 9px; }
    </style>
</head>
<body>
@php
    $statutLabels = ['tous' => 'Tous', 'approche' => 'En approche', 'stock' => 'En stock', 'livre' => 'Livrés', 'litige' => 'Signalés'];
@endphp
    <div class="page">

        {{-- En-tête --}}
        <table class="head">
            <tr>
                <td>
                    <div class="report-kicker">Point relais · Réseau Karnou</div>
                    <div class="brand">{{ $agence->nom ?? 'Point Relais' }}</div>
                    <div class="brand-sub">{{ $agence->adresse ?? '' }}</div>
                </td>
                <td>
                    <div class="report-title">RAPPORT DE STATISTIQUES</div>
                </td>
            </tr>
        </table>
        <div class="rule"></div>

        {{-- Bandeau informations --}}
        <table class="meta">
            <tr>
                <td><div class="lbl">Période du</div><div class="val">{{ \Carbon\Carbon::parse($start)->format('d/m/Y') }}</div></td>
                <td><div class="lbl">au</div><div class="val">{{ \Carbon\Carbon::parse($end)->format('d/m/Y') }}</div></td>
                <td><div class="lbl">Statut</div><div class="val">{{ $statutLabels[$statut] ?? 'Tous' }}</div></td>
                <td><div class="lbl">Total colis</div><div class="val">{{ $orders->count() }}</div></td>
            </tr>
        </table>

        {{-- Tableau --}}
        <table class="list">
            <thead>
                <tr>
                    <th style="width:130px;">Référence</th>
                    <th>Client</th>
                    <th style="width:92px;">Statut</th>
                    <th style="width:120px;">Traité par</th>
                    <th style="width:72px;">Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    @php
                        $cat = in_array($order->statut, ['en_attente','paye','pret_expedition','en_route']) ? 'approche'
                             : ($order->statut === 'disponible' ? 'stock'
                             : ($order->statut === 'livre' ? 'livre'
                             : ($order->statut === 'litige' ? 'litige' : 'autre')));
                        $badges = [
                            'approche' => ['En approche', '#e8f1fb', '#0b62c4'],
                            'stock'    => ['En stock', '#fff3e6', '#b8560f'],
                            'livre'    => ['Livré', '#eaf6e4', '#3f7d18'],
                            'litige'   => ['Signalé', '#fdecea', '#c0392b'],
                            'autre'    => [ucfirst(str_replace('_',' ',$order->statut)), '#eef0f2', '#555'],
                        ];
                        [$bLabel, $bBg, $bTxt] = $badges[$cat];
                        $agentUser = match($cat) {
                            'stock'  => $order->receivedBy,
                            'livre'  => $order->deliveredBy,
                            'litige' => optional($order->litiges->firstWhere('statut','en_cours'))->reporter,
                            default  => null,
                        };
                        $agentName = $agentUser ? (trim(($agentUser->prenom ?? '').' '.($agentUser->nom ?? $agentUser->name ?? '')) ?: '—') : '—';
                    @endphp
                    <tr>
                        <td class="ref">{{ $order->reference }}</td>
                        <td>{{ trim(($order->buyer->prenom ?? '').' '.($order->buyer->nom ?? $order->buyer->name ?? '')) ?: '—' }}</td>
                        <td><span class="badge" style="background:{{ $bBg }};color:{{ $bTxt }};">{{ $bLabel }}</span></td>
                        <td>{{ $agentName }}</td>
                        <td>{{ $order->created_at->format('d/m/Y') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" style="text-align:center;color:#9aa0ac;padding:26px;">Aucun colis sur cette période.</td></tr>
                @endforelse
            </tbody>
        </table>

        {{-- Pied de page --}}
        <table class="foot">
            <tr>
                <td style="text-align:left;">{{ $agence->nom ?? 'Point Relais' }} — Réseau Karnou</td>
                <td style="text-align:right;">Édité le {{ now()->format('d/m/Y à H:i') }}</td>
            </tr>
        </table>
    </div>
</body>
</html>

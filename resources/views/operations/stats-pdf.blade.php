<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: DejaVu Sans, sans-serif; color: #222; font-size: 12px; line-height: 1.5; }
        .page { padding: 34px 40px; }
        .head { border-bottom: 2px solid #222; padding-bottom: 14px; margin-bottom: 18px; }
        .head td { vertical-align: top; }
        .brand { font-size: 18px; font-weight: bold; color: #111; }
        .brand-sub { font-size: 10px; color: #777; margin-top: 3px; }
        .doc { text-align: right; }
        .doc .title { font-size: 14px; font-weight: bold; letter-spacing: 2px; color: #111; }
        .doc .meta { font-size: 10px; color: #555; margin-top: 4px; }

        .recap { width: 100%; border-collapse: collapse; margin-bottom: 18px; }
        .recap td { width: 25%; border: 1px solid #e5e5e5; padding: 10px 12px; }
        .recap .lbl { font-size: 9px; text-transform: uppercase; letter-spacing: 1px; color: #888; }
        .recap .val { font-size: 20px; font-weight: bold; color: #111; margin-top: 3px; }

        table.list { width: 100%; border-collapse: collapse; }
        table.list th { background: #222; color: #fff; font-size: 9px; letter-spacing: .5px; text-transform: uppercase; text-align: left; padding: 9px 10px; }
        table.list td { padding: 9px 10px; border-bottom: 1px solid #eee; font-size: 11px; }
        table.list tr:nth-child(even) td { background: #fafafa; }
        table.list td:first-child { font-weight: bold; color: #111; }
        .badge { display: inline-block; padding: 2px 8px; border-radius: 4px; font-size: 9px; font-weight: bold; }
        .foot { margin-top: 24px; border-top: 1px solid #ddd; padding-top: 8px; color: #999; font-size: 9.5px; text-align: center; }
    </style>
</head>
<body>
@php
    $statutLabels = ['tous' => 'Tous', 'approche' => 'En approche', 'stock' => 'En stock', 'livre' => 'Livrés', 'litige' => 'Signalés'];
@endphp
    <div class="page">

        <table class="head">
            <tr>
                <td>
                    <div class="brand">{{ $agence->nom ?? 'Point Relais' }}</div>
                    <div class="brand-sub">{{ $agence->adresse ?? '' }}@if($agence->telephone ?? false) · {{ $agence->telephone }}@endif</div>
                </td>
                <td class="doc">
                    <div class="title">STATISTIQUES</div>
                    <div class="meta">Période : <b>{{ \Carbon\Carbon::parse($start)->format('d/m/Y') }}</b> — <b>{{ \Carbon\Carbon::parse($end)->format('d/m/Y') }}</b></div>
                    <div class="meta">Statut : <b>{{ $statutLabels[$statut] ?? 'Tous' }}</b></div>
                    <div class="meta">Éditée le {{ now()->format('d/m/Y à H:i') }}</div>
                </td>
            </tr>
        </table>

        {{-- Tableau --}}
        <table class="list">
            <thead>
                <tr>
                    <th style="width:130px;">Référence</th>
                    <th>Client</th>
                    <th style="width:90px;">Statut</th>
                    <th style="width:120px;">Traité par</th>
                    <th style="width:70px;">Date</th>
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
                        <td>{{ $order->reference }}</td>
                        <td>{{ trim(($order->buyer->prenom ?? '').' '.($order->buyer->nom ?? $order->buyer->name ?? '')) ?: '—' }}</td>
                        <td><span class="badge" style="background:{{ $bBg }};color:{{ $bTxt }};">{{ $bLabel }}</span></td>
                        <td>{{ $agentName }}</td>
                        <td>{{ $order->created_at->format('d/m/Y') }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5" style="text-align:center;color:#999;padding:20px;">Aucun colis sur cette période.</td></tr>
                @endforelse
            </tbody>
        </table>

        <div class="foot">{{ $agence->nom ?? 'Point Relais' }} · Réseau Karnou · {{ $orders->count() }} colis</div>
    </div>
</body>
</html>

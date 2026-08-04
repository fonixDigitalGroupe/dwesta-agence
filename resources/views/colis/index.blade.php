<x-app-layout>
    <x-slot name="header_tabs">
        <div style="background: #fff; padding: 0 25px; border-bottom: 1px solid #e7e7e7; display: flex; gap: 20px;">
            <a href="?tab=incoming" style="text-decoration: none; padding: 15px 0; color: {{ $activeTab == 'incoming' ? '#0066c0' : '#555' }}; font-weight: {{ $activeTab == 'incoming' ? '700' : '500' }}; border-bottom: 3px solid {{ $activeTab == 'incoming' ? '#0066c0' : 'transparent' }};">
                En approche 
                @if($counts['incoming'] > 0)
                    <span style="background: #bf0000; color: #fff; padding: 2px 6px; border-radius: 10px; font-size: 0.7rem;">{{ $counts['incoming'] }}</span>
                @endif
            </a>
            <a href="?tab=stock" style="text-decoration: none; padding: 15px 0; color: {{ $activeTab == 'stock' ? '#0066c0' : '#555' }}; font-weight: {{ $activeTab == 'stock' ? '700' : '500' }}; border-bottom: 3px solid {{ $activeTab == 'stock' ? '#0066c0' : 'transparent' }};">
                En stock
                <span class="badge" style="background: #eee; color: #333; padding: 2px 6px; border-radius: 10px; font-size: 0.7rem;">{{ $counts['stock'] }}</span>
            </a>
        </div>
    </x-slot>


    @push('styles')
    <style>
        .main-content { background-color: #f8f9fa !important; }
        
        /* High-Precision Amazon/Karnou Buttons */
        .sync-btn-blue {
            background: linear-gradient(180deg, #007bff 0%, #0056b3 100%);
            border: 1px solid #004aad;
            color: #fff !important;
            padding: 6px 14px;
            border-radius: 0;
            font-size: 0.8rem;
            font-weight: 400;
            text-decoration: none;
            box-shadow: 0 1px 0 rgba(255,255,255,.4) inset;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .sync-btn-blue:hover { background: linear-gradient(180deg, #0069d9 0%, #004085 100%); }

        .sync-btn-gray {
            background: linear-gradient(to bottom, #f7f8fa, #e7e9ec);
            border: 1px solid #adb1b8;
            color: #111 !important;
            padding: 6px 14px;
            border-radius: 0;
            font-size: 0.8rem;
            font-weight: 400;
            text-decoration: none;
            box-shadow: 0 1px 0 rgba(255,255,255,.6) inset;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .sync-btn-gray:hover { background: #f0f2f5; }

        /* Table Mirroring (Grid + Header Background) */
        .table-mirror {
            width: 100% !important;
            border-collapse: collapse !important;
            margin-bottom: 20px !important;
            border: 1px solid #e7e7e7 !important;
            background: #fff;
        }

        .table-mirror th {
            padding: 10px 15px !important;
            text-align: left !important;
            font-size: 0.75rem !important;
            font-weight: 700 !important;
            color: #111 !important;
            text-transform: uppercase !important;
            border-right: 1px solid #e7e7e7 !important;
            border-bottom: 1px solid #e7e7e7 !important;
            background: #f6f6f6 !important;
        }

        .table-mirror td {
            padding: 12px 15px !important;
            font-size: 0.85rem !important;
            color: #111 !important;
            border-right: 1px solid #e7e7e7 !important;
            border-bottom: 1px solid #e7e7e7 !important;
            vertical-align: middle !important;
        }

        .table-mirror tr:hover { background: #f9f9f9; }

        /* Typography Sync */
        .mirror-title {
            font-size: 1.1rem;
            font-weight: 500;
            color: #111;
            margin: 0;
        }
        .item-main {
            font-weight: 600;
            color: #0066c0;
            font-size: 0.9rem;
            text-decoration: none;
            display: block;
            margin-bottom: 2px;
        }
        .item-sub {
            font-size: 0.8rem;
            color: #777;
        }

        /* Action Links */
        .mirror-link { color: #0066c0; font-size: 0.84rem; text-decoration: none; cursor: pointer; }
        .mirror-link:hover { text-decoration: underline; }
        .mirror-link-red { color: #c40000; font-size: 0.84rem; text-decoration: none; cursor: pointer; }
        .mirror-link-red:hover { text-decoration: underline; }
        .mirror-sep { color: #ddd; margin: 0 8px; }

        /* Filter Standard Styling from Categories */
        .filter-container {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 15px 20px;
            border-radius: 0;
            margin-bottom: 20px;
        }
        .filter-input {
            padding: 6px 12px;
            border: 1px solid #adb1b8;
            border-radius: 0;
            outline: none;
            font-size: 0.85rem;
            width: 250px;
            background: #fff;
        }
        .filter-select {
            padding: 3px 6px;
            border: 1px solid #adb1b8;
            border-radius: 0;
            background: #fcfcfc;
            font-size: 0.8rem;
            color: #111;
            cursor: pointer;
            outline: none;
        }

        /* Sélecteur de motif du litige (centré + chevron) */
        .litige-select {
            display: block;
            width: 100%;
            max-width: 340px;
            margin: 0 auto 10px;
            padding: 10px 36px 10px 14px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 0.9rem;
            color: #111;
            cursor: pointer;
            text-align: center;
            text-align-last: center;
            -webkit-appearance: none;
            -moz-appearance: none;
            appearance: none;
            background-color: #fff;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='%23666' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 12px center;
        }
    </style>
    @endpush

    <div style="max-width: 100%;">
        {{-- Main Dashboard Card --}}
        <div style="background: #fff; border: 1px solid #e7e7e7; border-top: none; padding: 25px;">
            
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                <h1 class="mirror-title">Gestion du Stock & Colis</h1>
            </div>

            <!-- Barre de filtres (1:1 with Categories) -->
            <div class="filter-container">
                <form action="{{ route('operations.stock') }}" method="GET" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
                    <input type="hidden" name="tab" value="{{ $activeTab }}">
                    
                    <div style="display: flex; align-items: center; gap: 8px; font-size: 0.8rem; color: #555;">
                        <span>Afficher</span>
                        <select onchange="window.location.href = '{{ request()->fullUrlWithQuery(['per_page' => '']) }}'.replace('per_page=', 'per_page=' + this.value)"
                                class="filter-select">
                            <option value="8" {{ $perPage == 8 ? 'selected' : '' }}>8</option>
                            <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>10</option>
                            <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>25</option>
                            <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>50</option>
                        </select>
                        <span>résultats</span>
                    </div>

                    <div style="display: flex; gap: 8px; align-items: center;">
                        <span style="font-size: 0.8rem; color: #555; font-weight: 500;">Rechercher :</span>
                        <input type="text" name="search" value="{{ $search }}"
                               placeholder="Référence..."
                               class="filter-input">
                    </div>
                </form>
            </div>

            <!-- Table Pixel-Perfect -->
            <table class="table-mirror">
                <thead>
                    <tr>
                        <th style="width: 150px;">référence</th>
                        @if($activeTab != 'stock')
                            <th>client</th>
                            <th>vendeur</th>
                        @endif
                        @if($activeTab == 'stock')
                            <th style="width: 120px;">réception</th>
                            <th style="width: 140px;">échéance</th>
                            <th style="width: 115px;">statut</th>
                        @endif
                        <th style="width: 100px; text-align: right;">actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td style="font-weight: 400; font-size: 0.65rem; color: #555;">{{ $order->reference }}</td>
                            @if($activeTab != 'stock')
                                <td>
                                    <a href="#" class="item-main">
                                        {{ $order->buyer->prenom ?? '' }} {{ $order->buyer->nom ?? $order->buyer->name ?? 'Inconnu' }}
                                    </a>
                                    <div class="item-sub">{{ $order->buyer->telephone ?? '' }}</div>
                                </td>
                                <td>
                                    @php
                                        $sellerUser = ($order->seller && $order->seller->user) ? $order->seller->user : null;
                                        $sellerName = $sellerUser
                                            ? trim(($sellerUser->prenom ?? '') . ' ' . ($sellerUser->nom ?? ''))
                                            : ($order->seller->identite ?? 'Vendeur Inconnu');
                                        $sellerPhone = $sellerUser->telephone ?? '';
                                    @endphp
                                    <div class="item-main" style="color: #333; font-weight: 500;">{{ $sellerName ?: 'Vendeur Inconnu' }}</div>
                                    <div class="item-sub" style="display: flex; align-items: center; gap: 8px; margin-top: 2px;">
                                        @if($order->seller && $order->seller->type === 'professionnel')
                                            <span style="font-size: 0.6rem; background: #eee; padding: 1px 5px; border-radius: 3px; font-weight: bold; color: #666;">PRO</span>
                                        @endif
                                        <span>{{ $sellerPhone }}</span>
                                    </div>
                                </td>
                            @endif
                            @php
                                $label = match($order->statut) {
                                    'en_route'   => 'En route',
                                    'disponible' => 'Disponible',
                                    'livre'      => 'Livré',
                                    default      => $order->statut_label,
                                };
                                $openLitige = $order->litiges->firstWhere('statut', 'en_cours');
                            @endphp
                            @if($activeTab == 'stock')
                                @php
                                    $recDate  = $order->received_at ?? $order->updated_at;
                                    $echeance = $recDate ? $recDate->copy()->addDays(7) : null;
                                    $overdue  = $echeance && now()->greaterThan($echeance);
                                @endphp
                                <td style="color:#555; font-size:0.82rem;">
                                    <strong>{{ $recDate ? $recDate->format('d/m/Y') : '—' }}</strong>
                                </td>
                                <td style="font-size:0.82rem; color: {{ $overdue ? '#c0392b' : '#1e7d32' }};">
                                    <strong>{{ $echeance ? $echeance->format('d/m/Y') : '—' }}</strong>
                                    @if($overdue)
                                        <div style="margin-top:3px;"><span style="font-size:0.64rem; font-weight:700; background:#fdecea; color:#c0392b; padding:1px 6px; border-radius:4px;">à retourner</span></div>
                                    @endif
                                </td>
                                <td>
                                    @if($openLitige)
                                        <span style="display:inline-block;padding:3px 9px;border-radius:6px;font-size:0.66rem;font-weight:700;background:#fdecea;color:#c0392b;">Litige signalé</span>
                                    @elseif(($order->gestion_paiement ?? 'commande') === 'commande')
                                        <span style="display:inline-block;padding:3px 9px;border-radius:6px;font-size:0.66rem;font-weight:700;background:#eaf6e4;color:#3f7d18;">Payé</span>
                                    @else
                                        <span style="display:inline-block;padding:3px 9px;border-radius:6px;font-size:0.66rem;font-weight:700;background:#fff3e6;color:#b8560f;">Paiement à la livraison</span>
                                    @endif
                                </td>
                            @endif
                            <td style="text-align: right; display: flex; align-items: center; justify-content: flex-end; gap: 8px;">
                                <a href="{{ route('colis.show', $order->id) }}" class="mirror-link" style="color: #666;">Détails</a>

                                @if($activeTab == 'incoming')
                                    <span class="mirror-sep">|</span>
                                    <button type="button" onclick="confirmReceive('{{ $order->id }}', '{{ $order->reference }}')" class="mirror-link" style="background: none; border: none; font-weight: bold; color: #0066c0;">Réceptionner</button>
                                    <form id="receive-form-{{ $order->id }}" action="{{ route('colis.receive', $order->id) }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                @elseif($activeTab == 'stock')
                                    @if($openLitige)
                                        <span class="mirror-sep">|</span>
                                        <span style="color:#c0392b; font-weight:600; font-size:0.82rem;" title="Remise impossible : litige signalé">Litige signalé</span>
                                    @else
                                        <span class="mirror-sep">|</span>
                                        <button type="button" onclick="remettre('{{ $order->id }}', '{{ $order->reference }}', {{ (($order->gestion_paiement ?? 'commande') !== 'commande') ? 'true' : 'false' }}, '{{ number_format($order->total_final, 0, ',', ' ') }}')" class="mirror-link" style="background: none; border: none; font-weight: bold; color: #569b00;">Remettre au client</button>
                                        <form id="deliver-form-{{ $order->id }}" action="{{ route('colis.deliver', $order->id) }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                        <span class="mirror-sep">|</span>
                                        <button type="button" onclick="signalLitige('{{ $order->id }}', '{{ $order->reference }}')" class="mirror-link-red" style="background: none; border: none; font-weight: bold;">Signaler un litige</button>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $activeTab == 'stock' ? 5 : 4 }}" style="padding: 50px; text-align: center; color: #999;">Aucun résultat trouvé.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            @if($orders->total() > 0)
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 15px 20px; background: #ffffff; border: 1px solid #e7e7e7; border-top: none; margin-top: -20px;">
                    <div style="font-size: 0.85rem; color: #555; font-weight: 500;">
                        Affichage de {{ $orders->firstItem() }} à {{ $orders->lastItem() }} sur {{ $orders->total() }} résultats
                    </div>
                    <div style="display: flex; border: 1px solid #adb1b8; border-radius: 4px; overflow: hidden;">
                        @if($orders->onFirstPage())
                            <span style="padding: 7px 14px; background: #fdfdfd; color: #aaa; font-size: 0.85rem; border-right: 1px solid #adb1b8;">Précédent</span>
                        @else
                            <a href="{{ $orders->previousPageUrl() }}" style="padding: 7px 14px; background: #fff; color: #111; font-size: 0.85rem; text-decoration: none; border-right: 1px solid #adb1b8;">Précédent</a>
                        @endif

                        @for($i = max(1, $orders->currentPage() - 2); $i <= min($orders->lastPage(), max(1, $orders->currentPage() - 2) + 4); $i++)
                            @php $isActive = $i == $orders->currentPage(); @endphp
                            <a href="{{ $isActive ? '#' : $orders->url($i) }}" 
                               style="padding: 7px 14px; background: {{ $isActive ? '#007bff' : '#fff' }}; color: {{ $isActive ? '#fff' : '#555' }}; font-weight: {{ $isActive ? '700' : '400' }}; font-size: 0.85rem; text-decoration: none; border-right: 1px solid {{ $isActive ? '#004aad' : '#adb1b8' }};">
                               {{ $i }}
                            </a>
                        @endfor

                        @if($orders->hasMorePages())
                            <a href="{{ $orders->nextPageUrl() }}" style="padding: 7px 14px; background: #fff; color: #111; font-size: 0.85rem; text-decoration: none;">Suivant</a>
                        @else
                            <span style="padding: 7px 14px; background: #fdfdfd; color: #aaa; font-size: 0.85rem;">Suivant</span>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Modal de Scan -->
    <div id="scanModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); z-index: 2000; align-items: center; justify-content: center; padding: 20px;">
        <div style="background: #fff; width: 100%; max-width: 450px; border-radius: 8px; box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1); overflow: hidden;">
            <div style="padding: 20px; border-bottom: 1px solid #e5e7eb; display: flex; justify-content: space-between; align-items: center;">
                <h3 style="margin: 0; font-size: 1.1rem; font-weight: 600; color: #111;">Scanner un code-barres</h3>
                <button onclick="closeScanModal()" style="background: none; border: none; font-size: 1.5rem; color: #9ca3af; cursor: pointer; line-height: 1;">&times;</button>
            </div>
            <div style="padding: 24px;">
                <p style="font-size: 0.875rem; color: #4b5563; margin-bottom: 20px;">Utilisez votre lecteur de code-barres ou saisissez manuellement la référence du colis.</p>
                
                <div style="position: relative;">
                    <input type="text" id="barcodeInput" 
                           placeholder="Attente du scan..." 
                           style="width: 100%; padding: 12px 16px; border: 2px solid #0066c0; border-radius: 6px; font-size: 1rem; outline: none; background: #f0f7ff;"
                           autocomplete="off">
                    <div id="scanStatus" style="margin-top: 10px; font-size: 0.8rem; display: none;"></div>
                </div>
            </div>
            <div style="padding: 16px 24px; background: #f9fafb; border-top: 1px solid #e5e7eb; display: flex; justify-content: flex-end; gap: 12px;">
                <button onclick="closeScanModal()" style="padding: 8px 16px; background: #fff; border: 1px solid #d1d5db; border-radius: 6px; font-size: 0.875rem; color: #374151; cursor: pointer;">Fermer</button>
                <button onclick="processScan()" style="padding: 8px 20px; background: #0066c0; border: none; border-radius: 6px; font-size: 0.875rem; color: #fff; font-weight: 600; cursor: pointer;">Valider</button>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function openDetails(el) {
            const g = (k) => el.getAttribute('data-' + k) || '—';
            const row = (label, val) =>
                `<div style="display:flex;justify-content:space-between;gap:16px;padding:9px 0;border-bottom:1px solid #f0f0f0;">
                    <span style="color:#8a90a0;">${label}</span>
                    <span style="font-weight:600;color:#111;text-align:right;">${val}</span>
                 </div>`;
            Swal.fire({
                title: 'Détails du colis',
                html: `<div style="text-align:left;font-size:0.9rem;">
                    ${row('Référence', g('ref'))}
                    ${row('Client', g('client'))}
                    ${row('Téléphone client', g('clientphone'))}
                    ${row('Email client', g('clientemail'))}
                    ${row('Vendeur', g('seller'))}
                    ${row('Téléphone vendeur', g('sellerphone'))}
                    ${row('Statut', g('statut'))}
                    ${row('Date de commande', g('date'))}
                </div>`,
                confirmButtonText: 'Fermer',
                confirmButtonColor: '#004aad',
                width: 480
            });
        }

        function signalLitige(id, ref) {
            Swal.fire({
                title: 'Signaler un litige',
                html: `
                    <p style="font-size:0.85rem;color:#555;margin:0 0 12px;">Colis <b>${ref}</b> — à retourner</p>
                    <select id="litige-motif" class="litige-select">
                        <option value="non_recu">Client non venu (non récupéré)</option>
                        <option value="autre">Le client n'en veut plus</option>
                        <option value="non_conforme">Colis non conforme / abîmé</option>
                        <option value="autre">Autre</option>
                    </select>
                    <textarea id="litige-desc" class="swal2-textarea" style="margin:0;width:100%;" placeholder="Précision (facultatif)"></textarea>
                `,
                showCancelButton: true,
                confirmButtonText: 'Signaler',
                confirmButtonColor: '#c0392b',
                cancelButtonText: 'Annuler',
                preConfirm: () => ({
                    motif: document.getElementById('litige-motif').value,
                    description: document.getElementById('litige-desc').value
                })
            }).then((res) => {
                if (!res.isConfirmed) return;
                const f = document.createElement('form');
                f.method = 'POST';
                f.action = '{{ url('/stock') }}/' + id + '/litige';
                f.innerHTML = '<input type="hidden" name="_token" value="{{ csrf_token() }}">'
                    + '<input type="hidden" name="motif">'
                    + '<input type="hidden" name="description">';
                f.querySelector('[name=motif]').value = res.value.motif;
                f.querySelector('[name=description]').value = res.value.description || '';
                document.body.appendChild(f);
                f.submit();
            });
        }

        function confirmReceive(id, ref) {
            Swal.fire({
                title: 'Réceptionner ?',
                text: "Confirmer l'arrivée du colis " + ref,
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#0066c1',
                confirmButtonText: 'Confirmer',
                cancelButtonText: 'Annuler'
            }).then((result) => { if (result.isConfirmed) document.getElementById('receive-form-' + id).submit(); });
        }
        function remettre(id, ref, isCod, montant) {
            if (!isCod) {
                Swal.fire({
                    title: 'Remettre au client ?',
                    html: 'Colis <b>' + ref + '</b> (payé en ligne).',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Confirmer la remise',
                    confirmButtonColor: '#569b00',
                    cancelButtonText: 'Annuler'
                }).then(function (r) {
                    if (r.isConfirmed) document.getElementById('deliver-form-' + id).submit();
                });
                return;
            }
            Swal.fire({
                title: 'Encaissement',
                html: '<p style="font-size:0.86rem;color:#555;margin:0 0 12px;">Colis <b>' + ref + '</b><br>Montant à encaisser : <b>' + montant + ' FCFA</b></p>'
                    + '<select id="enc-methode" class="litige-select">'
                    + '<option value="espece">Espèces</option>'
                    + '<option value="mobile">Mobile Money</option>'
                    + '<option value="carte">Carte</option>'
                    + '</select>'
                    + '<input id="enc-ref" class="swal2-input" placeholder="Référence (Mobile Money / Carte)" style="margin-top:4px;">',
                showCancelButton: true,
                confirmButtonText: 'Encaisser & remettre',
                confirmButtonColor: '#569b00',
                cancelButtonText: 'Annuler',
                preConfirm: function () {
                    return {
                        methode: document.getElementById('enc-methode').value,
                        reference: document.getElementById('enc-ref').value
                    };
                }
            }).then(function (r) {
                if (!r.isConfirmed) return;
                var f = document.getElementById('deliver-form-' + id);
                var setHidden = function (name, val) {
                    var el = f.querySelector('[name="' + name + '"]');
                    if (!el) { el = document.createElement('input'); el.type = 'hidden'; el.name = name; f.appendChild(el); }
                    el.value = val || '';
                };
                setHidden('paiement_methode', r.value.methode);
                setHidden('paiement_reference', r.value.reference);
                f.submit();
            });
        }

        function confirmDeliver(id, ref) {
            Swal.fire({
                title: 'Remettre au client ?',
                text: "Confirmer la remise du colis " + ref,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#569b00',
                confirmButtonText: 'Confirmer',
                cancelButtonText: 'Annuler'
            }).then((result) => { if (result.isConfirmed) document.getElementById('deliver-form-' + id).submit(); });
        }

        // Scan Logic
        const scanModal = document.getElementById('scanModal');
        const barcodeInput = document.getElementById('barcodeInput');
        const scanStatus = document.getElementById('scanStatus');
        let isProcessing = false;

        function openScanModal() {
            scanModal.style.display = 'flex';
            barcodeInput.focus();
            scanStatus.style.display = 'none';
            barcodeInput.value = '';
        }

        function closeScanModal() {
            scanModal.style.display = 'none';
        }

        barcodeInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                processScan();
            }
        });

        function processScan() {
            const code = barcodeInput.value.trim();
            if (!code || isProcessing) return;

            isProcessing = true;
            scanStatus.style.display = 'block';
            scanStatus.style.color = '#0066c0';
            scanStatus.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Recherche du colis...';
            barcodeInput.disabled = true;

            fetch('{{ route("colis.scan") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ code: code })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        title: 'Succès !',
                        text: data.message,
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    scanStatus.style.color = '#c40000';
                    scanStatus.innerHTML = '<i class="fas fa-exclamation-circle"></i> ' + data.message;
                    barcodeInput.disabled = false;
                    barcodeInput.value = '';
                    barcodeInput.focus();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                scanStatus.style.color = '#c40000';
                scanStatus.innerHTML = '<i class="fas fa-exclamation-circle"></i> Une erreur est survenue.';
                barcodeInput.disabled = false;
            })
            .finally(() => {
                isProcessing = false;
            });
        }
    </script>
    @endpush
</x-app-layout>

<x-app-layout>
@php $activeTab = request('tab', 'utilisateur'); @endphp

{{-- ─── CSS (Amazon style, same as admin) ─── --}}
<style>
    .amazon-card {
        background: #fff;
        border: 1px solid #e7e7e7;
        border-radius: 0;
        box-shadow: 0 1px 1px rgba(0,0,0,0.03);
        padding: 22px 24px;
        margin-bottom: 16px;
    }
    .section-title {
        font-size: 1rem;
        font-weight: 600;
        color: #111;
        margin: 0 0 16px 0;
        padding-bottom: 10px;
        border-bottom: 1px solid #e7e7e7;
    }
    .form-label {
        display: block;
        font-size: 0.82rem;
        font-weight: 600;
        color: #111;
        margin-bottom: 5px;
    }
    .form-input {
        width: 100%;
        padding: 7px 10px;
        border: 1px solid #adb1b8;
        border-radius: 0;
        font-size: 0.85rem;
        outline: none;
        background: #fcfcfc;
        font-family: inherit;
        box-sizing: border-box;
    }
    .form-input:focus { 
        border: 2px solid #e77600 !important; 
        padding: 6px 9px; /* Adjust padding to keep total size consistent */
        outline: none;
        box-shadow: none !important;
        background: #fff;
    }
    .btn-amazon-primary {
        background: linear-gradient(180deg, #007bff 0%, #0056b3 100%);
        border: 1px solid #004aad;
        color: #fff;
        padding: 7px 20px;
        border-radius: 0;
        font-size: 0.85rem;
        font-weight: 400;
        box-shadow: 0 1px 0 rgba(255,255,255,.4) inset;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        text-decoration: none;
    }
    .btn-amazon-primary:hover { background: linear-gradient(180deg, #0069d9 0%, #004494 100%); }
    .btn-amazon-secondary {
        background: linear-gradient(to bottom, #f7f8fa, #e7e9ec);
        border: 1px solid #adb1b8;
        color: #111;
        padding: 7px 20px;
        border-radius: 0;
        font-size: 0.85rem;
        font-weight: 400;
        box-shadow: 0 1px 0 rgba(255,255,255,.6) inset;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 7px;
        text-decoration: none;
    }
    .btn-amazon-secondary:hover { background: linear-gradient(to bottom, #e7eaf0, #d8dade); }
    .btn-amazon-danger {
        background: linear-gradient(to bottom, #fff, #f8d7da);
        border: 1px solid #f5c6cb;
        color: #c40000;
        padding: 7px 20px;
        border-radius: 0;
        font-size: 0.85rem;
        font-weight: 400;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 7px;
        text-decoration: none;
    }
    .btn-amazon-danger:hover { background: linear-gradient(to bottom, #f8d7da, #f1aeb5); }
    .agence-content { background: #f8f9fa !important; }
 
    /* intl-tel-input integration (Amazon Style) */
    .iti { width: 100% !important; }
    .iti__selected-flag {
        border-right: 1px solid #adb1b8 !important; /* The vertical separator */
        padding-right: 12px !important;
        padding-left: 10px !important;
        background: #fcfcfc !important;
        border-radius: 0 !important;
        transition: background 0.2s;
    }
    .iti__selected-flag:hover {
        background: #f3f3f3 !important;
    }


    /* Focus state for the whole intl-tel-input area */
    .iti--focus .form-input {
        border: 2px solid #e77600 !important;
        padding: 6px 9px;
        box-shadow: none !important;
    }
    .iti--focus .iti__selected-flag {
        border-right-color: #e77600 !important;
    }
    /* Leaflet Map Styling */
    #map {
        height: 300px;
        width: 100%;
        border: 1px solid #adb1b8;
        margin-top: 15px;
        z-index: 1;
    }
    .btn-amazon-secondary.btn-sm {
        padding: 5px 12px;
        font-size: 0.78rem;
    }

    .pg-short { display: none; }

    /* ─── Responsive mobile ─── */
    @media (max-width: 768px) {
        /* Empiler tous les champs en 2 colonnes */
        [style*="grid-template-columns: 1fr 1fr"] { grid-template-columns: 1fr !important; }
        /* Supprimer l'effet "carte" : fond blanc, pleine largeur */
        .amazon-card { padding: 4px 0 !important; border: none !important; box-shadow: none !important; background: #fff !important; margin-bottom: 10px !important; }
        /* Barre "Afficher / Rechercher" : sans cadre, passe à la ligne, recherche pleine largeur */
        .table-controls { border: none !important; background: transparent !important; padding: 0 0 8px !important; flex-wrap: wrap; gap: 10px 14px; justify-content: flex-start !important; }
        .table-controls form { width: 100%; }
        .table-controls input[type="text"] { width: 100% !important; box-sizing: border-box; }
        /* Tableaux : défilables à l'intérieur (pas la page) */
        table { display: block; width: 100%; overflow-x: auto; white-space: nowrap; -webkit-overflow-scrolling: touch; }
        /* Modales adaptées à l'écran */
        [style*="max-width:480px"], [style*="max-width: 480px"] { max-width: 94% !important; }
        /* Bouton "Ajouter" : icône bleue seule */
        .btn-add-user .btn-label { display: none; }
        .btn-add-user { padding: 9px 13px !important; flex-shrink: 0; }
        /* Filtres : chaque groupe sur toute la largeur */
        .table-controls > div, .table-controls form { width: 100%; }
        /* Pagination : passe à la ligne, centrée */
        .pagination-bar { flex-wrap: wrap; gap: 10px; justify-content: center !important; }
        .pagination-bar > div:first-child { width: 100%; text-align: center; }
        /* Libellés pagination compacts (Préc / Suiv) */
        .pg-full { display: none; }
        .pg-short { display: inline; }
        /* Filtre recherche : "Rechercher :" au-dessus, champ pleine largeur */
        .table-controls form { flex-direction: column !important; align-items: stretch !important; gap: 6px !important; }
        .table-controls form label { font-weight: 600; }
        /* Masquer la barre de filtres ET la pagination sur mobile */
        .table-controls, .pagination-bar { display: none !important; }
    }
</style>
{{-- Leaflet CSS --}}
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>



{{-- ─── Tabs Sub-Header ─── --}}
@include('profile.partials.settings-tabs')

{{-- ─── Grey gap (same as admin sub-header → viewport spacing) ─── --}}
<div style="background: #f8f9fa; margin: 0 -1.5rem; padding: 0.75rem 0 0 0;"></div>

{{-- ─── Content Card ─── --}}
<div style="background: #fff; border: 1px solid #e7e7e7; padding: 24px; margin-top: 0;">

    {{-- ══ TAB: UTILISATEUR ══ --}}
    @if($activeTab === 'utilisateur')

        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <h1 style="font-size: 1.1rem; font-weight: 500; color: #111; margin: 0;">Gestion des utilisateurs</h1>
        </div>

        {{-- Agency Users Table Card --}}
        @if($agence)
        <div class="amazon-card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 1px solid #e7e7e7;">
                <h3 style="font-size: 1rem; font-weight: 600; color: #111; margin: 0;">Utilisateurs de l'agence</h3>
                <button type="button" class="btn-amazon-primary btn-add-user" onclick="document.getElementById('addUserModal').style.display='flex'" title="Ajouter un utilisateur">
                    <i class="fas fa-plus"></i> <span class="btn-label">Ajouter un utilisateur</span>
                </button>
            </div>

            @if(session('status') === 'user-added')
                <div style="background: #f2fdf2; border: 1px solid #d5f9d5; color: #287a28; padding: 12px; font-size: 0.82rem; margin-bottom: 16px;" class="auto-hide-msg">
                    <i class="fas fa-check-circle"></i> Utilisateur ajouté avec succès.
                </div>
            @endif

            @if(session('status') === 'user-updated')
                <div style="background: #f2fdf2; border: 1px solid #d5f9d5; color: #287a28; padding: 12px; font-size: 0.82rem; margin-bottom: 16px;" class="auto-hide-msg">
                    <i class="fas fa-check-circle"></i> Utilisateur mis à jour avec succès.
                </div>
            @endif

            @if(session('status') === 'user-deleted')
                <div style="background: #fff8f8; border: 1px solid #fecaca; color: #b91c1c; padding: 12px; font-size: 0.82rem; margin-bottom: 16px;" class="auto-hide-msg">
                    <i class="fas fa-trash-alt"></i> Utilisateur supprimé avec succès.
                </div>
            @endif

            <!-- Barre de recherche & Filtres Style Admin/Amazon -->
            <div class="table-controls" style="background: #fbfbfc; border: 1px solid #e7e7e7; padding: 12px 20px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-radius: 4px;">
                <div style="display: flex; align-items: center; gap: 10px; font-size: 0.85rem; color: #111;">
                    <span>Afficher</span>
                    <select onchange="window.location.href = '{{ route('profile.edit', ['tab' => 'utilisateur']) }}&per_page=' + this.value + '&search={{ urlencode($search) }}'"
                            style="padding: 4px 10px; border: 1px solid #adb1b8; border-radius: 3px; background: #fff; font-size: 0.85rem; color: #111; cursor: pointer; outline: none;">
                        <option value="8" {{ ($perPage ?? 8) == 8 ? 'selected' : '' }}>8</option>
                        <option value="25" {{ ($perPage ?? 8) == 25 ? 'selected' : '' }}>25</option>
                        <option value="50" {{ ($perPage ?? 8) == 50 ? 'selected' : '' }}>50</option>
                        <option value="100" {{ ($perPage ?? 8) == 100 ? 'selected' : '' }}>100</option>
                    </select>
                    <span>résultats</span>
                </div>

                <form action="{{ route('profile.edit') }}" method="GET" style="display: flex; align-items: center; gap: 12px;">
                    <input type="hidden" name="tab" value="utilisateur">
                    <input type="hidden" name="per_page" value="{{ $perPage ?? 8 }}">
                    <label style="font-size: 0.85rem; color: #111; font-weight: 400;">Rechercher :</label>
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Nom ou email..."
                           style="width: 250px; padding: 6px 12px; border: 1px solid #adb1b8; border-radius: 3px; outline: none; font-size: 0.85rem; box-shadow: 0 1px 2px rgba(0,0,0,0.05) inset;">
                </form>
            </div>

            <table style="width: 100%; border-collapse: collapse; border: 1px solid #e7e7e7; margin-bottom: 20px;">
                <thead>
                    <tr style="background: #f6f6f6; border-bottom: 1px solid #e7e7e7;">
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7;">Utilisateur</th>
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7;">Email</th>
                        <th style="padding: 10px 15px; text-align: left; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase; border-right: 1px solid #e7e7e7;">Rôles</th>
                        <th style="padding: 10px 15px; text-align: right; font-size: 0.75rem; font-weight: 700; color: #111; text-transform: uppercase;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $u)
                        <tr style="border-bottom: 1px solid #e7e7e7; transition: background 0.1s;" onmouseover="this.style.background='#f9f9f9'" onmouseout="this.style.background='transparent'">
                            <td style="padding: 12px 15px; font-size: 0.85rem; color: #0066c0; font-weight: 500; border-right: 1px solid #e7e7e7;">{{ $u->name }}</td>
                            <td style="padding: 12px 15px; font-size: 0.85rem; color: #555; border-right: 1px solid #e7e7e7;">{{ $u->email }}</td>
                            <td style="padding: 12px 15px; font-size: 0.85rem; color: #555; border-right: 1px solid #e7e7e7;">
                                @forelse($u->roles as $role)
                                    <span style="background: #f3f3f3; padding: 2px 8px; border-radius: 0; font-size: 0.75rem; border: 1px solid #adb1b8; margin-right: 4px;">{{ $role->name }}</span>
                                @empty
                                    <span style="color: #999; font-style: italic; font-size: 0.8rem;">Aucun rôle</span>
                                @endforelse
                            </td>
                            <td style="padding: 12px 15px; text-align: right;">
                                <div style="display: flex; gap: 15px; justify-content: flex-end; align-items: center;">
                                    {{-- Modifier --}}
                                    <button type="button" 
                                            onclick="openEditUserModal('{{ $u->id }}', '{{ addslashes($u->prenom) }}', '{{ addslashes($u->nom) }}', '{{ addslashes($u->email) }}')"
                                            style="color: #0066c0; background: none; border: none; font-size: 0.8rem; cursor: pointer; padding: 0;"
                                            onmouseover="this.style.textDecoration='underline'" 
                                            onmouseout="this.style.textDecoration='none'">
                                        Modifier
                                    </button>

                                    {{-- Supprimer --}}
                                    <form action="{{ route('profile.users.destroy', $u) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir retirer cet utilisateur de l\'agence ?')" style="display: inline;">
                                        @csrf @method('DELETE')
                                        <button type="submit" 
                                                style="color: #b91c1c; background: none; border: none; font-size: 0.8rem; cursor: pointer; padding: 0;"
                                                onmouseover="this.style.textDecoration='underline'" 
                                                onmouseout="this.style.textDecoration='none'">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="padding: 3rem; text-align: center; color: #999; font-size: 0.85rem;">
                                Aucun utilisateur trouvé.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            {{-- Pagination Harmonisée --}}
            <div class="pagination-bar" style="display: flex; justify-content: space-between; align-items: center; padding: 12px 16px; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 0; margin-top: 10px;">
                <div style="font-size: 0.8rem; color: #64748b; font-weight: 500;">
                    Affichage de {{ $users->firstItem() ?? 0 }} à {{ $users->lastItem() ?? 0 }} sur {{ $users->total() }} résultats
                </div>
                <div style="display: flex; border: 1px solid #adb1b8; border-radius: 0; overflow: hidden; box-shadow: 0 1px 2px rgba(0,0,0,0.05); background: #fff;">
                    @if($users->onFirstPage())
                        <span style="padding: 6px 12px; background: #f7f8fa; color: #999; font-size: 0.8rem; border-right: 1px solid #adb1b8;"><span class="pg-full">Précédent</span><span class="pg-short">Préc</span></span>
                    @else
                        <a href="{{ $users->previousPageUrl() }}" style="padding: 6px 12px; background: #fff; color: #111; font-size: 0.8rem; text-decoration: none; border-right: 1px solid #adb1b8;"><span class="pg-full">Précédent</span><span class="pg-short">Préc</span></a>
                    @endif

                    @php
                        $fStart = max(1, $users->currentPage() - 2);
                        $fEnd = min($users->lastPage(), $fStart + 4);
                    @endphp

                    @for($i = $fStart; $i <= $fEnd; $i++)
                        @if($i == $users->currentPage())
                            <span style="padding: 6px 12px; background: linear-gradient(180deg, #007bff 0%, #0056b3 100%); color: #fff; font-weight: 700; font-size: 0.8rem; border-right: 1px solid #004aad;">{{ $i }}</span>
                        @else
                            <a href="{{ $users->url($i) }}" style="padding: 6px 12px; background: #fff; color: #555; font-size: 0.8rem; text-decoration: none; border-right: 1px solid #adb1b8;">{{ $i }}</a>
                        @endif
                    @endfor

                    @if($users->hasMorePages())
                        <a href="{{ $users->nextPageUrl() }}" style="padding: 6px 12px; background: #fff; color: #111; font-size: 0.8rem; text-decoration: none;"><span class="pg-full">Suivant</span><span class="pg-short">Suiv</span></a>
                    @else
                        <span style="padding: 6px 12px; background: #f7f8fa; color: #999; font-size: 0.8rem;"><span class="pg-full">Suivant</span><span class="pg-short">Suiv</span></span>
                    @endif
                </div>
            </div>
        </div>

        {{-- Add User Modal --}}
        <div id="addUserModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
            <div style="background:#fff; border:1px solid #ddd; padding:24px; max-width:480px; width:90%; box-shadow:0 4px 20px rgba(0,0,0,0.15);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h2 style="font-size:1.1rem; font-weight:600; color:#111; margin:0;">Ajouter un utilisateur</h2>
                    <button type="button" onclick="document.getElementById('addUserModal').style.display='none'" style="background:none; border:none; font-size:1.5rem; cursor:pointer; color:#888;">&times;</button>
                </div>
                <form method="POST" action="{{ route('profile.users.store') }}">
                    @csrf
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                        <div>
                            <label for="new_prenom" class="form-label">Prénom</label>
                            <input id="new_prenom" name="prenom" type="text" class="form-input" required>
                        </div>
                        <div>
                            <label for="new_nom" class="form-label">Nom</label>
                            <input id="new_nom" name="nom" type="text" class="form-input" required>
                        </div>
                    </div>
                    <div style="margin-bottom: 16px;">
                        <label for="new_email" class="form-label">Adresse e-mail</label>
                        <input id="new_email" name="email" type="email" class="form-input" required>
                    </div>
                    <div style="margin-bottom: 16px;">
                        <label for="new_password" class="form-label">Mot de passe</label>
                        <div style="position:relative;">
                            <input id="new_password" name="password" type="password" class="form-input" style="padding-right:40px;" required minlength="8">
                            <button type="button" onclick="togglePw('new_password', this)" style="position:absolute;right:8px;top:50%;transform:translateY(-50%);background:none;border:none;color:#666;cursor:pointer;padding:4px;" aria-label="Afficher/masquer">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label for="new_password_confirmation" class="form-label">Confirmer le mot de passe</label>
                        <div style="position:relative;">
                            <input id="new_password_confirmation" name="password_confirmation" type="password" class="form-input" style="padding-right:40px;" required minlength="8">
                            <button type="button" onclick="togglePw('new_password_confirmation', this)" style="position:absolute;right:8px;top:50%;transform:translateY(-50%);background:none;border:none;color:#666;cursor:pointer;padding:4px;" aria-label="Afficher/masquer">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div style="display:flex; gap:8px; justify-content:flex-end; border-top: 1px solid #e7e7e7; padding-top: 16px;">
                        <button type="button" class="btn-amazon-secondary" onclick="document.getElementById('addUserModal').style.display='none'">
                            Annuler
                        </button>
                        <button type="submit" class="btn-amazon-primary">
                            <i class="fas fa-user-plus"></i> Créer l'utilisateur
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Edit User Modal --}}
        <div id="editUserModal" style="display:none; position:fixed; inset:0; background:rgba(0,0,0,0.5); z-index:9999; align-items:center; justify-content:center;">
            <div style="background:#fff; border:1px solid #ddd; padding:24px; max-width:480px; width:90%; box-shadow:0 4px 20px rgba(0,0,0,0.15);">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                    <h2 style="font-size:1.1rem; font-weight:600; color:#111; margin:0;">Modifier l'utilisateur</h2>
                    <button type="button" onclick="document.getElementById('editUserModal').style.display='none'" style="background:none; border:none; font-size:1.5rem; cursor:pointer; color:#888;">&times;</button>
                </div>
                <form id="editUserForm" method="POST" action="">
                    @csrf @method('PATCH')
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                        <div>
                            <label for="edit_prenom" class="form-label">Prénom</label>
                            <input id="edit_prenom" name="prenom" type="text" class="form-input" required>
                        </div>
                        <div>
                            <label for="edit_nom" class="form-label">Nom</label>
                            <input id="edit_nom" name="nom" type="text" class="form-input" required>
                        </div>
                    </div>
                    <div style="margin-bottom: 16px;">
                        <label for="edit_email" class="form-label">Adresse e-mail</label>
                        <input id="edit_email" name="email" type="email" class="form-input" required>
                    </div>
                    <div style="margin-bottom: 16px;">
                        <label for="edit_password" class="form-label">Nouveau mot de passe <span style="font-weight:400;color:#888;">(laisser vide pour ne pas changer)</span></label>
                        <div style="position:relative;">
                            <input id="edit_password" name="password" type="password" class="form-input" style="padding-right:40px;" minlength="8" autocomplete="new-password">
                            <button type="button" onclick="togglePw('edit_password', this)" style="position:absolute;right:8px;top:50%;transform:translateY(-50%);background:none;border:none;color:#666;cursor:pointer;padding:4px;" aria-label="Afficher/masquer">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div style="margin-bottom: 20px;">
                        <label for="edit_password_confirmation" class="form-label">Confirmer le mot de passe</label>
                        <div style="position:relative;">
                            <input id="edit_password_confirmation" name="password_confirmation" type="password" class="form-input" style="padding-right:40px;" minlength="8" autocomplete="new-password">
                            <button type="button" onclick="togglePw('edit_password_confirmation', this)" style="position:absolute;right:8px;top:50%;transform:translateY(-50%);background:none;border:none;color:#666;cursor:pointer;padding:4px;" aria-label="Afficher/masquer">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                    <div style="display:flex; gap:8px; justify-content:flex-end; border-top: 1px solid #e7e7e7; padding-top: 16px;">
                        <button type="button" class="btn-amazon-secondary" onclick="document.getElementById('editUserModal').style.display='none'">
                            Annuler
                        </button>
                        <button type="submit" class="btn-amazon-primary">
                            <i class="fas fa-save"></i> Enregistrer les modifications
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <script>
            function togglePw(id, btn) {
                const inp = document.getElementById(id);
                const icon = btn.querySelector('i');
                if (inp.type === 'password') { inp.type = 'text'; icon.className = 'fas fa-eye-slash'; }
                else { inp.type = 'password'; icon.className = 'fas fa-eye'; }
            }

            // Faire disparaître les messages de succès après quelques secondes
            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('.auto-hide-msg').forEach(function (el) {
                    setTimeout(function () {
                        el.style.transition = 'opacity 0.5s';
                        el.style.opacity = '0';
                        setTimeout(function () { el.style.display = 'none'; }, 500);
                    }, 4000);
                });
            });

            function openEditUserModal(id, prenom, nom, email) {
                const modal = document.getElementById('editUserModal');
                const form = document.getElementById('editUserForm');
                
                // Update form action
                form.action = "{{ url('/profile/users') }}/" + id;
                
                // Populate fields
                document.getElementById('edit_prenom').value = prenom;
                document.getElementById('edit_nom').value = nom;
                document.getElementById('edit_email').value = email;
                
                // Show modal
                modal.style.display = 'flex';
            }
        </script>
        @endif

    {{-- ══ TAB: CONFIGURATION ══ --}}
    @elseif($activeTab === 'configuration')
        <div>
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h1 style="font-size: 1.1rem; font-weight: 500; color: #111; margin: 0;">Configuration de l'agence</h1>
            </div>

            @if(session('error'))
                <div style="background: #fdf2f2; border: 1px solid #f9d5d5; color: #c40000; padding: 12px; font-size: 0.85rem; margin-bottom: 20px;">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            @if(session('status') === 'agence-updated')
                <div style="background: #f2fdf2; border: 1px solid #d5f9d5; color: #287a28; padding: 12px; font-size: 0.85rem; margin-bottom: 20px;">
                    <i class="fas fa-check-circle"></i> Les paramètres de l'agence ont été mis à jour avec succès.
                </div>
            @endif

            <form method="POST" action="{{ route('profile.agence.update') }}">
                @csrf @method('patch')

                {{-- General Info Card --}}
                <div class="amazon-card">
                    <h3 class="section-title">Informations Générales</h3>
                    <div style="display: grid; grid-template-columns: 1fr; gap: 20px; margin-bottom: 20px;">
                        <div>
                            <label for="nom" class="form-label">Nom de l'agence</label>
                            <input id="nom" name="nom" type="text" class="form-input"
                                   value="{{ old('nom', $agence->nom ?? '') }}" required>
                            @error('nom')<p style="color:#c40000;font-size:0.78rem;margin-top:4px;">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                        <div>
                            <label for="email" class="form-label">Email de l'agence</label>
                            <input id="email" name="email" type="email" class="form-input"
                                   value="{{ old('email', $agence->email ?? '') }}">
                            @error('email')<p style="color:#c40000;font-size:0.78rem;margin-top:4px;">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="telephone_number" class="form-label">Téléphone de l'agence</label>
                            <div style="display:flex; border:1px solid #adb1b8; border-radius:4px; overflow:hidden; background:#fff;">
                                <span id="tel-indicatif" style="padding:0 12px; display:flex; align-items:center; background:#f3f4f6; color:#374151; font-size:0.9rem; border-right:1px solid #adb1b8; white-space:nowrap;">+---</span>
                                <input id="telephone_number" type="tel" placeholder="Numéro" style="flex:1; border:none; outline:none; padding:0.6rem 0.75rem; font-size:0.9rem; min-width:0;">
                            </div>
                            <input type="hidden" id="telephone" name="telephone" value="{{ old('telephone', $agence->telephone ?? '') }}">
                            @error('telephone')<p style="color:#c40000;font-size:0.78rem;margin-top:4px;">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr; gap: 20px; margin-bottom: 20px;">
                        <div>
                            <label for="adresse" class="form-label">Adresse physique</label>
                            <input id="adresse" name="adresse" type="text" class="form-input"
                                   value="{{ old('adresse', $agence->adresse ?? '') }}" required>
                            @error('adresse')<p style="color:#c40000;font-size:0.78rem;margin-top:4px;">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                        <div>
                            <label for="region" class="form-label">Région / Ville</label>
                            <select id="region" name="region" class="form-input">
                                <option value="">Sélectionner une région</option>
                            </select>
                            @error('region')<p style="color:#c40000;font-size:0.78rem;margin-top:4px;">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label for="pays" class="form-label">Pays</label>
                            <select id="pays" name="pays" class="form-input" required>
                                <option value="">Sélectionner un pays</option>
                                @foreach($countries as $c)
                                    <option value="{{ $c->name }}" data-id="{{ $c->id }}" data-phone="{{ $c->phone_code }}"
                                        {{ old('pays', $agence->pays ?? '') == $c->name ? 'selected' : '' }}>
                                        {{ $c->flag }} {{ $c->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('pays')<p style="color:#c40000;font-size:0.78rem;margin-top:4px;">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                {{-- Localisation Card --}}
                <div class="amazon-card">
                    <h3 class="section-title">Localisation</h3>

                    {{-- Champs soumis avec le formulaire (renseignés via la fenêtre) --}}
                    <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude', $agence->latitude ?? '') }}">
                    <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude', $agence->longitude ?? '') }}">
                    <input type="hidden" name="google_maps_url" id="google_maps_url" value="{{ old('google_maps_url', $agence->google_maps_url ?? '') }}">

                    <div style="display:flex;align-items:center;justify-content:space-between;gap:14px;flex-wrap:wrap;">
                        <div style="min-width:0;">
                            <p id="loc-summary" style="font-size:0.9rem;color:#111;margin:0;font-weight:500;">Aucune localisation définie</p>
                            <p style="font-size:0.78rem;color:#888;margin:3px 0 0;">Définissez l'emplacement exact de votre agence sur la carte.</p>
                        </div>
                        <button type="button" class="btn-amazon-secondary" style="white-space:nowrap;" onclick="openLocModal()">
                            <i class="fas fa-map-marker-alt"></i> Définir la localisation
                        </button>
                    </div>
                    @error('latitude')<p style="color:#c40000;font-size:0.78rem;margin-top:6px;">{{ $message }}</p>@enderror
                    @error('longitude')<p style="color:#c40000;font-size:0.78rem;margin-top:2px;">{{ $message }}</p>@enderror
                </div>

                {{-- Fenêtre (modale) de localisation --}}
                <div id="loc-modal" style="display:none;position:fixed;inset:0;z-index:99999;background:rgba(0,0,0,.55);align-items:center;justify-content:center;padding:16px;">
                    <div style="background:#fff;width:100%;max-width:820px;border-radius:10px;overflow:hidden;display:flex;flex-direction:column;max-height:92vh;">
                        <div style="padding:14px 18px;border-bottom:1px solid #eee;display:flex;justify-content:space-between;align-items:center;">
                            <strong style="font-size:1rem;">Définir la localisation</strong>
                            <button type="button" onclick="closeLocModal()" style="background:none;border:none;font-size:26px;line-height:1;cursor:pointer;color:#666;">&times;</button>
                        </div>
                        <div style="padding:16px 18px;overflow:auto;">
                            <div style="display:flex;gap:8px;margin-bottom:10px;">
                                <input id="addr-search" type="text" class="form-input" style="flex:1;"
                                       placeholder="Rechercher une adresse ou un lieu…"
                                       onkeydown="if(event.key==='Enter'){event.preventDefault();searchAddress();}">
                                <button type="button" class="btn-amazon-secondary" style="white-space:nowrap;" onclick="searchAddress()">
                                    <i class="fas fa-search"></i> Rechercher
                                </button>
                            </div>
                            <div style="display:flex;gap:16px;flex-wrap:wrap;align-items:center;margin-bottom:8px;">
                                <button type="button" onclick="getLocation(event)" class="btn-amazon-secondary btn-sm">
                                    <i class="fas fa-location-crosshairs"></i> Ma position (GPS — précis sur téléphone)
                                </button>
                                <button type="button" onclick="locateByIP()"
                                        style="background:none;border:none;color:#0071BC;font-size:0.8rem;cursor:pointer;padding:0;text-decoration:underline;">
                                    Me localiser via ma connexion (approximatif)
                                </button>
                            </div>
                            <p id="addr-search-msg" style="font-size:0.75rem;color:#888;margin:0 0 10px;"></p>
                            <div id="map"></div>
                            <p style="font-size:0.78rem;color:#888;margin-top:8px;">Cliquez sur la carte ou déplacez le marqueur pour ajuster au point exact.</p>
                        </div>
                        <div style="padding:12px 18px;border-top:1px solid #eee;display:flex;justify-content:flex-end;gap:10px;">
                            <button type="button" class="btn-amazon-secondary" onclick="closeLocModal()">Annuler</button>
                            <button type="button" class="btn-amazon-primary" onclick="confirmLoc()">Valider</button>
                        </div>
                    </div>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 10px; padding-top: 20px;">
                    <button type="submit" class="btn-amazon-primary" style="padding: 10px 40px;">
                        <i class="fas fa-save"></i> Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    @endif
</div>


<x-slot:scripts>
<script>
    window.itiInstance = null;
    window.initPhoneField = function (el) {
        if (!el || el.dataset.itiInit) return;
        const tryInit = () => {
            if (window.intlTelInput) {
                window.itiInstance = window.intlTelInput(el, {
                    initialCountry: 'sn',
                    separateDialCode: true,
                    allowDropdown: true,
                    dropdownContainer: document.body,
                    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/24.5.0/build/js/utils.js"
                });
                el.dataset.itiInit = 'true';

                // Sync with Pays select
                const paysSelect = document.getElementById('pays');
                if (paysSelect) {
                    paysSelect.addEventListener('change', function() {
                        const isoCode = this.options[this.selectedIndex].getAttribute('data-iso');
                        if (isoCode && window.itiInstance) {
                            window.itiInstance.setCountry(isoCode);
                        }
                    });

                    el.addEventListener('countrychange', function() {
                        const countryData = window.itiInstance.getSelectedCountryData();
                        if (countryData && countryData.iso2) {
                            for (let i = 0; i < paysSelect.options.length; i++) {
                                if (paysSelect.options[i].getAttribute('data-iso') === countryData.iso2) {
                                    paysSelect.selectedIndex = i;
                                    break;
                                }
                            }
                        }
                    });
                }
            } else {
                setTimeout(tryInit, 100);
            }
        };
        tryInit();
    };

</x-slot:scripts>

{{-- Leaflet JS --}}
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    let map, marker;
    
    function initMap() {
        if (!document.getElementById('map')) return; // onglet sans carte
        const mapsInput = document.getElementById('google_maps_url');
        const latHidden = document.getElementById('latitude');
        const lngHidden = document.getElementById('longitude');
        
        let startLat = parseFloat(latHidden.value);
        let startLng = parseFloat(lngHidden.value);

        // Try to extract from URL if hidden inputs are empty
        if ((isNaN(startLat) || isNaN(startLng)) && mapsInput.value) {
            const coords = parseGoogleMapsUrl(mapsInput.value);
            if (coords) {
                startLat = coords.lat;
                startLng = coords.lng;
            }
        }

        if (isNaN(startLat)) startLat = 14.7167; // Default Dakar
        if (isNaN(startLng)) startLng = -17.4677;

        map = L.map('map').setView([startLat, startLng], (mapsInput.value ? 15 : 12));
        
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);
        
        marker = L.marker([startLat, startLng], {draggable: true}).addTo(map);
        
        // Sync Marker -> Input
        const updateInput = (pos) => {
            const lat = pos.lat.toFixed(6);
            const lng = pos.lng.toFixed(6);
            latHidden.value = lat;
            lngHidden.value = lng;
            mapsInput.value = `https://www.google.com/maps?q=${lat},${lng}`;
        };

        marker.on('dragend', (e) => updateInput(marker.getLatLng()));
        map.on('click', (e) => {
            marker.setLatLng(e.latlng);
            updateInput(e.latlng);
        });

        // Sync Input -> Map (lien Google Maps)
        mapsInput.addEventListener('input', () => {
            const coords = parseGoogleMapsUrl(mapsInput.value);
            if (coords) {
                const newLatLng = new L.LatLng(coords.lat, coords.lng);
                marker.setLatLng(newLatLng);
                map.panTo(newLatLng);
                latHidden.value = coords.lat;
                lngHidden.value = coords.lng;
            }
        });

        // Sync champs Latitude / Longitude -> carte (saisie manuelle)
        const syncFromFields = () => {
            const la = parseFloat(latHidden.value);
            const ln = parseFloat(lngHidden.value);
            if (!isNaN(la) && !isNaN(ln)) {
                const p = new L.LatLng(la, ln);
                marker.setLatLng(p);
                map.panTo(p);
                mapsInput.value = `https://www.google.com/maps?q=${la},${ln}`;
            }
        };
        latHidden.addEventListener('change', syncFromFields);
        lngHidden.addEventListener('change', syncFromFields);
    }

    function parseGoogleMapsUrl(url) {
        // Handle q=lat,lng format
        let match = url.match(/q=([-+]?\d+\.\d+),([-+]?\d+\.\d+)/);
        if (match) return { lat: parseFloat(match[1]), lng: parseFloat(match[2]) };
        
        // Handle @lat,lng format
        match = url.match(/@([-+]?\d+\.\d+),([-+]?\d+\.\d+)/);
        if (match) return { lat: parseFloat(match[1]), lng: parseFloat(match[2]) };

        return null;
    }
    
    function openMaps() {
        const url = document.getElementById('google_maps_url').value;
        window.open(url || 'https://www.google.com/maps', '_blank');
    }

    function getLocation(e) {
        if (navigator.geolocation) {
            const btn = e ? e.currentTarget : null;
            const originalHtml = btn ? btn.innerHTML : '';
            if (btn) btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>...';
            
            navigator.geolocation.getCurrentPosition(
                (pos) => {
                    const lat = pos.coords.latitude;
                    const lng = pos.coords.longitude;
                    const newLatLng = new L.LatLng(lat, lng);
                    
                    marker.setLatLng(newLatLng);
                    map.setView(newLatLng, 17);
                    
                    document.getElementById('latitude').value = lat.toFixed(6);
                    document.getElementById('longitude').value = lng.toFixed(6);
                    document.getElementById('google_maps_url').value = `https://www.google.com/maps?q=${lat.toFixed(6)},${lng.toFixed(6)}`;
                    
                    if (btn) btn.innerHTML = originalHtml;
                },
                (err) => {
                    alert("Géolocalisation échouée : " + err.message);
                    if (btn) btn.innerHTML = originalHtml;
                },
                { enableHighAccuracy: true, timeout: 15000, maximumAge: 0 }
            );
        }
    }
    
    function searchAddress() {
        const input = document.getElementById('addr-search');
        const msg = document.getElementById('addr-search-msg');
        const q = (input.value || '').trim();
        if (!q) return;
        msg.style.color = '#888';
        msg.textContent = 'Recherche en cours…';
        fetch('https://nominatim.openstreetmap.org/search?format=json&limit=1&q=' + encodeURIComponent(q), {
            headers: { 'Accept': 'application/json' }
        })
        .then(r => r.json())
        .then(data => {
            if (!data || !data.length) {
                msg.style.color = '#c40000';
                msg.textContent = "Adresse introuvable. Soyez plus précis, ou cliquez directement sur la carte.";
                return;
            }
            const lat = parseFloat(data[0].lat);
            const lng = parseFloat(data[0].lon);
            const p = new L.LatLng(lat, lng);
            if (marker && map) { marker.setLatLng(p); map.setView(p, 17); }
            document.getElementById('latitude').value = lat.toFixed(6);
            document.getElementById('longitude').value = lng.toFixed(6);
            document.getElementById('google_maps_url').value = 'https://www.google.com/maps?q=' + lat.toFixed(6) + ',' + lng.toFixed(6);
            msg.style.color = '#067d00';
            msg.textContent = '📍 ' + data[0].display_name + ' — ajustez au besoin en déplaçant le marqueur.';
        })
        .catch(() => {
            msg.style.color = '#c40000';
            msg.textContent = "Erreur de recherche. Réessayez, ou cliquez sur la carte.";
        });
    }

    function locateByIP() {
        const msg = document.getElementById('addr-search-msg');
        msg.style.color = '#888';
        msg.textContent = 'Localisation approximative en cours…';
        fetch('https://ipapi.co/json/')
            .then(r => r.json())
            .then(d => {
                const lat = parseFloat(d.latitude);
                const lng = parseFloat(d.longitude);
                if (isNaN(lat) || isNaN(lng)) throw new Error('no-coords');
                const p = new L.LatLng(lat, lng);
                if (marker && map) { marker.setLatLng(p); map.setView(p, 13); }
                document.getElementById('latitude').value = lat.toFixed(6);
                document.getElementById('longitude').value = lng.toFixed(6);
                document.getElementById('google_maps_url').value = 'https://www.google.com/maps?q=' + lat.toFixed(6) + ',' + lng.toFixed(6);
                msg.style.color = '#8a6d00';
                msg.textContent = 'Position approximative' + (d.city ? ' (' + d.city + ')' : '') + '. Déplacez le marqueur pour l\'ajuster exactement.';
            })
            .catch(() => {
                msg.style.color = '#c40000';
                msg.textContent = "Localisation automatique indisponible. Utilisez la recherche d'adresse ou cliquez sur la carte.";
            });
    }

    let locMapInited = false;

    function updateSummary() {
        const el = document.getElementById('loc-summary');
        if (!el) return;
        const lat = parseFloat(document.getElementById('latitude').value);
        const lng = parseFloat(document.getElementById('longitude').value);
        if (!isNaN(lat) && !isNaN(lng)) {
            el.innerHTML = 'Localisation définie <span style="color:#888;font-weight:400;">(' + lat.toFixed(5) + ', ' + lng.toFixed(5) + ')</span>';
        } else {
            el.textContent = 'Aucune localisation définie';
        }
    }

    function openLocModal() {
        document.getElementById('loc-modal').style.display = 'flex';
        if (!locMapInited) { initMap(); locMapInited = true; }
        setTimeout(() => { if (map) map.invalidateSize(); }, 200);
    }
    function closeLocModal() {
        document.getElementById('loc-modal').style.display = 'none';
    }
    function confirmLoc() {
        updateSummary();
        closeLocModal();
    }

    document.addEventListener('DOMContentLoaded', updateSummary);

    // ─── Address Search (Nominatim) ───────────────────────────────────────────
    let searchTimeout = null;

    function setupAddressSearch() {
        const searchInput = document.getElementById('address_search');
        const suggestions = document.getElementById('search_suggestions');
        if (!searchInput) return;

        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            const query = this.value.trim();
            if (query.length < 3) {
                suggestions.style.display = 'none';
                return;
            }
            searchTimeout = setTimeout(() => fetchSuggestions(query), 400);
        });

        // Close on click outside
        document.addEventListener('click', (e) => {
            if (!searchInput.contains(e.target) && !suggestions.contains(e.target)) {
                suggestions.style.display = 'none';
            }
        });
    }

    function fetchSuggestions(query) {
        const suggestions = document.getElementById('search_suggestions');
        suggestions.innerHTML = '<div style="padding:10px;color:#888;"><i class="fas fa-spinner fa-spin"></i> Recherche...</div>';
        suggestions.style.display = 'block';

        const url = `https://nominatim.openstreetmap.org/search?q=${encodeURIComponent(query)}&format=json&limit=6&addressdetails=1`;

        fetch(url, { headers: { 'Accept-Language': 'fr' } })
            .then(r => r.json())
            .then(results => {
                if (!results.length) {
                    suggestions.innerHTML = '<div style="padding:10px;color:#888;">Aucun résultat trouvé.</div>';
                    return;
                }
                suggestions.innerHTML = results.map(r => `
                    <div onclick="selectPlace(${r.lat}, ${r.lon}, '${r.display_name.replace(/'/g, "\\'")}')"
                         style="padding:9px 12px;cursor:pointer;border-bottom:1px solid #f0f0f0;line-height:1.4;"
                         onmouseover="this.style.background='#f5f7fa'" onmouseout="this.style.background='#fff'">
                        <i class="fas fa-map-marker-alt" style="color:#e77600;margin-right:6px;"></i>${r.display_name}
                    </div>
                `).join('');
            })
            .catch(() => {
                suggestions.innerHTML = '<div style="padding:10px;color:#c40000;">Erreur de connexion.</div>';
            });
    }

    function selectPlace(lat, lng, displayName) {
        const latF = parseFloat(lat);
        const lngF = parseFloat(lng);
        const newLatLng = new L.LatLng(latF, lngF);

        marker.setLatLng(newLatLng);
        map.setView(newLatLng, 16);

        document.getElementById('latitude').value = latF.toFixed(6);
        document.getElementById('longitude').value = lngF.toFixed(6);
        document.getElementById('google_maps_url').value = `https://www.google.com/maps?q=${latF.toFixed(6)},${lngF.toFixed(6)}`;
        document.getElementById('address_search').value = displayName;
        document.getElementById('search_suggestions').style.display = 'none';
    }

    // ─── Pays → Régions + indicatif téléphone ───
    const REGIONS_BY_COUNTRY = @json($countries->mapWithKeys(fn($c) => [$c->id => $c->regions->pluck('name')->values()]));
    const CURRENT_REGION = @json(old('region', $agence->region ?? ''));

    function paysData() {
        const sel = document.getElementById('pays');
        const opt = sel ? sel.options[sel.selectedIndex] : null;
        return {
            id: opt ? opt.getAttribute('data-id') : null,
            phone: opt ? (opt.getAttribute('data-phone') || '') : ''
        };
    }

    function populateRegions(selectedName) {
        const regionSel = document.getElementById('region');
        if (!regionSel) return;
        const { id } = paysData();
        const list = (id && REGIONS_BY_COUNTRY[id]) ? REGIONS_BY_COUNTRY[id] : [];
        regionSel.innerHTML = '<option value="">Sélectionner une région</option>';
        list.forEach(function (name) {
            const o = document.createElement('option');
            o.value = name; o.textContent = name;
            if (name === selectedName) o.selected = true;
            regionSel.appendChild(o);
        });
    }

    function rebuildTelephone() {
        const ind = (paysData().phone || '').trim();
        const num = (document.getElementById('telephone_number').value || '').trim();
        document.getElementById('telephone').value = num ? (ind + ' ' + num).trim() : '';
    }

    document.addEventListener('DOMContentLoaded', function() {
        setupAddressSearch();

        const paysSel = document.getElementById('pays');
        if (paysSel) {
            // Régions du pays courant
            populateRegions(CURRENT_REGION);

            // Indicatif + découpage du numéro existant
            const ind = (paysData().phone || '');
            document.getElementById('tel-indicatif').textContent = ind || '+---';
            const full = (document.getElementById('telephone').value || '').trim();
            if (full && ind && full.startsWith(ind)) {
                document.getElementById('telephone_number').value = full.substring(ind.length).trim();
            } else {
                document.getElementById('telephone_number').value = full;
            }
            rebuildTelephone();

            paysSel.addEventListener('change', function () {
                populateRegions('');
                document.getElementById('tel-indicatif').textContent = (paysData().phone || '+---');
                rebuildTelephone();
            });
            document.getElementById('telephone_number').addEventListener('input', rebuildTelephone);
        }
    });
</script>
</x-app-layout>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#ffffff">
        <title>Karnou Agence — Réseau de points relais & logistique</title>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            * { box-sizing: border-box; margin: 0; padding: 0; }
            html { scroll-behavior: smooth; }
            body {
                font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
                background: #ffffff; color: #12141a; overflow-x: hidden;
            }
            .wrap { max-width: 1260px; margin: 0 auto; padding: 0 2rem; }

            /* ——— HEADER (blanc, avec recherche centrale — style Kobo) ——— */
            .site-header { background: #fff; position: sticky; top: 0; width: 100%; z-index: 1000; border-bottom: 1px solid #ececf0; }
            .header-inner { display: flex; align-items: center; gap: 26px; padding: 13px 0; }
            .brand-logo { flex: none; display: flex; align-items: center; text-decoration: none; }
            .brand-logo img { height: 30px; width: auto; }
            .search { flex: 1; max-width: 540px; display: flex; align-items: center; background: #f2f4f7; border: 1px solid #e6e8ec; border-radius: 40px; padding: 4px 5px 4px 18px; }
            .search input { flex: 1; border: 0; background: transparent; outline: none; font-size: 0.92rem; padding: 9px 6px; color: #12141a; }
            .search input::placeholder { color: #9298a4; }
            .search button { border: 0; background: #FF6B00; color: #fff; border-radius: 40px; padding: 9px 20px; font-weight: 700; font-size: 0.85rem; cursor: pointer; display: flex; align-items: center; gap: 7px; transition: background .2s; }
            .search button:hover { background: #e66000; }
            .header-right { flex: none; display: flex; align-items: center; gap: 1.5rem; margin-left: auto; }
            .nav-link { color: #3d4351; text-decoration: none; font-size: 0.92rem; font-weight: 600; transition: color .2s; }
            .nav-link:hover { color: #FF6B00; }
            .btn-cta { background: #004aad; color: #fff !important; border-radius: 40px; font-weight: 700; padding: 11px 26px; font-size: 0.9rem; text-decoration: none; transition: all .2s; white-space: nowrap; }
            .btn-cta:hover { background: #003a8a; transform: translateY(-1px); }

            /* Boutons */
            .btn-primary { background: #FF6B00; color: #fff; font-weight: 800; font-size: 1rem; padding: 15px 34px; border-radius: 12px; text-decoration: none; transition: all .2s; display: inline-block; }
            .btn-primary:hover { background: #e66000; transform: translateY(-2px); box-shadow: 0 14px 30px rgba(255,107,0,.3); }
            .btn-ghost { color: #12141a; font-weight: 700; font-size: 1rem; padding: 14px 26px; border-radius: 12px; text-decoration: none; border: 1.5px solid #e0e3e8; transition: all .2s; display: inline-block; }
            .btn-ghost:hover { border-color: #004aad; color: #004aad; }

            /* ——— BANNIÈRE (grande carte claire arrondie — style Kobo) ——— */
            .hero { padding: 46px 0 72px; background: #fff; }
            .hero-banner {
                border-radius: 28px; background: linear-gradient(120deg, #e9f1fc 0%, #f4f8ff 55%, #fff5ec 100%);
                padding: clamp(40px, 5vw, 72px); display: grid; grid-template-columns: 1.05fr .95fr; gap: 52px;
                align-items: center; overflow: hidden; position: relative;
            }
            .hero-eyebrow { display: inline-flex; align-items: center; gap: 8px; background: #fff; color: #004aad; font-size: 0.72rem; font-weight: 800; padding: 7px 15px; border-radius: 40px; margin-bottom: 24px; letter-spacing: .5px; text-transform: uppercase; box-shadow: 0 2px 8px rgba(0,0,0,.05); }
            .hero-banner h1 { font-size: clamp(2.3rem, 4.6vw, 3.7rem); font-weight: 900; color: #12141a; line-height: 1.05; letter-spacing: -1.8px; margin-bottom: 20px; text-wrap: balance; }
            .hero-banner h1 .accent { color: #FF6B00; }
            .hero-banner .lead { font-size: 1.12rem; color: #4c5462; line-height: 1.65; margin-bottom: 34px; max-width: 500px; }
            .hero-actions { display: flex; gap: 14px; flex-wrap: wrap; align-items: center; }
            .hero-visual { position: relative; }
            .hero-visual .shot { border-radius: 20px; overflow: hidden; min-height: 420px; background: url('{{ asset('images/login-bg.jpg') }}') center/cover no-repeat; box-shadow: 0 30px 60px -28px rgba(0,49,122,.4); }

            /* Bande de valeurs */
            .trust { background: #fff; padding: 30px 0 6px; }
            .trust-inner { display: flex; flex-wrap: wrap; justify-content: center; gap: 14px 44px; }
            .trust-item { display: flex; align-items: center; gap: 10px; color: #4c5462; font-size: 0.92rem; font-weight: 600; }
            .trust-item svg { color: #FF6B00; flex: none; }

            /* Sections */
            .section { padding: 92px 0; }
            .section-head { text-align: center; max-width: 660px; margin: 0 auto 56px; }
            .section-label { font-size: 0.72rem; font-weight: 800; color: #FF6B00; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 14px; }
            .section-title { font-size: clamp(1.9rem, 3.6vw, 2.6rem); font-weight: 900; color: #12141a; letter-spacing: -1.3px; margin-bottom: 15px; text-wrap: balance; }
            .section-sub { color: #4c5462; font-size: 1.06rem; line-height: 1.6; }

            .cards { display: grid; grid-template-columns: repeat(3, 1fr); gap: 22px; }
            .card { background: #fff; border: 1px solid #ececf0; border-radius: 18px; padding: 32px 28px; transition: all .25s; }
            .card:hover { transform: translateY(-4px); box-shadow: 0 22px 46px -26px rgba(0,0,0,.2); border-color: #e0e3e8; }
            .card .ic { width: 50px; height: 50px; border-radius: 13px; background: rgba(255,107,0,.1); color: #FF6B00; display: flex; align-items: center; justify-content: center; margin-bottom: 20px; }
            .card h3 { font-size: 1.12rem; font-weight: 800; color: #12141a; margin-bottom: 9px; letter-spacing: -.3px; }
            .card p { font-size: 0.95rem; color: #4c5462; line-height: 1.6; }

            .steps { background: #f7f8fa; border-top: 1px solid #ececf0; border-bottom: 1px solid #ececf0; }
            .steps-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 40px; }
            .step .n { font-size: 2.5rem; font-weight: 900; color: #FF6B00; line-height: 1; margin-bottom: 12px; }
            .step h3 { font-size: 1.18rem; font-weight: 800; color: #12141a; margin-bottom: 9px; }
            .step p { font-size: 1rem; color: #4c5462; line-height: 1.6; }

            .cta { background: #004aad; color: #fff; text-align: center; padding: 80px 2rem; }
            .cta h2 { font-size: clamp(1.9rem, 4vw, 2.6rem); font-weight: 900; letter-spacing: -1px; margin-bottom: 14px; }
            .cta p { color: rgba(255,255,255,.9); max-width: 540px; margin: 0 auto 28px; font-size: 1.06rem; }

            /* Footer clair */
            .site-footer { background: #f7f8fa; color: #12141a; padding: 70px 0 36px; border-top: 1px solid #ececf0; }
            .footer-inner { display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 56px; }
            .footer-logo img { height: 40px; }
            .footer-desc { font-size: 0.95rem; color: #6b7280; line-height: 1.7; max-width: 340px; margin-top: 18px; }
            .footer-col h4 { font-size: 0.72rem; font-weight: 800; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 18px; color: #12141a; }
            .footer-col ul { list-style: none; }
            .footer-col ul li { margin-bottom: 12px; }
            .footer-col ul li a { color: #6b7280; text-decoration: none; font-size: 0.95rem; transition: color .2s; }
            .footer-col ul li a:hover { color: #FF6B00; }
            .footer-bottom { margin-top: 52px; padding-top: 26px; border-top: 1px solid #e6e8ec; text-align: center; font-size: 0.85rem; color: #9298a4; }

            @media (max-width: 900px) {
                .search { display: none; }
                .hero-banner { grid-template-columns: 1fr; gap: 40px; }
                .hero-visual { order: -1; }
                .cards, .steps-grid, .footer-inner { grid-template-columns: 1fr; gap: 26px; }
            }
            @media (max-width: 560px) {
                .header-right .nav-link { display: none; }
                .hero-visual .shot { min-height: 300px; }
            }
        </style>
    </head>
    <body>
        <!-- Header (blanc, recherche centrale — style Kobo) -->
        <header class="site-header">
            <div class="wrap header-inner">
                <a href="/" class="brand-logo">
                    <img src="{{ asset('images/logo.png') }}" alt="Karnou Agence">
                </a>

                <form class="search" action="{{ route('login') }}" method="get" role="search">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#9298a4" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" name="q" placeholder="Suivre un colis, un numéro de suivi…">
                    <button type="submit">Rechercher</button>
                </form>

                <div class="header-right">
                    <a href="#services" class="nav-link">Services</a>
                    <a href="#fonctionnement" class="nav-link">Fonctionnement</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn-cta">Mon tableau de bord</a>
                    @else
                        <a href="{{ route('login') }}" class="btn-cta">Se connecter</a>
                    @endauth
                </div>
            </div>
        </header>

        <!-- Bannière (grande carte claire — style Kobo) -->
        <section class="hero">
            <div class="wrap">
                <div class="hero-banner">
                    <div class="hero-text">
                        <span class="hero-eyebrow">Portail Agence &amp; Points Relais</span>
                        <h1>Gérez votre point relais, <span class="accent">sans effort</span>.</h1>
                        <p class="lead">
                            Réception, suivi et remise des colis, paiements sécurisés et statistiques —
                            toute la logistique du dernier kilomètre dans une seule plateforme.
                        </p>
                        <div class="hero-actions">
                            @auth
                                <a href="{{ route('dashboard') }}" class="btn-primary">Accéder à mon espace →</a>
                            @else
                                <a href="{{ route('login') }}" class="btn-primary">Se connecter</a>
                            @endauth
                            <a href="#services" class="btn-ghost">Découvrir les services</a>
                        </div>
                    </div>
                    <div class="hero-visual">
                        <div class="shot"></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Bande de valeurs -->
        <div class="trust">
            <div class="wrap trust-inner">
                <div class="trust-item"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Colis tracés par QR code</div>
                <div class="trust-item"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Paiements sécurisés (séquestre)</div>
                <div class="trust-item"><svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg> Pensé pour l'Afrique</div>
            </div>
        </div>

        <!-- Services -->
        <section class="section" id="services">
            <div class="wrap">
                <div class="section-head">
                    <p class="section-label">Ce que fait Karnou Agence</p>
                    <h2 class="section-title">Tout votre point relais, au même endroit</h2>
                    <p class="section-sub">De la réception du colis jusqu'à sa remise au client, avec le suivi et les paiements intégrés.</p>
                </div>
                <div class="cards">
                    <div class="card">
                        <div class="ic"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg></div>
                        <h3>Réception &amp; remise de colis</h3>
                        <p>Scannez les colis à l'arrivée et à la remise. Chaque étape est tracée par QR code et token sécurisé.</p>
                    </div>
                    <div class="card">
                        <div class="ic"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 3h15v13H1z"/><path d="M16 8h4l3 3v5h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg></div>
                        <h3>Suivi des livraisons</h3>
                        <p>Visualisez le cycle de vie de chaque commande : payé, prêt, en route, disponible au relais, livré.</p>
                    </div>
                    <div class="card">
                        <div class="ic"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg></div>
                        <h3>Paiements &amp; commissions</h3>
                        <p>Séquestre sécurisé des fonds et suivi des commissions, libérés à la validation de la livraison.</p>
                    </div>
                    <div class="card">
                        <div class="ic"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg></div>
                        <h3>Gestion des litiges</h3>
                        <p>Bloquez un paiement en cas de problème et traitez les litiges directement depuis votre espace.</p>
                    </div>
                    <div class="card">
                        <div class="ic"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg></div>
                        <h3>Statistiques &amp; journal</h3>
                        <p>Tableau de bord clair, journal des opérations et statistiques pour piloter votre activité.</p>
                    </div>
                    <div class="card">
                        <div class="ic"><svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg></div>
                        <h3>Multi-utilisateurs</h3>
                        <p>Gérez les membres de votre agence et leurs accès, chacun avec son rôle et ses permissions.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Fonctionnement -->
        <section class="section steps" id="fonctionnement">
            <div class="wrap">
                <div class="section-head">
                    <p class="section-label">Fonctionnement</p>
                    <h2 class="section-title">Trois étapes, aucun colis perdu</h2>
                </div>
                <div class="steps-grid">
                    <div class="step"><div class="n">01</div><h3>Le colis arrive</h3><p>À réception au point relais, scannez le colis : il est enregistré et le client est notifié.</p></div>
                    <div class="step"><div class="n">02</div><h3>Vous stockez &amp; suivez</h3><p>Le colis est en stock, prêt à être retiré. Son statut est visible en temps réel.</p></div>
                    <div class="step"><div class="n">03</div><h3>Remise sécurisée</h3><p>Le client se présente, vous scannez le QR code : la remise est validée et le paiement libéré.</p></div>
                </div>
            </div>
        </section>

        <!-- CTA -->
        <section class="cta" id="contact">
            <h2>Prêt à gérer votre point relais&nbsp;?</h2>
            <p>Connectez-vous à votre espace Karnou Agence pour piloter vos colis, vos livraisons et vos paiements.</p>
            @auth
                <a href="{{ route('dashboard') }}" class="btn-primary">Accéder à mon espace →</a>
            @else
                <a href="{{ route('login') }}" class="btn-primary">Se connecter</a>
            @endauth
        </section>

        <!-- Footer -->
        <footer class="site-footer">
            <div class="wrap">
                <div class="footer-inner">
                    <div>
                        <div class="footer-logo"><img src="{{ asset('images/logo.png') }}" alt="Karnou Agence"></div>
                        <p class="footer-desc">Le portail des points relais et agences du réseau Karnou. La logistique du dernier kilomètre, simplifiée.</p>
                    </div>
                    <div class="footer-col">
                        <h4>Plateforme</h4>
                        <ul>
                            <li><a href="#services">Services</a></li>
                            <li><a href="#fonctionnement">Fonctionnement</a></li>
                            <li><a href="{{ route('login') }}">Se connecter</a></li>
                        </ul>
                    </div>
                    <div class="footer-col">
                        <h4>Réseau Karnou</h4>
                        <ul>
                            <li><a href="#">Marketplace</a></li>
                            <li><a href="#">Logistique</a></li>
                            <li><a href="#contact">Contact</a></li>
                        </ul>
                    </div>
                </div>
                <div class="footer-bottom">© {{ date('Y') }} Karnou Agence. Tous droits réservés.</div>
            </div>
        </footer>
    </body>
</html>

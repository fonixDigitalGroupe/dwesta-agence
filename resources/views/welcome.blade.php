<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="theme-color" content="#FF6B00">
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
            .wrap { max-width: 1250px; margin: 0 auto; padding: 0 2rem; }

            /* ——— HEADER (épuré, blanc, façon Yango) ——— */
            .site-header {
                background: #fff; position: sticky; top: 0; width: 100%; z-index: 1000;
                border-bottom: 1px solid #eef0f3;
            }
            .header-inner { display: flex; align-items: center; justify-content: space-between; padding: 16px 0; }
            .brand-logo { display: flex; align-items: center; gap: 10px; text-decoration: none; }
            .brand-logo img { height: 40px; width: auto; }
            .header-nav { display: flex; align-items: center; gap: 2.2rem; }
            .nav-link { color: #3d4351; text-decoration: none; font-size: 0.92rem; font-weight: 600; transition: color .2s; }
            .nav-link:hover { color: #FF6B00; }
            .btn-cta {
                background: #FF6B00; color: #fff !important; border-radius: 10px; font-weight: 700;
                padding: 11px 26px; font-size: 0.9rem; text-decoration: none; transition: all .2s;
            }
            .btn-cta:hover { background: #e66000; transform: translateY(-1px); box-shadow: 0 10px 22px rgba(255,107,0,.28); }

            /* ——— HERO (2 colonnes texte / image, fond clair) ——— */
            .hero { padding: 70px 0 90px; background: #fff; }
            .hero-grid { display: grid; grid-template-columns: 1.05fr 0.95fr; gap: 64px; align-items: center; }
            .hero-eyebrow {
                display: inline-flex; align-items: center; gap: 8px; background: rgba(0,74,173,.08);
                color: #004aad; font-size: 0.72rem; font-weight: 800; padding: 7px 15px; border-radius: 40px;
                margin-bottom: 26px; letter-spacing: .6px; text-transform: uppercase;
            }
            .hero h1 {
                font-size: clamp(2.5rem, 5vw, 4rem); font-weight: 900; color: #12141a;
                line-height: 1.05; letter-spacing: -2px; margin-bottom: 22px; text-wrap: balance;
            }
            .hero h1 .accent { color: #FF6B00; }
            .hero .lead { font-size: 1.15rem; color: #545b68; line-height: 1.65; margin-bottom: 36px; max-width: 520px; }
            .hero-actions { display: flex; gap: 14px; flex-wrap: wrap; align-items: center; }
            .btn-primary {
                background: #FF6B00; color: #fff; font-weight: 800; font-size: 1rem;
                padding: 16px 36px; border-radius: 12px; text-decoration: none; transition: all .2s;
            }
            .btn-primary:hover { background: #e66000; transform: translateY(-2px); box-shadow: 0 14px 30px rgba(255,107,0,.32); }
            .btn-ghost {
                color: #12141a; font-weight: 700; font-size: 1rem; padding: 16px 28px; border-radius: 12px;
                text-decoration: none; border: 1.5px solid #e3e6eb; transition: all .2s;
            }
            .btn-ghost:hover { border-color: #004aad; color: #004aad; }

            .hero-visual { position: relative; }
            .hero-visual .shot {
                position: relative; z-index: 2; border-radius: 22px; overflow: hidden;
                min-height: 460px; background: url('{{ asset('images/login-bg.jpg') }}') center/cover no-repeat;
                box-shadow: 0 30px 60px -25px rgba(0,74,173,.45);
            }
            .hero-visual .blob {
                position: absolute; z-index: 1; width: 78%; height: 78%; right: -26px; bottom: -26px;
                background: #FF6B00; border-radius: 26px; opacity: .16;
            }
            .hero-visual .chip {
                position: absolute; z-index: 3; left: -22px; bottom: 34px; background: #fff;
                border-radius: 14px; padding: 14px 18px; box-shadow: 0 18px 40px rgba(0,0,0,.14);
                display: flex; align-items: center; gap: 12px;
            }
            .hero-visual .chip .dot { width: 38px; height: 38px; border-radius: 10px; background: rgba(0,74,173,.1); color: #004aad; display: flex; align-items: center; justify-content: center; }
            .hero-visual .chip b { font-size: 0.9rem; color: #12141a; }
            .hero-visual .chip span { display: block; font-size: 0.75rem; color: #8a90a0; font-weight: 600; }

            /* ——— BANDE PARTENAIRES / VALEURS ——— */
            .trust { background: #f7f8fa; border-top: 1px solid #eef0f3; border-bottom: 1px solid #eef0f3; padding: 26px 0; }
            .trust-inner { display: flex; flex-wrap: wrap; justify-content: center; gap: 14px 40px; }
            .trust-item { display: flex; align-items: center; gap: 10px; color: #545b68; font-size: 0.92rem; font-weight: 600; }
            .trust-item svg { color: #FF6B00; flex: none; }

            /* ——— SECTIONS ——— */
            .section { padding: 100px 0; }
            .section-head { text-align: center; max-width: 640px; margin: 0 auto 64px; }
            .section-label { font-size: 0.72rem; font-weight: 800; color: #FF6B00; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 14px; }
            .section-title { font-size: clamp(1.9rem, 3.6vw, 2.7rem); font-weight: 900; color: #12141a; letter-spacing: -1.4px; margin-bottom: 16px; text-wrap: balance; }
            .section-sub { color: #545b68; font-size: 1.08rem; line-height: 1.6; }

            /* Cartes avantages (claires, arrondies, façon Yango) */
            .cards { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
            .card {
                background: #fff; border: 1px solid #eef0f3; border-radius: 18px; padding: 34px 30px;
                transition: all .25s;
            }
            .card:hover { transform: translateY(-4px); box-shadow: 0 22px 46px -24px rgba(0,0,0,.22); border-color: #e3e6eb; }
            .card .ic { width: 52px; height: 52px; border-radius: 14px; background: rgba(255,107,0,.1); color: #FF6B00; display: flex; align-items: center; justify-content: center; margin-bottom: 22px; }
            .card h3 { font-size: 1.15rem; font-weight: 800; color: #12141a; margin-bottom: 10px; letter-spacing: -.4px; }
            .card p { font-size: 0.96rem; color: #545b68; line-height: 1.65; }

            /* Étapes */
            .steps { background: #f7f8fa; }
            .steps-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 40px; }
            .step .n { font-size: 2.6rem; font-weight: 900; color: #FF6B00; line-height: 1; margin-bottom: 12px; }
            .step h3 { font-size: 1.2rem; font-weight: 800; color: #12141a; margin-bottom: 10px; }
            .step p { font-size: 1rem; color: #545b68; line-height: 1.65; }

            /* CTA */
            .cta { background: #004aad; color: #fff; text-align: center; padding: 84px 2rem; }
            .cta h2 { font-size: clamp(1.9rem, 4vw, 2.7rem); font-weight: 900; letter-spacing: -1px; margin-bottom: 14px; }
            .cta p { color: rgba(255,255,255,.85); max-width: 540px; margin: 0 auto 30px; font-size: 1.08rem; }

            /* Footer */
            .site-footer { background: #0b1120; color: #fff; padding: 76px 0 38px; }
            .footer-inner { display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 60px; }
            .footer-logo img { height: 40px; }
            .footer-desc { font-size: 0.95rem; color: #9aa4b2; line-height: 1.7; max-width: 340px; margin-top: 18px; }
            .footer-col h4 { font-size: 0.72rem; font-weight: 800; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 20px; color: #fff; }
            .footer-col ul { list-style: none; }
            .footer-col ul li { margin-bottom: 12px; }
            .footer-col ul li a { color: #9aa4b2; text-decoration: none; font-size: 0.95rem; transition: color .2s; }
            .footer-col ul li a:hover { color: #FF6B00; }
            .footer-bottom { margin-top: 56px; padding-top: 28px; border-top: 1px solid rgba(255,255,255,.1); text-align: center; font-size: 0.85rem; color: #6b7280; }

            @media (max-width: 960px) {
                .hero-grid { grid-template-columns: 1fr; gap: 48px; }
                .hero-visual { order: -1; }
                .cards, .steps-grid, .footer-inner { grid-template-columns: 1fr; gap: 28px; }
            }
            @media (max-width: 640px) {
                .header-nav .nav-link { display: none; }
                .hero-visual .shot { min-height: 320px; }
            }
        </style>
    </head>
    <body>
        <!-- Header -->
        <header class="site-header">
            <div class="wrap header-inner">
                <a href="/" class="brand-logo">
                    <img src="{{ asset('images/logo.png') }}" alt="Karnou Agence">
                </a>
                <nav class="header-nav">
                    <a href="#services" class="nav-link">Services</a>
                    <a href="#fonctionnement" class="nav-link">Fonctionnement</a>
                    <a href="#contact" class="nav-link">Contact</a>
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn-cta">Mon tableau de bord</a>
                    @else
                        <a href="{{ route('login') }}" class="btn-cta">Se connecter</a>
                    @endauth
                </nav>
            </div>
        </header>

        <!-- Bannière (hero 2 colonnes) -->
        <section class="hero">
            <div class="wrap hero-grid">
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
                    <div class="blob"></div>
                    <div class="shot"></div>
                    <div class="chip">
                        <span class="dot">
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                        </span>
                        <div><b>Suivi en temps réel</b><span>De la réception à la remise</span></div>
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

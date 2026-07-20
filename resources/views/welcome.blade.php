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
                background-color: #ffffff; color: #1a1a1a; overflow-x: hidden;
            }

            /* ——— TOP BANNER ——— */
            .top-banner {
                background-color: #FF6B00; min-height: 38px; width: 100%;
                display: flex; align-items: center; justify-content: center; padding: 6px 1rem;
                position: relative; z-index: 1001;
            }
            .top-banner p { color: #fff; font-size: 0.72rem; font-weight: 700; letter-spacing: 0.5px; text-transform: uppercase; text-align: center; }

            /* ——— HEADER ——— */
            .site-header {
                background-color: #ffffff; border-top: 3px solid #FF6B00;
                position: sticky; top: 0; width: 100%; z-index: 1000;
                box-shadow: 0 1px 0 rgba(0,0,0,0.04), 0 6px 24px rgba(0,0,0,0.05);
            }
            .header-inner { max-width: 1300px; margin: 0 auto; padding: 14px 2rem; display: flex; align-items: center; justify-content: space-between; }
            .brand-logo { display: flex; align-items: center; gap: 10px; text-decoration: none; }
            .brand-logo img { height: 40px; width: auto; }
            .brand-logo .txt { font-weight: 900; font-size: 1.2rem; color: #1a1a1a; letter-spacing: -0.5px; }
            .brand-logo .txt span { color: #FF6B00; }
            .header-nav { display: flex; align-items: center; gap: 2rem; }
            .nav-link { color: #475569; text-decoration: none; font-size: 0.9rem; font-weight: 600; transition: color 0.3s; }
            .nav-link:hover { color: #FF6B00; }
            .btn-cta {
                background: #FF6B00; color: #fff !important; border-radius: 8px; font-weight: 700;
                padding: 10px 24px; font-size: 0.875rem; text-decoration: none; transition: all 0.3s;
            }
            .btn-cta:hover { background: #e66000; transform: translateY(-1px); box-shadow: 0 8px 20px rgba(255,107,0,0.25); }

            /* ——— HERO BANNER (avec image) ——— */
            .hero-banner {
                position: relative; min-height: 88vh; display: flex; align-items: center;
                padding: 90px 2rem 110px; overflow: hidden;
            }
            .hero-banner .bg {
                position: absolute; inset: 0;
                background: url('{{ asset('images/login-bg.jpg') }}') center/cover no-repeat;
                transform: scale(1.05);
            }
            .hero-banner .ov {
                position: absolute; inset: 0;
                background: linear-gradient(105deg, rgba(0,33,86,0.95) 0%, rgba(0,74,173,0.86) 45%, rgba(0,74,173,0.55) 100%);
            }
            .hero-content { position: relative; z-index: 2; max-width: 720px; margin: 0 auto 0 8%; }
            .hero-eyebrow {
                display: inline-flex; align-items: center; gap: 8px; background: rgba(255,107,0,0.9);
                color: #fff; font-size: 0.7rem; font-weight: 800; padding: 7px 16px; border-radius: 4px;
                margin-bottom: 28px; letter-spacing: 1px; text-transform: uppercase;
            }
            .hero-content h1 {
                font-size: clamp(2.6rem, 6vw, 4.6rem); font-weight: 900; color: #fff;
                line-height: 1.02; margin-bottom: 24px; letter-spacing: -2px; text-wrap: balance;
            }
            .hero-content h1 .accent { color: #FF6B00; }
            .hero-content p { font-size: 1.15rem; color: rgba(255,255,255,0.88); max-width: 560px; margin-bottom: 40px; line-height: 1.6; font-weight: 500; }
            .hero-actions { display: flex; gap: 16px; flex-wrap: wrap; }
            .btn-hero-primary {
                background: #FF6B00; color: #fff; font-weight: 800; font-size: 0.98rem;
                padding: 16px 38px; border-radius: 8px; text-decoration: none; transition: all 0.2s;
            }
            .btn-hero-primary:hover { background: #e66000; transform: translateY(-2px); box-shadow: 0 12px 28px rgba(255,107,0,0.35); }
            .btn-hero-ghost {
                background: rgba(255,255,255,0.08); color: #fff; font-weight: 700; font-size: 0.98rem;
                padding: 16px 34px; border-radius: 8px; text-decoration: none; border: 1px solid rgba(255,255,255,0.35);
                transition: all 0.2s; backdrop-filter: blur(4px);
            }
            .btn-hero-ghost:hover { background: rgba(255,255,255,0.18); }

            /* ——— PRÉSENTATION / SERVICES ——— */
            .features { padding: 110px 2rem; background: #111827; color: #fff; }
            .section-label { font-size: 0.72rem; font-weight: 800; color: #FF6B00; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 14px; text-align: center; }
            .section-title { font-size: clamp(2rem, 4vw, 2.8rem); font-weight: 900; color: #fff; letter-spacing: -1.5px; margin-bottom: 18px; text-align: center; }
            .section-sub { text-align: center; color: rgba(255,255,255,0.6); max-width: 620px; margin: 0 auto 70px; font-size: 1.05rem; line-height: 1.6; }
            .features-grid { max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; }
            .feature-card { background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1); border-radius: 10px; padding: 40px 34px; transition: all 0.3s; }
            .feature-card:hover { background: rgba(255,255,255,0.08); transform: translateY(-4px); border-color: rgba(255,107,0,0.4); }
            .feature-icon { width: 52px; height: 52px; background: rgba(255,107,0,0.15); color: #FF6B00; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 26px; }
            .feature-card h3 { font-size: 1.2rem; font-weight: 800; color: #fff; margin-bottom: 12px; letter-spacing: -0.5px; }
            .feature-card p { font-size: 0.95rem; color: rgba(255,255,255,0.62); line-height: 1.7; }

            /* ——— FONCTIONNEMENT ——— */
            .process { padding: 110px 2rem; background: #ffffff; }
            .process-grid { max-width: 1050px; margin: 60px auto 0; display: grid; grid-template-columns: repeat(3, 1fr); gap: 50px; }
            .step .step-number { font-size: 3.4rem; font-weight: 900; color: #FF6B00; line-height: 1; margin-bottom: 14px; opacity: 0.9; }
            .step h3 { font-size: 1.2rem; font-weight: 800; color: #1a1a1a; margin-bottom: 10px; letter-spacing: -0.5px; }
            .step p { font-size: 0.98rem; color: #4b5563; line-height: 1.7; }
            .process .section-title, .process .section-label { color: inherit; }
            .process .section-title { color: #1a1a1a; }

            /* ——— CTA BAND ——— */
            .cta-band { background: #004aad; color: #fff; padding: 80px 2rem; text-align: center; }
            .cta-band h2 { font-size: clamp(1.8rem, 4vw, 2.6rem); font-weight: 900; letter-spacing: -1px; margin-bottom: 16px; }
            .cta-band p { color: rgba(255,255,255,0.85); max-width: 540px; margin: 0 auto 32px; font-size: 1.05rem; }

            /* ——— FOOTER ——— */
            .site-footer { background: #0b1120; color: #fff; padding: 80px 2rem 40px; }
            .footer-inner { max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: 2fr 1fr 1fr; gap: 60px; }
            .footer-logo { font-size: 1.5rem; font-weight: 900; letter-spacing: -1px; margin-bottom: 18px; }
            .footer-logo span { color: #FF6B00; }
            .footer-desc { font-size: 0.95rem; color: #9aa4b2; line-height: 1.7; max-width: 340px; }
            .footer-col h4 { font-size: 0.72rem; font-weight: 800; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 20px; color: #fff; }
            .footer-col ul { list-style: none; }
            .footer-col ul li { margin-bottom: 12px; }
            .footer-col ul li a { color: #9aa4b2; text-decoration: none; font-size: 0.95rem; transition: color 0.2s; }
            .footer-col ul li a:hover { color: #FF6B00; }
            .footer-bottom { max-width: 1200px; margin: 60px auto 0; padding-top: 30px; border-top: 1px solid rgba(255,255,255,0.1); text-align: center; font-size: 0.85rem; color: #6b7280; }

            @media (max-width: 1024px) {
                .features-grid, .process-grid, .footer-inner { grid-template-columns: 1fr; gap: 36px; }
                .hero-content { margin: 0 auto; text-align: center; }
                .hero-actions { justify-content: center; }
            }
            @media (max-width: 640px) {
                .header-nav .nav-link { display: none; }
                .hero-banner .ov { background: linear-gradient(160deg, rgba(0,33,86,0.95), rgba(0,74,173,0.85)); }
            }
        </style>
    </head>
    <body>
        <!-- Bandeau haut -->
        <div class="top-banner"><p>Réseau de points relais Karnou · Livraison du dernier kilomètre en Afrique</p></div>

        <!-- Header -->
        <header class="site-header" id="header">
            <div class="header-inner">
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

        <!-- Bannière (hero) -->
        <section class="hero-banner">
            <div class="bg"></div>
            <div class="ov"></div>
            <div class="hero-content">
                <span class="hero-eyebrow">Portail Agence &amp; Points Relais</span>
                <h1>La logistique du <span class="accent">dernier kilomètre</span>, simplifiée.</h1>
                <p>
                    Karnou Agence connecte vos points relais, vos livreurs et vos clients.
                    Réceptionnez, suivez et remettez les colis en toute sécurité, depuis une seule plateforme.
                </p>
                <div class="hero-actions">
                    @auth
                        <a href="{{ route('dashboard') }}" class="btn-hero-primary">Accéder à mon espace →</a>
                    @else
                        <a href="{{ route('login') }}" class="btn-hero-primary">Se connecter</a>
                    @endauth
                    <a href="#services" class="btn-hero-ghost">Découvrir les services</a>
                </div>
            </div>
        </section>

        <!-- Présentation / Services -->
        <section class="features" id="services">
            <p class="section-label">Ce que fait Karnou Agence</p>
            <h2 class="section-title">Tout votre point relais, au même endroit</h2>
            <p class="section-sub">
                Une plateforme pensée pour les agences et points relais africains : de la réception du colis
                jusqu'à sa remise au client, avec le suivi et les paiements intégrés.
            </p>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/><polyline points="3.27 6.96 12 12.01 20.73 6.96"/><line x1="12" y1="22.08" x2="12" y2="12"/></svg>
                    </div>
                    <h3>Réception & remise de colis</h3>
                    <p>Scannez les colis à l'arrivée et à la remise. Chaque étape est tracée par QR code et token de suivi sécurisé.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 3h15v13H1z"/><path d="M16 8h4l3 3v5h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
                    </div>
                    <h3>Suivi des livraisons</h3>
                    <p>Visualisez le cycle de vie de chaque commande : payé, prêt, en route, disponible au relais, livré.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                    </div>
                    <h3>Paiements & commissions</h3>
                    <p>Séquestre sécurisé des fonds, suivi des commissions et des paiements — libérés à la validation de la livraison.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    </div>
                    <h3>Gestion des litiges</h3>
                    <p>Bloquez un paiement en cas de problème et traitez les litiges directement depuis votre espace.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                    </div>
                    <h3>Statistiques & journal</h3>
                    <p>Tableau de bord clair, journal des opérations et statistiques pour piloter l'activité de votre agence.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    </div>
                    <h3>Multi-utilisateurs</h3>
                    <p>Gérez les membres de votre agence et leurs accès, chacun avec son rôle et ses permissions.</p>
                </div>
            </div>
        </section>

        <!-- Fonctionnement -->
        <section class="process" id="fonctionnement">
            <p class="section-label">Fonctionnement</p>
            <h2 class="section-title">Trois étapes, aucun colis perdu</h2>
            <div class="process-grid">
                <div class="step">
                    <div class="step-number">01</div>
                    <h3>Le colis arrive</h3>
                    <p>À réception au point relais, scannez le colis : il est enregistré et le client est notifié.</p>
                </div>
                <div class="step">
                    <div class="step-number">02</div>
                    <h3>Vous stockez & suivez</h3>
                    <p>Le colis est en stock, prêt à être retiré. Son statut est visible en temps réel dans votre espace.</p>
                </div>
                <div class="step">
                    <div class="step-number">03</div>
                    <h3>Remise sécurisée</h3>
                    <p>Le client se présente, vous scannez le QR code : la remise est validée et le paiement libéré.</p>
                </div>
            </div>
        </section>

        <!-- Appel à l'action -->
        <section class="cta-band" id="contact">
            <h2>Prêt à gérer votre point relais&nbsp;?</h2>
            <p>Connectez-vous à votre espace Karnou Agence pour piloter vos colis, vos livraisons et vos paiements.</p>
            @auth
                <a href="{{ route('dashboard') }}" class="btn-hero-primary">Accéder à mon espace →</a>
            @else
                <a href="{{ route('login') }}" class="btn-hero-primary">Se connecter</a>
            @endauth
        </section>

        <!-- Footer -->
        <footer class="site-footer">
            <div class="footer-inner">
                <div>
                    <div class="footer-logo">Karnou <span>Agence</span></div>
                    <p class="footer-desc">
                        Le portail des points relais et agences du réseau Karnou. Réception, suivi et
                        remise des colis, paiements sécurisés — la logistique du dernier kilomètre, simplifiée.
                    </p>
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
        </footer>
    </body>
</html>

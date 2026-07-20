# Déploiement — Portail Agence (Laravel + cPanel FTP)

Déploiement automatique via **GitHub Actions** vers un hébergement mutualisé **cPanel**.
À chaque `git push` sur `master`, le code est compilé (Composer + Vite) puis envoyé par FTP.

---

## 1. Structure des dossiers sur le serveur (configuration retenue)

Cible : **domaine.com/agence** — Terminal cPanel disponible.

⚠️ **Ne jamais mettre l'application Laravel entière dans `public_html`** (le `.env`, la base,
le code seraient exposés publiquement). Le code reste hors de `public_html`, et
`public_html/agence` est un **lien symbolique** vers le dossier `public/` de Laravel :

```
/home/<compte>/
├── agence_app/           ← code Laravel (déployé par FTP, NON public)
│   ├── app/  bootstrap/  config/  routes/  vendor/  ...
│   └── public/           ← contient index.php + build des assets
└── public_html/
    └── agence  ──►  lien symbolique vers ~/agence_app/public
```

Dans le **Terminal cPanel**, créez le lien symbolique (le dossier `public_html/agence`
que vous aviez créé est remplacé par le lien) :

```bash
rm -rf ~/public_html/agence          # supprime le dossier vide créé manuellement
ln -s ~/agence_app/public ~/public_html/agence
ls -l ~/public_html/agence           # doit afficher: agence -> /home/<compte>/agence_app/public
```

> Le répertoire cible du déploiement FTP est `/agence_app/`
> (déjà défini dans la variable GitHub `FTP_SERVER_DIR`, voir §3).

---

## 2. Créer le `.env` de production (une seule fois)

Le fichier `.env` **n'est jamais** envoyé par Git/FTP (il contient des secrets).
Créez-le manuellement via **cPanel → Gestionnaire de fichiers** dans `~/agence_app/.env` :

```env
APP_NAME="Dwesta Agence"
APP_ENV=production
APP_KEY=                      # généré à l'étape 4
APP_DEBUG=false
APP_URL=https://votre-domaine.com/agence
# IMPORTANT (site servi dans un sous-dossier /agence) : sans ceci, les assets
# Vite (CSS/JS) seraient cherchés à la racine du domaine et renverraient 404.
ASSET_URL=https://votre-domaine.com/agence

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=<base_cpanel>
DB_USERNAME=<user_cpanel>
DB_PASSWORD=<mot_de_passe>

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

MAIL_MAILER=smtp
# ... configurez SMTP, Socialite (Google/Facebook), etc.
```

Créez la base MySQL et l'utilisateur dans **cPanel → Bases de données MySQL**.

---

## 3. Secrets & variables GitHub

Dépôt → **Settings → Secrets and variables → Actions**.

**Secrets** (onglet *Secrets*) :
| Nom | Valeur |
|-----|--------|
| `FTP_SERVER` | hôte FTP (ex: `ftp.votre-domaine.com`) |
| `FTP_USERNAME` | identifiant FTP cPanel |
| `FTP_PASSWORD` | mot de passe FTP |

**Variables** (onglet *Variables*) — ✅ **déjà configurées** :
| Nom | Valeur |
|-----|--------|
| `FTP_SERVER_DIR` | `/agence_app/` |
| `FTP_PROTOCOL` | `ftps` |
| `FTP_PORT` | `21` |

> Si vous créez un **compte FTP dédié** dans cPanel pointant directement sur `~/agence_app`,
> alors les chemins FTP deviennent relatifs à ce dossier : mettez `FTP_SERVER_DIR` à `/`.
> Avec le compte FTP principal (home = `/home/<compte>`), gardez `/agence_app/`.

---

## 4. Commandes à lancer après le PREMIER déploiement

Via **cPanel → Terminal** (ou SSH si disponible), dans `~/agence_app` :

```bash
php artisan key:generate --force      # génère APP_KEY dans .env
php artisan migrate --force           # crée les tables
php artisan storage:link              # lien symbolique storage → public
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Puis assurez-vous des permissions :
```bash
chmod -R 775 storage bootstrap/cache
```

---

## 5. À chaque déploiement suivant

Le push déclenche GitHub Actions automatiquement. **Après** l'upload FTP,
si vous avez de nouvelles migrations, relancez dans le Terminal cPanel :

```bash
cd ~/agence_app
php artisan migrate --force
php artisan config:cache && php artisan route:cache && php artisan view:cache
```

> 💡 Si aucun terminal cPanel n'est disponible, créez une **tâche Cron** cPanel qui exécute
> ces commandes, ou envisagez une plateforme managée (Laravel Forge/Ploi) pour un déploiement
> 100 % automatisé sans intervention manuelle.

---

## 6. Déclencher un déploiement manuel

Dépôt GitHub → onglet **Actions** → *Deploy (cPanel FTP)* → **Run workflow**.

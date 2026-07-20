# Déploiement — Portail Agence (Laravel + cPanel FTP)

Déploiement automatique via **GitHub Actions** vers un hébergement mutualisé **cPanel**.
À chaque `git push` sur `master`, le code est compilé (Composer + Vite) puis envoyé par FTP.

---

## 1. Structure des dossiers sur le serveur

⚠️ **Ne jamais mettre l'application Laravel entière dans `public_html`** (le `.env`, la base,
le code seraient exposés publiquement).

Structure recommandée :

```
/home/<compte>/
├── dwesta-agence/        ← l'application Laravel (déployée par GitHub Actions)
│   ├── app/  bootstrap/  config/  routes/  vendor/  ...
│   └── public/           ← contient index.php + build des assets
└── public_html/          ← racine web du domaine
```

Deux options pour que le domaine serve le dossier `public/` :

**Option A — Symlink (préférée, si le terminal cPanel est disponible)**
```bash
rm -rf ~/public_html
ln -s ~/dwesta-agence/public ~/public_html
```

**Option B — Sous-domaine / docroot personnalisé**
Dans cPanel → *Domaines*, faites pointer la racine du domaine (ou sous-domaine)
vers `/home/<compte>/dwesta-agence/public`.

> Le répertoire cible du déploiement FTP est donc `/dwesta-agence` (voir §3, variable `FTP_SERVER_DIR`).

---

## 2. Créer le `.env` de production (une seule fois)

Le fichier `.env` **n'est jamais** envoyé par Git/FTP (il contient des secrets).
Créez-le manuellement via **cPanel → Gestionnaire de fichiers** dans `~/dwesta-agence/.env` :

```env
APP_NAME="Dwesta Agence"
APP_ENV=production
APP_KEY=                      # généré à l'étape 4
APP_DEBUG=false
APP_URL=https://votre-domaine.com

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

**Variables** (onglet *Variables*) :
| Nom | Valeur | Défaut |
|-----|--------|--------|
| `FTP_SERVER_DIR` | `/dwesta-agence/` (dossier de l'app) | — (requis) |
| `FTP_PROTOCOL` | `ftps` (recommandé) ou `ftp` | `ftps` |
| `FTP_PORT` | port FTP | `21` |

> Créez un **compte FTP dédié** dans cPanel pointant sur `~/dwesta-agence` plutôt que
> d'utiliser le compte FTP principal, c'est plus sûr.

---

## 4. Commandes à lancer après le PREMIER déploiement

Via **cPanel → Terminal** (ou SSH si disponible), dans `~/dwesta-agence` :

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
cd ~/dwesta-agence
php artisan migrate --force
php artisan config:cache && php artisan route:cache && php artisan view:cache
```

> 💡 Si aucun terminal cPanel n'est disponible, créez une **tâche Cron** cPanel qui exécute
> ces commandes, ou envisagez une plateforme managée (Laravel Forge/Ploi) pour un déploiement
> 100 % automatisé sans intervention manuelle.

---

## 6. Déclencher un déploiement manuel

Dépôt GitHub → onglet **Actions** → *Deploy (cPanel FTP)* → **Run workflow**.

# Déploiement — Portail Agence (Laravel sur LWS mutualisé)

## Principe

Le serveur mutualisé LWS a `git`, `composer` et `php 8.3`, **mais pas Node/npm**.
Il ne peut donc pas compiler les assets (CSS/JS). On répartit le travail :

```
git push (master)
      │
      ▼
GitHub Actions ──► compile les assets (Vite) ──► publie la branche "deploy"
                                                   (code + public/build prêts)
      │
      ▼
Serveur LWS  ──► git pull de "deploy" + composer install + php artisan migrate
                 (via le script deploy.sh, lancé à la main ou par Cron)
```

- **Branche `master`** : le code source (vous y poussez normalement).
- **Branche `deploy`** : générée automatiquement par GitHub, contient le code + les assets compilés. C'est **elle** que le serveur récupère.

---

## Structure sur le serveur

Cible : **domaine.com/agence** — le code Laravel reste hors de `public_html`
(sécurité), seul `public/` est exposé via un lien symbolique.

```
/home/cp1974091p02/
├── agence_app/           ← dépôt cloné (branche deploy), NON public
│   └── public/           ← seul dossier servi
└── public_html/
    └── agence  ──►  lien symbolique vers ~/agence_app/public
```

---

## Installation initiale (une seule fois, dans le Terminal cPanel)

### 1. Créer la base de données
Dans **cPanel → Bases de données MySQL** : créez une base, un utilisateur,
et associez l'utilisateur à la base (tous privilèges). Notez les 3 valeurs
(base / utilisateur / mot de passe).

### 2. Cloner le projet (branche `deploy`)
```bash
cd ~
git clone -b deploy https://github.com/fonixDigitalGroupe/dwesta-agence.git agence_app
cd agence_app
```

### 3. Créer le fichier `.env`
```bash
cp .env.example .env
nano .env      # (ou éditez via le Gestionnaire de fichiers cPanel)
```
Renseignez au minimum :
```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://votre-domaine.com/agence
ASSET_URL=https://votre-domaine.com/agence     # ⚠️ indispensable en sous-dossier

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=<base>
DB_USERNAME=<utilisateur>
DB_PASSWORD=<mot_de_passe>
```

### 4. Première installation
```bash
composer install --no-dev --optimize-autoloader --no-interaction
php artisan key:generate --force
php artisan migrate --force
php artisan storage:link
php artisan config:cache && php artisan route:cache && php artisan view:cache
chmod -R 775 storage bootstrap/cache
```

### 5. Lien symbolique du dossier public
```bash
rm -rf ~/public_html/agence
ln -s ~/agence_app/public ~/public_html/agence
ls -l ~/public_html/agence      # doit afficher : agence -> /home/cp1974091p02/agence_app/public
```

Le site est en ligne : **https://votre-domaine.com/agence** 🎉

---

## Déploiements suivants

À chaque `git push` sur `master`, GitHub recompile les assets et met à jour la
branche `deploy` automatiquement. Il reste à ce que le serveur récupère cette version.

**Option A — à la main** (simple) : dans le Terminal cPanel
```bash
bash ~/agence_app/deploy.sh
```

**Option B — automatique via Cron** (cPanel → *Tâches Cron*) :
ajoutez une tâche qui vérifie les mises à jour toutes les 5 minutes :
```
*/5 * * * * /bin/bash $HOME/agence_app/deploy.sh >> $HOME/agence_app/storage/logs/deploy.log 2>&1
```
Le script ne fait rien s'il n'y a pas de nouvelle version ; il déploie uniquement
quand la branche `deploy` a changé. Le journal est dans `storage/logs/deploy.log`.

---

## Résumé qui fait quoi

| Étape | Où | Qui |
|-------|-----|-----|
| Écrire le code | local | vous |
| `git push master` | local | vous |
| Compiler les assets + publier `deploy` | GitHub Actions | automatique |
| `git pull` + composer + migrate | serveur LWS | `deploy.sh` (manuel ou Cron) |

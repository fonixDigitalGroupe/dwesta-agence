#!/usr/bin/env bash
#
# Script de déploiement — à exécuter SUR LE SERVEUR LWS (dans ~/agence_app).
# Récupère la dernière version compilée (branche "deploy"), installe les
# dépendances PHP et applique les migrations. Peut être lancé à la main
# ou par une tâche Cron.
#
# Usage : bash ~/agence_app/deploy.sh
#
set -euo pipefail

# Binaires (le Cron cPanel a un PATH minimal : on le complète)
export PATH="/usr/local/bin:/usr/local/cpanel/3rdparty/lib/path-bin:$PATH"

APP_DIR="$HOME/agence_app"
BRANCH="deploy"

cd "$APP_DIR"

echo "==> Vérification des mises à jour…"
git fetch --quiet origin "$BRANCH"

LOCAL="$(git rev-parse HEAD)"
REMOTE="$(git rev-parse "origin/$BRANCH")"

if [ "$LOCAL" = "$REMOTE" ]; then
  echo "==> Déjà à jour ($LOCAL). Rien à faire."
  exit 0
fi

echo "==> Nouvelle version détectée : $REMOTE"
git reset --hard "origin/$BRANCH"

echo "==> Installation des dépendances PHP (prod)…"
composer install --no-dev --optimize-autoloader --no-interaction --no-progress

echo "==> Migrations de la base…"
php artisan migrate --force

echo "==> Lien symbolique du storage…"
php artisan storage:link || true

echo "==> Mise en cache (config / routes / vues)…"
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "==> Déploiement terminé avec succès : $REMOTE"

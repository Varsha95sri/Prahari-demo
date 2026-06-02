#!/bin/bash
set -e

echo "🚀 Starting Prahari..."

cd /var/www/html

cat > .env <<EOF
APP_NAME="${APP_NAME:-Prahari}"
APP_ENV=${APP_ENV:-production}
APP_KEY=${APP_KEY}
APP_DEBUG=${APP_DEBUG:-false}
APP_URL=${APP_URL:-${RENDER_EXTERNAL_URL:-http://localhost}}

LOG_CHANNEL=stack
LOG_LEVEL=error

DB_CONNECTION=${DB_CONNECTION:-pgsql}
DB_HOST=${DB_HOST}
DB_PORT=${DB_PORT:-5432}
DB_DATABASE=${DB_DATABASE}
DB_USERNAME=${DB_USERNAME}
DB_PASSWORD=${DB_PASSWORD}

CACHE_STORE=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
EOF

if [ -z "$APP_KEY" ]; then
    echo "⚙️ Generating APP_KEY..."
    php artisan key:generate --force
fi

echo "⚡ Clearing cache..."
php artisan config:clear || true
php artisan cache:clear || true

echo "🔄 Running migrations..."
php artisan migrate --force || true

echo "⚡ Optimizing Laravel..."
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

echo "✅ Prahari is ready."

exec "$@"
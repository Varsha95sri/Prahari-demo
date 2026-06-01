#!/bin/bash
set -e

echo "🚀 Starting Prahari-demo deployment..."

cd /var/www/html

# Copy .env if not present
if [ ! -f .env ]; then
    cp .env.example .env
fi

# Inject environment variables from Render into .env
cat > .env <<EOF
APP_NAME="${APP_NAME:-Prahari}"
APP_ENV=production
APP_KEY=${APP_KEY}
APP_DEBUG=false
APP_URL=${APP_URL:-http://localhost}

LOG_CHANNEL=stack
LOG_LEVEL=error

DB_CONNECTION=mysql
DB_HOST=${DB_HOST}
DB_PORT=${DB_PORT:-3306}
DB_DATABASE=${DB_DATABASE}
DB_USERNAME=${DB_USERNAME}
DB_PASSWORD=${DB_PASSWORD}

CACHE_DRIVER=file
SESSION_DRIVER=file
QUEUE_CONNECTION=sync

BROADCAST_DRIVER=log
FILESYSTEM_DISK=local
EOF

# Generate app key if not set
if [ -z "$APP_KEY" ]; then
    echo "⚙️  Generating APP_KEY..."
    php artisan key:generate --force
fi

echo "⏳ Waiting for MySQL to be ready..."
until php artisan db:show --json > /dev/null 2>&1; do
    echo "   MySQL not ready yet, retrying in 3s..."
    sleep 3
done

echo "✅ MySQL connected!"

# Run migrations
echo "🗄️  Running migrations..."
php artisan migrate --force

# Clear & cache config for production
echo "🔧 Optimising Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ All done! Starting Apache..."
exec "$@"

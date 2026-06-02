#!/bin/bash
set -e

echo "🚀 Starting Prahari-demo deployment..."

cd /var/www/html

# Write .env from environment variables
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

# Wait for PostgreSQL to be ready (with timeout)
echo "⏳ Waiting for PostgreSQL to be ready..."
MAX_RETRIES=30
RETRY_COUNT=0
until php -r "
    try {
        \$dsn = 'pgsql:host=' . getenv('DB_HOST') . ';port=' . (getenv('DB_PORT') ?: '5432') . ';dbname=' . getenv('DB_DATABASE');
        new PDO(\$dsn, getenv('DB_USERNAME'), getenv('DB_PASSWORD'));
        echo 'OK';
        exit(0);
    } catch (Exception \$e) {
        exit(1);
    }
" 2>/dev/null; do
    RETRY_COUNT=$((RETRY_COUNT + 1))
    if [ $RETRY_COUNT -ge $MAX_RETRIES ]; then
        echo "⚠️  PostgreSQL not available after ${MAX_RETRIES} attempts, proceeding anyway..."
        break
    fi
    echo "   PostgreSQL not ready yet, retrying in 2s... ($RETRY_COUNT/$MAX_RETRIES)"
    sleep 2
done

if [ $RETRY_COUNT -lt $MAX_RETRIES ]; then
    echo "✅ PostgreSQL is ready!"
fi

# Generate APP_KEY if not set
if [ -z "$APP_KEY" ]; then
    echo "⚙️ Generating APP_KEY..."
    php artisan key:generate --force
fi

echo "⚡ Clearing cache..."
php artisan config:clear || true
php artisan cache:clear || true

echo "🔄 Running migrations..."
php artisan migrate --force || true

echo "🌱 Seeding database..."
php artisan db:seed --force || true

echo "⚡ Optimizing Laravel..."
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

echo "✅ Prahari is ready. Starting Apache on port 80..."

# Start Apache in foreground (this binds to port 80)
exec apache2-foreground

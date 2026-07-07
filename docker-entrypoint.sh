#!/bin/bash
set -e

cd /var/www/html

echo "=== Docker Entrypoint Started ==="

if [ ! -f /var/www/html/vendor/autoload.php ]; then
    echo "Installing Composer dependencies..."
    composer install --no-interaction --optimize-autoloader 
fi

if [ ! -f .env ] && [ -f .env.docker ]; then
    echo "Copying .env.docker to .env..."
    cp .env.docker .env
fi

echo "Generating application key..."
if ! grep -q "^APP_KEY=base64:" .env; then
    php artisan key:generate --force
else
    echo "Application key already exists."
fi

echo "CLearing All Chaches..."
rm -rf /var/www/html/bootstrap/cache/*.php || true
rm -rf /var/www/html/storage/framework/cache/data/* 2>/dev/null || true
rm -rf /var/www/html/storage/framework/views/* 2>/dev/null || true
php artisan config:clear 2>/dev/null || true

echo "running migrations..."
php artisan migrate --force 

echo "Checking storage symlink..."

if [ ! -e public/storage ]; then
    php artisan storage:link

    if [ $? -eq 0 ]; then
        echo "Storage symlink created successfully."
    else
        echo "Failed to create storage symlink."
    fi
else
    echo "Storage link already exists."
fi

echo "Clearing application cache..."
php artisan optimize:clear || true

echo "Caching configuration..."
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true
php artisan event:cache || true

echo "Fixing permissions..."
chown -R www-data:www-data storage bootstrap/cache
find storage bootstrap/cache -type d -exec chmod 775 {} \;
find storage bootstrap/cache -type f -exec chmod 664 {} \;

echo "=== Docker Entrypoint Finished ==="

exec "$@"
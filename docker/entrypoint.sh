#!/bin/sh

echo "Setting up directories and permissions..."
mkdir -p public \
         bootstrap/cache \
         storage/framework/sessions \
         storage/framework/views \
         storage/framework/cache \
         storage/logs
         
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R 775 /var/www/storage /var/www/bootstrap/cache

if [ ! -d "vendor" ]; then
    echo "Vendor folder not found. Installing dependencies..."
    composer install --no-interaction --no-scripts --no-dev
fi

echo "Running migrations and seeds..."
php artisan migrate --force
php artisan db:seed --force

echo "Waiting for MySQL to be ready..."
sleep 10

echo "Starting Laravel Scheduler..."
php artisan schedule:work &

echo "Starting Server..."
exec php artisan serve --host=0.0.0.0 --port=8000

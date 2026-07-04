#!/bin/bash
set -e

cd /var/www/html

# Clear stale caches
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Run migrations
php artisan migrate --force --no-interaction 2>/dev/null || true

# Seed admin user
php artisan db:seed --force --no-interaction 2>/dev/null || true

# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Fix permissions
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

echo "✅ EmBuddy Admin ready!"

# Start supervisor (PHP-FPM + Nginx)
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf

#!/bin/bash
set -e

cd /var/www/html

# Clear stale caches
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Run migrations (create users, sessions, cache tables + Prisma table guards)
php artisan migrate --force --no-interaction || echo "⚠️  Migration failed!"

# Seed admin user
php artisan db:seed --force --no-interaction || echo "⚠️  Seeding failed!"

# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Fix permissions
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

echo "✅ EmBuddy Admin ready!"

# Start supervisor (PHP-FPM + Nginx)
exec /usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf

#!/bin/bash
set -e

cd /var/www/todo-list

if grep -q "APP_KEY=$" .env || grep -q "APP_KEY=\"\"" .env; then
    echo "Generating APP_KEY..."
    php artisan key:generate --no-interaction
fi

wait_for_mysql() {
    echo "Waiting for MySQL to be ready..."
    max_tries=30
    counter=0

    while [ $counter -lt $max_tries ]; do
        if php artisan db:monitor --databases=mysql > /dev/null 2>&1; then
            echo "MySQL is ready!"
            return 0
        fi

        # Альтернативная проверка через mysqladmin
        if mysqladmin ping -h"$DB_HOST" --silent 2>/dev/null; then
            echo "MySQL is ready!"
            return 0
        fi

        counter=$((counter + 1))
        echo "Waiting for MySQL... ($counter/$max_tries)"
        sleep 2
    done

    echo "Warning: MySQL may not be ready, but continuing anyway..."
    return 0
}

wait_for_mysql

echo "Running migrations..."
php artisan migrate --force --no-interaction || echo "Migrations failed or already done"

if [ ! -L public/storage ]; then
    echo "Creating storage link..."
    php artisan storage:link --no-interaction || true
fi

echo "Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan view:clear

chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || true
chmod -R 775 storage bootstrap/cache 2>/dev/null || true

echo "Laravel setup complete! Starting PHP-FPM..."

exec php-fpm

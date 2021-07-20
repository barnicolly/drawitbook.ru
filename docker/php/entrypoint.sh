#!/bin/sh

echo "applying artisan"
php artisan config:cache
php artisan route:cache
php artisan optimize
echo "starting php-fpm"
exec $@
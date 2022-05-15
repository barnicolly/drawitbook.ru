#!/bin/sh

echo "applying artisan"
php artisan config:cache
php artisan route:cache
php artisan optimize
composer dump-autoload -o
echo "starting php-fpm"
exec $@
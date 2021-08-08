#!/bin/sh

composer config -g github-oauth.github.com "${COMPOSER_TOKEN}"

echo "install composer"
composer install && composer dump-autoload
copy cp /var/www/files/core/View.php /var/www/html/vendor/laravel/framework/src/Illuminate/View/View.php
echo "starting php-fpm"
exec $@
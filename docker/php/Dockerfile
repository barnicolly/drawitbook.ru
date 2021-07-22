FROM dockerhub.ratnikovmikhail.ru/projects/drawitbook_com/vendor as vendor
LABEL stage=builder

FROM dockerhub.ratnikovmikhail.ru/projects/drawitbook_com/static as assets
LABEL stage=builder

FROM dockerhub.ratnikovmikhail.ru/php:7.4

EXPOSE 9000
WORKDIR /var/www/html

COPY www/app /var/www/html/app
COPY www/bootstrap /var/www/html/bootstrap
COPY www/config /var/www/html/config
COPY www/database /var/www/html/database
COPY www/public /var/www/html/public
COPY www/routes /var/www/html/routes
COPY www/storage /var/www/html/storage
COPY www/server.php /var/www/html/server.php
COPY www/artisan /var/www/html/artisan
COPY www/composer.json /var/www/html/composer.json
COPY www/resources/views /var/www/html/resources/views
COPY www/resources/lang /var/www/html/resources/lang

COPY --from=vendor /var/www/html/vendor/ ./vendor/
COPY docker/php/files/core/View.php vendor/laravel/framework/src/Illuminate/View/View.php
COPY --from=assets /var/www/html/public/build/ ./public/build/

# Assign permissions of the working directory to the www-data user
RUN chown -R www-data:www-data \
        /var/www/html/storage \
        /var/www/html/bootstrap/cache \
        /var/www/html/storage/framework/cache/data

COPY docker/php/entrypoint.sh /var/www/html/entrypoint.sh
RUN ["chmod", "+x", "/var/www/html/entrypoint.sh"]

CMD ["/var/www/html/entrypoint.sh","php-fpm","-F"]
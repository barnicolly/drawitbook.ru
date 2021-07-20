FROM dockerhub.ratnikovmikhail.ru/php:7.4-composer

WORKDIR /var/www/html

COPY www/composer.json composer.json
COPY www/composer.lock composer.lock

RUN composer install \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --no-dev \
    --prefer-dist


FROM dockerhub.ratnikovmikhail.ru/php:8.0.9-composer

ARG COMPOSER_TOKEN
WORKDIR /var/www/html

COPY www/composer.json composer.json
COPY www/composer.lock composer.lock

RUN composer config -g github-oauth.github.com "${COMPOSER_TOKEN}"

RUN composer install \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --no-dev \
    --prefer-dist


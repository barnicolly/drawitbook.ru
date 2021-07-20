FROM dockerhub.ratnikovmikhail.ru/php:7.4-composer

RUN apk add --no-cache $PHPIZE_DEPS \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

WORKDIR /var/www/html

COPY docker/dev/php/entrypoint.sh /var/www/entrypoint.sh
COPY docker/dev/php/files /var/www/files
RUN ["chmod", "+x", "/var/www/entrypoint.sh"]

EXPOSE 9000

CMD ["/var/www/entrypoint.sh","php-fpm","-F"]
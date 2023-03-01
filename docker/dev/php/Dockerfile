FROM dockerhub.ratnikovmikhail.ru/php:8.2.3-composer

ARG USER_NAME
ARG USER_ID
ARG USER_GROUP_NAME
ARG USER_GROUP_ID

RUN apk add --no-cache $PHPIZE_DEPS \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

WORKDIR /var/www/html

RUN addgroup --system --gid ${USER_GROUP_ID} ${USER_GROUP_NAME} \
    && adduser --system --uid ${USER_ID} --ingroup ${USER_GROUP_NAME} ${USER_NAME}

COPY docker/dev/php/entrypoint.sh /var/www/entrypoint.sh
RUN ["chmod", "+x", "/var/www/entrypoint.sh"]

RUN chown -R ${USER_NAME}:${USER_NAME} /var/www/html
USER ${USER_NAME}
EXPOSE 9000

CMD ["/var/www/entrypoint.sh","php-fpm","-F"]
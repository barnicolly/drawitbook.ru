ARG TAG
FROM dockerhub.ratnikovmikhail.ru/projects/drawitbook_com/php:${TAG}

COPY docker/prod/scheduler/run-scheduler.sh  /var/www/run-scheduler.sh
RUN ["chmod", "+x", "/var/www/run-scheduler.sh"]

WORKDIR /var/www/html
EXPOSE 9000
CMD ["/var/www/html/entrypoint.sh","php-fpm","-F"]
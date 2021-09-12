ARG TAG

FROM dockerhub.ratnikovmikhail.ru/projects/drawitbook_com/static:${TAG} as assets
LABEL stage=builder

FROM dockerhub.ratnikovmikhail.ru/nginx:1.21 AS builder
LABEL stage=builder

FROM nginx:1.21.1-alpine
ARG TIME_ZONE

RUN ln -snf /usr/share/zoneinfo/${TIME_ZONE} /etc/localtime \
    && echo ${TIME_ZONE} > /etc/timezone

COPY --from=builder  /so-deps /usr/lib
COPY --from=builder  /usr/local/nginx/modules/ngx_http_brotli_filter_module.so /usr/local/nginx/modules/ngx_http_brotli_filter_module.so
COPY --from=builder  /usr/local/nginx/modules/ngx_http_brotli_static_module.so /usr/local/nginx/modules/ngx_http_brotli_static_module.so

WORKDIR /var/www/html

COPY docker/nginx/conf.d/default.conf /etc/nginx/conf.d/default.conf
COPY docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY www/public /var/www/html/public

COPY --from=assets /var/www/html/public/build/ ./public/build/

EXPOSE 80

STOPSIGNAL SIGTERM

CMD ["nginx", "-g", "daemon off;"]
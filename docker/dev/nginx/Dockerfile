FROM dockerhub.ratnikovmikhail.ru/nginx:1.21 AS builder
LABEL stage=builder

FROM nginx:1.21.1-alpine

COPY --from=builder  /so-deps /usr/lib
COPY --from=builder  /usr/local/nginx/modules/ngx_http_brotli_filter_module.so /usr/local/nginx/modules/ngx_http_brotli_filter_module.so
COPY --from=builder  /usr/local/nginx/modules/ngx_http_brotli_static_module.so /usr/local/nginx/modules/ngx_http_brotli_static_module.so

WORKDIR /var/www/html

COPY docker/dev/nginx/conf.d/default.conf /etc/nginx/conf.d/default.conf
COPY docker/dev/nginx/nginx.conf /etc/nginx/nginx.conf

EXPOSE 80

STOPSIGNAL SIGTERM

CMD ["nginx", "-g", "daemon off;"]
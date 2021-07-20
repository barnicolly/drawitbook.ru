FROM dockerhub.ratnikovmikhail.ru/projects/drawitbook_com/npm

ARG NODE_ENV
COPY www/webpack /var/www/html/webpack
COPY www/resources/static /var/www/html/resources/static
COPY www/.babelrc /var/www/html/.babelrc

RUN npm run build
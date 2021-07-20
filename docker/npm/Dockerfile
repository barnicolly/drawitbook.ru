FROM dockerhub.ratnikovmikhail.ru/node

WORKDIR /var/www/html

COPY www/package.json /var/www/html/package.json
COPY www/package-lock.json /var/www/html/package-lock.json

RUN npm i
FROM dockerhub.ratnikovmikhail.ru/node

ARG NPM_TOKEN
WORKDIR /var/www/html

COPY .npmrc /root/.npmrc
COPY www/package.json /var/www/html/package.json
COPY www/package-lock.json /var/www/html/package-lock.json
RUN echo $'\n' >> /root/.npmrc
RUN echo "//npm.ratnikovmikhail.ru/:_authToken="${NPM_TOKEN}"" >> /root/.npmrc

RUN npm i
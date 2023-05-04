FROM dockerhub.ratnikovmikhail.ru/projects/drawitbook_com/node
ARG NPM_TOKEN
WORKDIR /var/www/html

COPY .npmrc /root/.npmrc
RUN echo $'\n' >> /root/.npmrc
RUN echo "//npm.ratnikovmikhail.ru/:_authToken="${NPM_TOKEN}"" >> /root/.npmrc

COPY /docker/dev/webpack/entrypoint.sh /docker/init/entrypoint.sh
RUN ["chmod", "+x", "/docker/init/entrypoint.sh"]

CMD ["/docker/init/entrypoint.sh", "npm run dev"]
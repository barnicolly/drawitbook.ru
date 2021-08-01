FROM dockerhub.ratnikovmikhail.ru/node
ARG NPM_TOKEN
WORKDIR /var/www/html

COPY .npmrc /root/.npmrc
RUN echo $'\n' >> /root/.npmrc
RUN echo "//npm.ratnikovmikhail.ru/:_authToken="${NPM_TOKEN}"" >> /root/.npmrc

ENTRYPOINT ["tail", "-f", "/dev/null"]
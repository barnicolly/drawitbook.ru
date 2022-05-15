#!/bin/bash

# exit when any command fails
set -e

registry='dockerhub.ratnikovmikhail.ru'
projectName='drawitbook_com'

imagePrefix="${registry}/projects/${projectName}"

imagePhp="${imagePrefix}/php"
imageWebServer="${imagePrefix}/web_server"
imageVendorLibraries="${imagePrefix}/vendor"
imageNpmLibraries="${imagePrefix}/npm"
imageStatic="${imagePrefix}/static"
imageCronjob="${imagePrefix}/cronjob"
timeZone="Europe/Moscow"

docker build -t ${imageNpmLibraries} -f docker/prod/npm/Dockerfile --build-arg NPM_TOKEN=${NPM_TOKEN} .
docker build -t ${imageStatic} -f docker/prod/static/Dockerfile --build-arg NODE_ENV=production .
docker build -t ${imageVendorLibraries} -f docker/prod/vendor/Dockerfile --build-arg COMPOSER_TOKEN=${COMPOSER_TOKEN} .

docker build -t ${imagePhp} -f docker/prod/php/Dockerfile --build-arg TIME_ZONE=${timeZone} .
docker build -t ${imageWebServer} -f docker/prod/nginx/Dockerfile --build-arg TIME_ZONE=${timeZone} .

docker build -t ${imageCronjob} -f docker/prod/cron/Dockerfile --build-arg TIME_ZONE=${timeZone} .

docker push ${imageNpmLibraries}
docker push ${imageStatic}
docker push ${imageVendorLibraries}
docker push ${imagePhp}
docker push ${imageWebServer}
docker push ${imageCronjob}

imageNode="${imagePrefix}/node"
docker build -t ${imageNode} -f docker/base/node/Dockerfile .
docker push ${imageNode}
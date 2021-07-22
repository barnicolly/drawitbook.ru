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

docker build -t ${imageNpmLibraries} -f docker/npm/Dockerfile .
docker build -t ${imageStatic} -f docker/static/Dockerfile --build-arg NODE_ENV=production .
docker build -t ${imageVendorLibraries} -f docker/vendor/Dockerfile .

docker build -t ${imagePhp} -f docker/php/Dockerfile --build-arg TIME_ZONE=${timeZone} .
docker build -t ${imageWebServer} -f docker/nginx/Dockerfile --build-arg TIME_ZONE=${timeZone} .

docker build -t ${imageCronjob} -f docker/cron/Dockerfile --build-arg TIME_ZONE=${timeZone} .

docker push ${imageNpmLibraries}
docker push ${imageStatic}
docker push ${imageVendorLibraries}
docker push ${imagePhp}
docker push ${imageWebServer}
docker push ${imageCronjob}
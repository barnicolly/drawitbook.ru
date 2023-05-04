#!/bin/bash

# exit when any command fails
set -e

registry='dockerhub.ratnikovmikhail.ru'
image="${registry}/projects/drawitbook_com/node"

docker build -t ${image} .
docker push ${image}
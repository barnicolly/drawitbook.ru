#!/bin/bash

# exit when any command fails
set -e

sh build.sh
docker stack deploy -c docker-stack-check.yml drawitbook_com --with-registry-auth
#!/bin/sh

echo "install npm dependencies"
npm ci
echo "starting dev server"
exec $@
#!/usr/bin/env bash

# Fetch the latest protobufs and build.
ruby build_proto.rb

# Fetch, intall and autoload dependecies
rm -rf ./vendor
composer install
composer dump-autoload

./vendor/bin/phpunit -v ./tests/

rm -rf ./doc
mkdir doc
./vendor/bin/phpdoc run -d ./lib -t ./doc



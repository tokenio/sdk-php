#!/usr/bin/env bash

# Fetch the latest protobufs and build.
ruby build_proto.rb

# Fetch, intall and autoload dependecies
rm -rf ./vendor
composer install
composer dump-autoload

./vendor/phpunit/phpunit/phpunit -v ./tests/



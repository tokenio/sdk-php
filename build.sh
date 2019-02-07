#!/usr/bin/env bash

# Fetch the latest protobufs and build.
ruby build_proto.rb

# Fetch, intall and autoload dependecies
rm -rf ./vendor
composer install
composer dump-autoload


if ./vendor/bin/phpunit --testdox ./tests/; then
        rm -rf ./doc/generated
        mkdir ./doc/generated
        echo 'Generate Documentation'
        php ./tools/sami.phar update ./doc/config.php
        rm -rf ./cache
else
        exit 1
fi
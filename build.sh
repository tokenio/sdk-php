#!/usr/bin/env bash

# Fetch the latest protobufs and build.
ruby build_proto.rb

# Fetch, intall and autoload dependecies
rm -rf ./vendor
composer install
composer dump-autoload

if ./vendor/bin/phpunit --testdox ./tests/; then
        rm -rf ./doc
        mkdir doc
        echo 'Generate Documentation'
        ./vendor/phpdocumentor/phpdocumentor/bin/phpdoc run -d ./lib -t ./doc -c ./phpdoc.dist.xml| grep 'Parsing'
else
        exit 1
fi
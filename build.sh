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
        rm -rf ./vendor/phpdocumentor/phpdocumentor/data/templates/doc-template
        pwd
        ./vendor/phpdocumentor/phpdocumentor/bin/phpdoc run -d ./lib -t ./doc/generated -c ./phpdoc.dist.xml --template="./doc/doc-template" | grep 'Parsing'
        rm -rf ./doc/generated/phpdoc-cache-*
else
        exit 1
fi
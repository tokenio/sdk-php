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
        if php ./tools/sami.phar -v update ./doc/config.php; then
            echo "$(tput setaf 2)Documentation Generated Successfully$(tput sgr 0)"
            rm -rf ./cache
        else
            echo "$(tput setaf 1)Documentation Generation Failed$(tput sgr 0)"
            rm -rf ./doc/generated
            rm -rf ./cache
            exit 1
        fi
else
        exit 1
fi
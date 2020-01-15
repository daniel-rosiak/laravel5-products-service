#!/bin/bash

# ----------------------------------------------------------------------
# Create the .env file if it does not exist.
# ----------------------------------------------------------------------

if [[ ! -f "/home/wwwroot/api/.env" ]] && [[ -f "/home/wwwroot/api/.env.example" ]];
then
cp /home/wwwroot/api/.env.example /home/wwwroot/api/.env
fi

# ----------------------------------------------------------------------
# Run Composer
# ----------------------------------------------------------------------

if [[ ! -d "/home/wwwroot/api/vendor" ]];
then
cd /home/wwwroot/api
composer install
composer dump-autoload -o
fi

php-fpm
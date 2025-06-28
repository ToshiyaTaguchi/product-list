#!/bin/bash

cd /var/www

if [ ! -d "vendor" ]; then
  composer install
fi

php artisan key:generate

php-fpm

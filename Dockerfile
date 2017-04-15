FROM php:fpm

RUN apt-get update && apt-get install -y libpq-dev && docker-php-ext-install pdo pdo_pgsql

ADD ./ /var/www/html

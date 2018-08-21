FROM php:7-fpm

# see https://stackoverflow.com/a/36908278
RUN usermod -u 1000 www-data

RUN docker-php-ext-install pdo pdo_mysql


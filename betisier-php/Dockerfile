FROM php:8-apache

# FROM php:7-fpm
#To test see if we can use a php-fpm image instead of php-apache one.
#From https://developers.redhat.com/blog/2014/12/29/running-php-fpm-in-docker/
# RUN sed -e 's/127.0.0.1:9000/9000/' \
#         -e '/allowed_clients/d' \
#         -e '/catch_workers_output/s/^;//' \
#         -e '/error_log/d' \
#         -i /usr/local/etc/php-fpm.d/www.conf

# see https://stackoverflow.com/a/36908278
RUN usermod -u 1000 www-data

RUN docker-php-ext-install pdo pdo_mysql


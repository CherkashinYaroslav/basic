# Dockerfile
FROM php:8.3-apache

RUN apt-get update
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN apt-get update && apt-get install -y \
    zlib1g-dev \
    libzip-dev \
    unzip
RUN docker-php-ext-install zip
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


ADD app /var/www/app

WORKDIR /var/www/app


RUN composer install
RUN composer dumpautoload


EXPOSE 8080
CMD php yii serve 0.0.0.0

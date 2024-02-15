# Dockerfile
FROM php:8.3

RUN apt-get update -y && apt-get install -y libzip-dev

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN docker-php-ext-install pdo zip pdo_mysql

WORKDIR /app
COPY . /app

RUN composer install
RUN composer dumpautoload


EXPOSE 8080
CMD php yii serve 0.0.0.0

FROM php:8.5-fpm-alpine

RUN apk add --no-cache git unzip postgresql-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

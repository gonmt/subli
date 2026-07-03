FROM dunglas/frankenphp:1.12.0-php8.5-alpine AS base

RUN apk add --no-cache postgresql-dev \
    && install-php-extensions pdo_pgsql

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

FROM base AS dev
RUN install-php-extensions pcov

FROM base AS prod
RUN apk add --no-cache libcap \
    && setcap -r /usr/local/bin/frankenphp \
    && apk del libcap
COPY . .
RUN composer install --no-dev --optimize-autoloader --no-interaction

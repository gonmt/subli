FROM dunglas/frankenphp:1.12.0-php8.5-alpine

RUN apk add --no-cache postgresql-dev \
    && install-php-extensions pdo_pgsql pcov

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

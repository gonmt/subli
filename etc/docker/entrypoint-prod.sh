#!/bin/sh
set -e

php bin/console doctrine:migrations:migrate --no-interaction --allow-no-migration
php bin/console app:users:seed

exec frankenphp run --config /etc/frankenphp/Caddyfile

export DOCKER_UID := $(shell id -u)
export DOCKER_GID := $(shell id -g)

ifeq ($(CI),true)
RUN :=
else
RUN := docker compose exec app
endif

.PHONY: up down restart sh install warmup db-create migrate migrate-diff test mutation phpstan cs-fix cs-check phpcs phpcbf deptrac lint

up:
	docker compose up -d

down:
	docker compose down

restart:
	docker compose restart app

sh:
	docker compose exec app sh

install:
	$(RUN) composer install --no-interaction

warmup:
	$(RUN) bin/console cache:warmup --env=test

db-create:
	$(RUN) bin/console doctrine:database:create --env=test --no-interaction

migrate:
	$(RUN) bin/console doctrine:migrations:migrate --env=test --no-interaction

migrate-diff:
	$(RUN) bin/console doctrine:migrations:diff --no-interaction

test:
	$(RUN) bin/phpunit --configuration etc/phpunit/phpunit.xml.dist

mutation:
	$(RUN) vendor/bin/infection --configuration=etc/infection/infection.json5 --threads=4 --with-uncovered

phpstan:
	$(RUN) vendor/bin/phpstan analyse --configuration etc/phpstan/phpstan.neon --memory-limit=512M

cs-fix:
	$(RUN) vendor/bin/php-cs-fixer fix --config etc/php-cs-fixer/.php-cs-fixer.dist.php --allow-risky=yes

cs-check:
	$(RUN) vendor/bin/php-cs-fixer check --config etc/php-cs-fixer/.php-cs-fixer.dist.php --diff --allow-risky=yes

phpcs:
	$(RUN) vendor/bin/phpcs --standard=etc/phpcs/phpcs.xml

phpcbf:
	$(RUN) vendor/bin/phpcbf --standard=etc/phpcs/phpcs.xml

deptrac:
	$(RUN) vendor/bin/deptrac analyse --config-file etc/deptrac/deptrac.yaml

lint: phpstan cs-check phpcs deptrac

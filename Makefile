export DOCKER_UID := $(shell id -u)
export DOCKER_GID := $(shell id -g)

.PHONY: up down sh test phpstan cs-fix cs-check deptrac lint

up:
	docker compose up -d

down:
	docker compose down

sh:
	docker compose exec app sh

test:
	docker compose exec app bin/phpunit --configuration etc/phpunit/phpunit.xml.dist

phpstan:
	docker compose exec app vendor/bin/phpstan analyse --configuration etc/phpstan/phpstan.neon --memory-limit=512M

cs-fix:
	docker compose exec app vendor/bin/php-cs-fixer fix --config etc/php-cs-fixer/.php-cs-fixer.dist.php --allow-risky=yes

cs-check:
	docker compose exec app vendor/bin/php-cs-fixer check --config etc/php-cs-fixer/.php-cs-fixer.dist.php --diff --allow-risky=yes

deptrac:
	docker compose exec app vendor/bin/deptrac analyse --config-file etc/deptrac/deptrac.yaml

lint: phpstan cs-check deptrac

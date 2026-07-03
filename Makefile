export DOCKER_UID := $(shell id -u)
export DOCKER_GID := $(shell id -g)

.PHONY: up down sh test

up:
	docker compose up -d

down:
	docker compose down

sh:
	docker compose exec app sh

test:
	docker compose exec app bin/phpunit --configuration etc/phpunit/phpunit.xml.dist

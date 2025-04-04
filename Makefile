.DEFAULT := help

help:
	@awk 'BEGIN {FS = ":.*##"; printf "\n\033[1mUsage:\n  make \033[36m<target>\033[0m\n"} \
	/^[a-zA-Z_-]+:.*?##/ { printf "  \033[36m%-40s\033[0m %s\n", $$1, $$2 } /^##@/ \
	{ printf "\n\033[1m%s\033[0m\n", substr($$0, 5) } ' $(MAKEFILE_LIST)

DOCKER_DIR := docker
COMPOSE_FILES_ARGS := -f $(DOCKER_DIR)/docker-compose-shared-services.yml -f $(DOCKER_DIR)/docker-compose.yml

start:
	docker compose $(COMPOSE_FILES_ARGS) up -d

stop:
	docker compose $(COMPOSE_FILES_ARGS) down --remove-orphans

composer-install:
	docker compose $(COMPOSE_FILES_ARGS) run --rm --no-deps php composer install

drop-and-create:
	docker compose $(COMPOSE_FILES_ARGS) run --rm --no-deps php bin/console doctrine:database:drop --force --if-exists
	docker compose $(COMPOSE_FILES_ARGS) run --rm --no-deps php bin/console doctrine:database:create --if-not-exists
	docker compose $(COMPOSE_FILES_ARGS) run --rm --no-deps php bin/console doctrine:database:drop --force --if-exists --env=test
	docker compose $(COMPOSE_FILES_ARGS) run --rm --no-deps php bin/console doctrine:database:create --if-not-exists --env=test

migrate:
	docker compose $(COMPOSE_FILES_ARGS) run --rm --no-deps php bin/console doctrine:migrations:migrate --no-interaction
	docker compose $(COMPOSE_FILES_ARGS) run --rm --no-deps php bin/console doctrine:migrations:migrate --no-interaction --env=test

fixture:
	docker compose $(COMPOSE_FILES_ARGS) run --rm --no-deps php bin/console doctrine:database:drop --force --if-exists
	docker compose $(COMPOSE_FILES_ARGS) run --rm --no-deps php bin/console doctrine:database:create --if-not-exists
	docker compose $(COMPOSE_FILES_ARGS) run --rm --no-deps php bin/console doctrine:migrations:migrate --no-interaction
	docker compose $(COMPOSE_FILES_ARGS) run --rm --no-deps php bin/console doctrine:fixtures:load --no-interaction --append

test-drop-and-create:
	docker compose $(COMPOSE_FILES_ARGS) run --rm --no-deps php bin/console doctrine:database:drop --force --if-exists --env=test
	docker compose $(COMPOSE_FILES_ARGS) run --rm --no-deps php bin/console doctrine:database:create --if-not-exists --env=test

test-migrate:
	docker compose $(COMPOSE_FILES_ARGS) run --rm --no-deps php bin/console doctrine:migrations:migrate --no-interaction --env=test

test-fixture:
	docker compose $(COMPOSE_FILES_ARGS) run --rm --no-deps php bin/console doctrine:fixtures:load --no-interaction --append --env=test

diff:
	docker compose $(COMPOSE_FILES_ARGS) run --rm --no-deps php bin/console doctrine:migrations:diff

test:
	docker compose $(COMPOSE_FILES_ARGS) run --rm --no-deps php composer test


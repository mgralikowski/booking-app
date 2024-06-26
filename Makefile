.PHONY: *

CONTAINER_PHP=app

start: ## Start all containers
	@docker compose up --force-recreate -d

about: ## Display some debug information
	@docker exec ${CONTAINER_PHP} php artisan about

stop: ## Stop all containers
	@docker compose down

composer: ## Install composer dependencies
	@docker exec ${CONTAINER_PHP} composer install

upgrade: ## Upgrade vendors
	@docker exec ${CONTAINER_PHP} composer upgrade

migrate: ## Run migration files
	@docker exec ${CONTAINER_PHP} php artisan migrate:fresh --seed

clean: ## Run Pint (CS fixer)
	@docker exec ${CONTAINER_PHP} ./vendor/bin/pint

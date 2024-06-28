app-name     :=cushonrecruitmentscenario-app-1
phinx-config          	:=app/phinx.php
phinx-app     	      	:=./vendor/bin/phinx

ps: ## alias for docker ps
	docker ps --format 'table {{printf "%.20s" .Names}}\t{{.Image}}\t{{.Command}}\t{{.Ports}}\t{{printf "%.15s" .Status}}'

up:
	docker-compose up -d

first-time:
	make migrate-up
	make seed-run name=InitDBSeeder

down:
	docker compose stop

build:
	docker-compose up -d --build

rebuild:
	docker compose stop
	docker-compose up -d --build

shell:
	docker exec -it "$(app-name)" /bin/bash

logs:
	tail -n 5 -f src/logs/*.log  | ccze -m ansi

console:
	docker exec -it "$(app-name)" php bin/console $(cmd)

migrate-create: ## creates a new migration file in db/migrations/
	docker exec -it "$(app-name)" $(phinx-app) create $(name) -c $(phinx-config)

seed-create: ## creates a new seeder file in db/seeds/
	docker exec -it "$(app-name)" $(phinx-app) seed:create $(name) -c $(phinx-config)

migrate-up: ## creates a new migration file in db/migrations/
	docker exec -it "$(app-name)" $(phinx-app) migrate $(name) -c $(phinx-config)

migrate-down: ## creates a new migration file in db/migrations/
	docker exec -it "$(app-name)" $(phinx-app) rollback $(name) -c $(phinx-config)

seed-run: ## runs the specified seeder file in db/seeds/
	docker exec -it "$(app-name)" $(phinx-app) seed:run -s $(name) -c $(phinx-config)

test: ## run the unit tests
	docker exec -it "$(app-name)" ./vendor/bin/phpunit --testdox

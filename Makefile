docker_compose_exec = docker-compose exec -T
docker_php_console=${docker_compose_exec} php bin/console
docker_php = ${docker_compose_exec} php

## docker start
start:
	docker-compose up -d --remove-orphans

## docker stop
stop:
	docker-compose down

## docker log
log:
	docker-compose logs -f

## docker restart with logger
restart: stop start

## sync schema to database
migration:
	${docker_php} bin/console  doctrine:migration:migrate

## execute php cs fixer
php-cs-fixer:
	${docker_php} tools/php-cs-fixer/vendor/bin/php-cs-fixer fix src

## phpstan
phpstan:
	${docker_php} vendor/bin/phpstan analyse src tests

## php unitTest
test:
	${docker_php} bin/phpunit

# Help instructions
help:
	@echo "\033[0;33mUsage:\033[0m"
	@echo "     make [target]\n"
	@echo "\033[0;33mAvailable targets:\033[0m"
	@awk '/^[a-zA-Z\- _0-9\.@]+:/ { \
		returnMessage = match(n4line, /^# (.*)/); \
		if (returnMessage) { \
			printf "\n"; \
			printf "     %s\n", n5line; \
			printf "     %s\n", n4line; \
			printf "     %s\n", n3line; \
			printf "\n"; \
		} \
		helpMessage = match(lastLine, /^## (.*)/); \
		if (helpMessage) { \
			helpCommand = substr($$1, 0, index($$1, ":")); \
			helpMessage = substr(lastLine, RSTART + 3, RLENGTH); \
			printf "     \033[0;32m%-22s\033[0m %s\n", helpCommand, helpMessage; \
		} \
	} \
	{ n5line = n4line; n4line = n3line; n3line = n2line; n2line = lastLine; lastLine = $$0;}' $(MAKEFILE_LIST)
	@echo ""

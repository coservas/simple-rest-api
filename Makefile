ROOT_DIR := $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST))))/.make
include $(ROOT_DIR)/init.mk

### data ###
build: ##@data Build all or c=<name> services
	@$(DC) build $(c)

clean: confirm ##@data Stop containers and removing containers, networks, volumes, and images
	@$(DC) down

install: build start composer-install create-db-scheme ##@data Install application
### data ###


### running ###
start: ##@running Start all or c=<name> containers in background
	@$(DC) up -d $(c)

stop: ##@running Stop all or c=<name> containers
	@$(DC) stop $(c)

restart: ##@running Restart all or c=<name> containers
	@$(DC) stop $(c)
	@$(DC) up -d $(c)
### running ###


### shell ###
db: ##@console Database console
	@$(DC_EXEC) db psql $(DB_NAME) -U $(DB_USER)

bash: bash-fpm ##@console Alias bash-fpm

bash-db: ##@console Exec bash on database
	@$(DC_EXEC) db bash

bash-fpm: ##@console Exec bash on fpm
	@$(DC_EXEC) fpm sh

bash-nginx: ##@console Exec bash on nginx
	@$(DC_EXEC) nginx sh
### shell ###


### information ###
ps: status ##@info Alias of status

status: ##@info Show status of containers
	@$(DC) ps

logs: ##@info Show all or c=<name> logs of containers
	@$(DC) logs -f $(c)
### information ###

### install ###
composer-install: #@install Install composer packages
	@$(DC_EXEC) fpm composer install

create-db-scheme: #@install Create DB scheme
	@$(DC_EXEC) fpm vendor/bin/doctrine orm:schema-tool:create
### install ###
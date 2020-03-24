ROOT_DIR := $(shell dirname $(realpath $(lastword $(MAKEFILE_LIST))))/.make
include $(ROOT_DIR)/init.mk

### data ###
build: ##@data Build all or c=<name> services
	@$(DC) build $(c)

clean: confirm ##@data Stop containers and removing containers, networks, volumes, and images
	@$(DC) down
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
	@$(DC_EXEC) db mysql -u $(DB_USER) -p$(DB_PASS) $(DB_DATABASE)

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
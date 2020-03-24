DC_FILE := $(PROJECT_DIR)/docker/docker-compose.yml
DC := $(DOCKER_COMPOSE) -f $(DC_FILE)
DC_EXEC := $(DC) exec

QUIET := > /dev/null 2>&1
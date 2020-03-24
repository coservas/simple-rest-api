PROJECT_DIR := $(ROOT_DIR)/..

include $(ROOT_DIR)/.mk-lib/common.mk

include $(PROJECT_DIR)/.env
-include $(PROJECT_DIR)/.env.local
export

include $(ROOT_DIR)/variables.mk
-include $(ROOT_DIR)/phony.mk
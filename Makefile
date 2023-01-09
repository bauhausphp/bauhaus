MAKEFLAGS += --silent

php ?= 8.2.0
version = $(shell git rev-parse --short HEAD)
revision = dev-${version}-php${php}

export REGISTRY = ghcr.io
export PHP := ${php}
export REVISION := ${revision}

revision:
	@echo ${revision}

config:
	@make docker/config

build:
	@make docker/build

push:
	@make docker/push

pull:
	@make docker/pull

sh:
	@make docker/run cmd=sh

composer/%:
	@make docker/run cmd='make ${@}'

tests/%:
	@make docker/run cmd='make ${@}'

#
# Docker
docker: files = $(addprefix -f,$(shell make -s docker/files))
docker:
	@docker compose ${files} ${cmd}

docker/files: files = docker-compose.yaml $(if ${CI},,docker-compose.local.yaml)
docker/files:
	@echo ${files}

docker/run: options = --no-deps $(if ${CI},-T)
docker/run:
	@make docker cmd='run ${options} bauhaus ${cmd}'

docker/%:
	@make docker cmd='${*}'

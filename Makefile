MAKEFLAGS += --silent

version ?=$(shell git rev-parse --short HEAD)$(if ${CI},,-local)
php ?= 8.2.0
revision = dev-${version}-php${php}

export REGISTRY = ghcr.io
export PHP := ${php}
export REVISION := ${revision}

config:
	@make docker/compose/config

build:
	@make docker/compose/build

local-setup:
	@make build
#	@make -s setlocal-cp-files

clear:
	@make docker/compose/down

sh:
	@make docker/compose/run cmd=sh

#
# Inside container
composer/%:
	@make docker/compose/run/make target=${@}

tests/%:
	@make docker/compose/run/make target=${@}


# Dev
#local-cp-files: localBin = ./bin
#local-cp-files: localVendor = ./vendor
#local-cp-files:
#	@rm -rf ${localBin} ${localVendor}
#	@make -s stack cmd='up -d'
#	@make -s cp from=${DIR_BIN} to=${localBin}
#	@make -s cp from=${DIR_COMPOSER_VENDOR} to=${localVendor}
#	@make -s stack cmd='down --remove-orphans'
#
#cp:
#	@make -s stack cmd='cp bauhaus:${from} ${to}'

#
# Docker
docker/compose: files = $(addprefix -f,$(shell make -s docker/compose/files))
docker/compose:
	@docker compose ${files} ${cmd}

docker/compose/files: files = docker-compose.yaml $(if ${CI},,docker-compose.local.yaml)
docker/compose/files:
	@echo ${files}

docker/compose/config:
	@make docker/compose cmd=config

docker/compose/build:
	@make docker/compose cmd=build

docker/compose/down:
	@make docker/compose cmd=down

docker/compose/run: options = --no-deps $(if ${CI},-T)
docker/compose/run:
	@make docker/compose cmd='run ${options} bauhaus ${cmd}'

docker/compose/run/make:
	@make docker/compose/run cmd='make ${target}'

##
## Release
#publish: remote = git@github.com:bauhausphp/${package}.git
#publish: commit = Ref bauhausphp/bauhaus@${revision}
#publish: source = packages/src/${package}
#publish: destination = temp/${package}
#publish:
#	rm -rf ${destination}
#	git clone -b ${branch} ${remote} ${destination} || git clone ${remote} ${destination}
#	rsync --archive --verbose --exclude .git --delete-after ${source}/ ${destination}
#	git -C ${destination} add .
#	git -C ${destination} commit --message '${commit}' || echo 'No change'
#	git -C ${destination} push -u origin HEAD:${branch}

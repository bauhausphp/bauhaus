MAKEFLAGS += --silent

php ?= 8.2.0
version = $(shell git rev-parse --short HEAD)
revision = dev-${version}-php${php}

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

publish: remote = git@github.com:bauhausphp/${package}.git
publish: commit = Ref bauhausphp/bauhaus@${revision}
publish: source = code/packages/${package}
publish: destination = var/tmp/${package}
publish:
	@rm -rf ${destination}
	@git clone -b ${branch} ${remote} ${destination} || git clone ${remote} ${destination}
	@rsync --archive --verbose --exclude .git --delete-after ${source}/ ${destination}
	@git -C ${destination} config user.name "${author}"
	@git -C ${destination} config user.email ${email}
	@git -C ${destination} add .
	@git -C ${destination} commit --message '${commit}' || echo 'No change'
	@git -C ${destination} push -u origin HEAD:${branch}

#
# Docker
docker: files = $(addprefix -f,$(shell make -s docker/files))
docker:
	@TAG=${revision} PHP=${php} docker compose ${files} ${cmd}

docker/files: files = docker-compose.yaml $(if ${CI},,docker-compose.local.yaml)
docker/files:
	@echo ${files}

docker/run: options = --no-deps $(if ${CI},-T)
docker/run:
	@make docker cmd='run ${options} bauhaus ${cmd}'

docker/%:
	@make docker cmd='${*}'

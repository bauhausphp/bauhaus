#MAKEFLAGS += --silent

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

publish: remote = https://github.com/bauhausphp/${package}.git
publish: branch = $(shell git rev-parse --abbrev-ref HEAD)
publish: commit = Ref bauhausphp/bauhaus@${version}
publish: author-name = $(shell git --no-pager show -s --format='%an' HEAD)
publish: author-email = $(shell git --no-pager show -s --format='%ae' HEAD)
publish: source = ./code/packages/${package}
publish: workdir = ./var/tmp/${package}
publish:
	rm -rf ${workdir}
	git clone -b ${branch} ${remote} ${workdir} || git clone ${remote} ${workdir}
	rsync --archive --verbose --exclude .git --delete-after ${source}/ ${workdir}
	git -C ${workdir} config user.name "${author-name}"
	git -C ${workdir} config user.email ${author-email}
	git -C ${workdir} add .
	git -C ${workdir} commit --message "${commit}" && git -C ${workdir} push -u origin HEAD:${branch} || exit 0

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

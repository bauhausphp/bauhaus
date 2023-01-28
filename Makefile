MAKEFLAGS += --silent

php ?= 8.2.0
version = $(shell git rev-parse --short HEAD)
revision = dev-${version}-php${php}

install:
	@make docker/build
	@make docker/cp from=/usr/local/bauhaus/composer/code to=./vendors/code
	@make docker/cp from=/usr/local/bauhaus/composer/phars to=./vendors/phars

tests:
	@make docker/run cmd='make tests'

tests/%:
	@make docker/run cmd='make ${@}'

composer/%:
	@make docker/run cmd='make ${@}'

sh:
	@make docker/run cmd=sh

publish: remote = git@github.com:bauhausphp/${package}.git
publish: branch = $(shell git rev-parse --abbrev-ref HEAD)
publish: commit = Ref bauhausphp/bauhaus@${version}
publish: author-name = $(shell git --no-pager show -s --format='%an' HEAD)
publish: author-email = $(shell git --no-pager show -s --format='%ae' HEAD)
publish: workdir = ./var/tmp/${package}
publish:
	@rm -rf ${workdir}
	@git clone -b ${branch} ${remote} ${workdir} || git clone ${remote} ${workdir}
	@rsync --quiet --archive --verbose --exclude .git --delete-after ./code/packages/${package}/ ${workdir}
	@git -C ${workdir} status --porcelain
	@if [ "$$(git -C ${workdir} status --porcelain)" ]; then \
	    git -C ${workdir} config user.name "${author-name}"; \
	    git -C ${workdir} config user.email ${author-email}; \
	    git -C ${workdir} add .; \
	    git -C ${workdir} commit --message "${commit}"; \
	    git -C ${workdir} push -u origin HEAD:${branch}; \
	fi;

docker: files = $(addprefix -f,$(shell make -s docker/files))
docker:
	@TAG=${revision} PHP=${php} docker compose ${files} ${cmd}

docker/files:
	@echo docker-compose.yaml $(if ${CI},,docker-compose.local.yaml)

docker/run: options = --rm --no-deps $(if ${CI},-T)
docker/run:
	@make docker cmd='run ${options} bauhaus ${cmd}'
	@make docker/down

docker/down:
	@make docker cmd='down --remove-orphans'

docker/cp:
	@rm -rf ${to}
	@make docker cmd='up -d'
	@make docker cmd='exec bauhaus rm -rf ${from}/bauhaus'
	@make docker cmd='cp bauhaus:${from} ${to}'
	@make docker/down

docker/%:
	@make docker cmd='${*}'

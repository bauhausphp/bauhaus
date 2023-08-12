MAKEFLAGS += --silent --always-make
.PHONY: *

php ?= 8.2.8
version = $(shell git rev-parse --short HEAD)
revision = dev-${version}-php${php}

#
# Environment
install:
	make docker/build
	#$(if ${CI},,make copy-vendors)

sh:
	make docker/run entrypoint=sh

composer/%:
	make docker/run cmd=${@}

copy-vendors:
	make docker/up
	make docker/cp from=/usr/local/bauhaus/code/vendor to=./code/vendor
	make docker/cp from=/usr/local/bauhaus/phars/vendor to=./phars/vendor
	make docker/down

#
# Tests
tests:
	make docker/run cmd=tests

tests/%:
	make docker/run cmd=${@}

packages/tests/%:
	make docker/run cmd=tests/${*}

#
# Release
publish: remote = git@github.com:bauhausphp/${package}.git
publish: branch = $(shell git rev-parse --abbrev-ref HEAD)
publish: commit = Ref bauhausphp/bauhaus@${version}
publish: author-name = $(shell git --no-pager show -s --format='%an' HEAD)
publish: author-email = $(shell git --no-pager show -s --format='%ae' HEAD)
publish: workdir = ./var/tmp/${package}
publish:
	rm -rf ${workdir}
	git clone -b ${branch} ${remote} ${workdir} || git clone ${remote} ${workdir}
	rsync --quiet --archive --verbose --exclude .git --delete-after ./packages/src/${package}/ ${workdir}
	git -C ${workdir} status --porcelain
	if [ "$$(git -C ${workdir} status --porcelain)" ]; then \
	    git -C ${workdir} config user.name "${author-name}"; \
	    git -C ${workdir} config user.email ${author-email}; \
	    git -C ${workdir} add .; \
	    git -C ${workdir} commit --message "${commit}"; \
	    #git -C ${workdir} push -u origin HEAD:${branch}; \
	fi;

#
# Docker
docker: files = $(addprefix -f,$(shell make -s docker/files))
docker: envvars = TAG=${revision} PHP=${php}
docker:
	 ${envvars} docker compose ${files} ${cmd}

docker/%:
	make docker cmd=${*}

docker/files:
	echo docker-compose.yaml $(if ${CI},,docker-compose.local.yaml)

docker/up:
	make docker cmd='up -d'

docker/down:
	make docker cmd='down --remove-orphans --timeout 1'

docker/run: options = --rm --no-deps $(if ${CI},-T) $(if ${entrypoint},--entrypoint=${entrypoint})
docker/run:
	make docker cmd='run ${options} bauhaus ${cmd}'
	make docker/down

docker/cp:
	rm -rf ${to}
	make docker cmd='cp bauhaus:${from} ${to}'

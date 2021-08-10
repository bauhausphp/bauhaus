ifndef package
$(error package was not provided)
endif

#
# Setup
setup: clone install

clone: dir = $(shell pwd)/packages/${package}
clone: branch ?= main
clone: url = $(if ${CI},https://github.com/bauhausphp,git@github.com:bauhausphp)/${package}.git
clone:
	@git clone -b ${branch} ${url} ${dir}

#
# Dev
sh:
sh:
	@make run-docker cmd=sh

fix-cs:
	@make run-docker cmd=phpcbf

#
# Composer
update:
	@make run-docker cmd='composer update'

install:
	@make run-docker cmd='composer install -n'

require:
	@make run-docker cmd='composer require ${dep}'

#
# Test
tests:
	@make test-cs
	@make test-unit
	@make test-infection

test-cs:
	@make run-docker cmd='phpcs -ps'

test-stan:
	@make run-docker cmd='phpstan analyze -c phpstan.neon'

test-unit:
	@make run-docker cmd='phpunit $(if ${filter}, --filter=${filter}) --coverage-clover reports/clover.xml --coverage-html reports/html'

test-infection:
	@make run-docker cmd='infection -j2 -s'

coverage:
	@make run-docker cmd='php-coveralls -vvv $(if ${dryrun},--dry-run) -x reports/clover.xml -o reports/coveralls.json'

#
# Docker
run-docker:
	@make -C docker run $(if ${tag}, tag=${tag}) package=${package} cmd='${cmd}'

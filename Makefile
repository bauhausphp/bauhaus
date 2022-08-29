php ?= 8.1.9
image = bauhausphp/package-tests
workdir = /usr/local/bauhaus

sh:
	@make run cmd=sh

fix-cs:
	@make run cmd=phpcbf

test: level ?= all
test:
	@make run cmd='composer run test:${level}'

#
# Docker
php ?= 8.1.9
workdir = /usr/local/bauhaus
image = bauhausphp/contributor-tool
binds = composer.json composer.lock config packages reports tests

build: args = --build-arg PHP=${php} --build-arg WORKDIR=${workdir}
build:
	@docker build ${args} -t ${image} .

run: options = --rm $(if ${CI},,-it) ${volumes}
run: volumes = $(addprefix -v,$(join $(addprefix $(shell pwd)/,${binds}),$(addprefix :${workdir}/,${binds})))
run:
	@docker run ${options} ${image} ${cmd}

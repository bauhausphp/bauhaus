sh:
	@make -s run cmd=sh

fix-cs:
	@make -s run cmd=phpcbf

test: level ?= all
test:
	@make -s run cmd='composer run test:${level}'

#
# Docker
version ?= local
php ?= 8.1.9

registry = ghcr.io
image = ${registry}/bauhausphp/bauhaus:${tag}
tag = dev-${version}-php${php}
workdir = /usr/local/bauhaus

build: args  = --build-arg PHP=${php}
build: args += --build-arg WORKDIR=${workdir}
build:
	docker build ${args} -t ${image} .
	$(if ${CI},echo ${pass} | docker login ${registry} -u ${user} --password-stdin && docker push ${image})

run: binds = composer.json composer.lock config packages reports tests
run: volumes = $(addprefix -v ,$(join $(addprefix "$$PWD"/,${binds}),$(addprefix :${workdir}/,${binds})))
run: options = --rm $(if ${CI},,-it ${volumes})
run:
	docker run ${options} ${image} ${cmd}

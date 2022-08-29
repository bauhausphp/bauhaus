php ?= 8.1.9
image = bauhausphp/contributor-tool
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
binds = composer.json composer.lock packages reports tests

build:
	@docker build \
	    -t ${image} \
	    --build-arg PHP=${php} \
	    --build-arg WORKDIR=${workdir} \
	    .

run: hostDirs = $(addprefix $(shell pwd)/,${binds})
run: containerDir = $(addprefix :${workdir}/,${binds})
run: volumes = $(addprefix -v,$(join ${hostDirs},${containerDir}))
run:
	@docker run \
	    -it \
	    --rm \
	    ${volumes} \
	    ${image} \
	    ${cmd}

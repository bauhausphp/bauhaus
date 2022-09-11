fix-cs:
	@make -s composer cmd='run phpcbf'

test: level ?= all
test:
	@make -s composer cmd='run test:${level}'

composer:
	@make -s run cmd='composer ${cmd}'

sh:
	@make -s run cmd=sh

#
# Docker
revision ?= local
php ?= 8.1.9

registry = ghcr.io
image = ${registry}/bauhausphp/bauhaus:${tag}
tag = dev-${revision}-php${php}
workdir = /usr/local/bauhaus

build: args  = --build-arg PHP=${php}
build: args += --build-arg WORKDIR=${workdir}
build:
	docker build ${args} -t ${image} .
	$(if ${CI},docker push ${image})

run: binds = composer.json composer.lock cache config packages reports tests
run: volumes = $(addprefix -v ,$(join $(addprefix "$$PWD"/,${binds}),$(addprefix :${workdir}/,${binds})))
run: options = --rm $(if ${CI},,-it ${volumes})
run:
	docker run ${options} ${image} ${cmd}

#
# Release
publish: remote = git@github.com:bauhausphp/${package}.git
publish: commit = Ref bauhausphp/bauhaus@${revision}
publish: source = packages/${package}
publish: destination = temp/${package}
publish:
	rm -rf ${destination}
	git clone -b ${branch} ${remote} ${destination} || git clone ${remote} ${destination}
	rsync --archive --verbose --exclude .git --delete-after ${source}/ ${destination}
	git -C ${destination} add .
	git -C ${destination} commit --message '${commit}' || echo 'No change'
	git -C ${destination} push -u origin HEAD:${branch}

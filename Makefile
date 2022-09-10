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
revision ?= local
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

#
# Release
publish: remote = git@github.com:bauhausphp/${package}.git
publish: branch = ${version}
publish: commit = Ref bauhausphp/bauhaus@${revision}
publish: source = packages/${package}
publish: destination = temp/${package}
publish:
	rm -rf ${destination}
	git clone -b ${branch} ${remote} ${destination} || git clone ${remote} ${destination}
	rsync --archive --verbose --exclude .git --delete-after ${source}/ ${destination}
	git -C ${destination} add .
	git -C ${destination} commit --message '${commit}'
	git -C ${destination} push -u origin HEAD:${branch}

version ?= local
php ?= 8.1.9
revision = dev-${version}-php${php}

include stack.config.env
export
export PHP := ${php}
export REVISION := ${revision}

build:
	@make -s stack cmd=build

test: level ?= all
test:
	@make -s stack-run cmd='composer test:${level}'

sh:
	@make -s stack-run cmd='sh'

#
# Local
local-setup:
	@make -s build
	@make -s local-copy-vendor

local-copy-vendor:
	@make -s stack cmd='up -d'
	@make -s stack cmd='cp packages:${DIR_COMPOSER_VENDOR} ./vendor'
	@make -s stack cmd='down'

#
# Docker
stackFiles = stack.yaml $(if ${CI},,stack.local.yaml)

stack-files:
	@echo ${stackFiles}

stack-dump:
	@make -s stack cmd=config

stack-run: options = $(if ${CI},-T)
stack-run:
	@make -s stack cmd='run ${options} packages ${cmd}'

stack: stack = $(addprefix -f,${stackFiles})
stack:
	@docker compose ${stack} ${cmd}

#
# Release
publish: remote = git@github.com:bauhausphp/${package}.git
publish: commit = Ref bauhausphp/bauhaus@${revision}
publish: source = packages/src/${package}
publish: destination = temp/${package}
publish:
	rm -rf ${destination}
	git clone -b ${branch} ${remote} ${destination} || git clone ${remote} ${destination}
	rsync --archive --verbose --exclude .git --delete-after ${source}/ ${destination}
	git -C ${destination} add .
	git -C ${destination} commit --message '${commit}' || echo 'No change'
	git -C ${destination} push -u origin HEAD:${branch}

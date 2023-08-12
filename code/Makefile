MAKEFLAGS += --silent --always-make
.PHONY: *

#
# Composer
composer/%:
	make composer/phars/${*} composer/code/${*}

composer/code/%:
	make composer cmd=${*} workDir=${CODE_DIR}

composer/phars/%:
	make composer cmd=${*} workDir=${PHARS_DIR}

composer:
	composer -d ${workDir} ${cmd}

#
# Tests
tests:
	make tests/cs tests/unit tests/mutation

tests/cs:
	phpcs -ps \
		--standard=./config/phpcs.xml
		--cache=${CACHE_DIR}/phpcs.cache
#	deptrac \
#		--fail-on-uncovered \
#		--report-uncovered \
#		--cache-file=${CACHE_DIR}/deptrac.cache
#	deptrac \
#		--formatter=graphviz-image \
#		--output=${REPORTS_DIR}/dep-graph.svg \
#		--cache-file=${CACHE_DIR}/deptrac.cache

tests/unit:
	phpunit \
		--config config/phpunit.xml \
		--cache-result-file ${CACHE_DIR}/phpunit.cache \
		--coverage-clover ${REPORTS_DIR}/clover.xml \
		--coverage-html ${REPORTS_DIR}/coverage \
		${options} ${path}

tests/mutation:
	infection run -s -j4

tests/%:
	make tests/unit path=${@} options=--testdox

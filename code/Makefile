MAKEFLAGS += --silent
.PHONY: tests

tests:
	@make tests/unit
	@make tests/mutation

tests/cs:
	@phpcs -ps \
		--cache=${CACHE_DIR}/phpcs.cache
	@deptrac \
		--fail-on-uncovered \
		--report-uncovered \
		--cache-file=${CACHE_DIR}/deptrac.cache
	@deptrac \
		--formatter=graphviz-image \
		--output=${REPORTS_DIR}/dep-graph.svg \
		--cache-file=${CACHE_DIR}/deptrac.cache

tests/unit:
	@phpunit \
		--cache-result-file ${CACHE_DIR}/phpunit.cache \
		--coverage-clover ${REPORTS_DIR}/clover.xml \
		--coverage-html ${REPORTS_DIR}/coverage

tests/mutation:
	@infection run -s -j4

composer/install: composer/phars/install composer/code/install

composer/phars/%:
	@make composer cmd=${*} workDir=${PHARS_DIR} vendorDir=${COMPOSER_PHARS_DIR}

composer/code/%:
	@make composer cmd=${*} workDir=${CODE_DIR} vendorDir=${COMPOSER_CODE_DIR}

composer:
	@composer -d ${workDir} config vendor-dir ${vendorDir}
	@composer -d ${workDir} ${cmd}

MAKEFLAGS += --silent

export

#
# test
.PHONY: tests
tests:
	@make tests/unit
	@make tests/mutation

tests/cs:
	@phpcs -ps \
		--cache=${CACHE_DIR}/phpcs.cache

tests/unit:
	@phpunit \
		--cache-result-file ${CACHE_DIR}/phpunit.cache \
		--coverage-clover ${REPORTS_DIR}/reports/clover.xml \
		--coverage-html ${REPORTS_DIR}/reports/coverage

tests/mutation:
	@infection run -s -j4

#
# composer
composer/install: composer/phars/install composer/code/install

composer/phars/%:
	@make composer cmd=${*} workDir=${PHARS_DIR} vendorDir=${COMPOSER_PHARS_DIR}

composer/code/%:
	@make composer cmd=${*} workDir=${CODE_DIR} vendorDir=${COMPOSER_CODE_DIR}

composer:
	@composer -d ${workDir} config vendor-dir ${vendorDir}
	@composer -d ${workDir} ${cmd}

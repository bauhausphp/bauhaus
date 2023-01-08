MAKEFLAGS += --silent

test/unit:
	@phpunit \
	  --cache-result-file=./var/cache/phpunit.cache \
	  --coverage-clover ./var/reports/clover.xml \
	  --coverage-html ./var/reports/coverage

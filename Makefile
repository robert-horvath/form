PATH := vendor/bin:$(PATH)
.PHONY: clean dev-env no-dev-env build unit-test integration-test

build:
	@echo "\033[0;33m>>> Building forms\033[0m"
	./builder/build.py
	mv builder/src src/built

dev-env:
	@echo "\033[0;33m>>> Prepare workspace for development\033[0m"
	composer install --no-interaction --prefer-source

no-dev-env:
	@echo "\033[0;33m>>> Prepare workspace for production\033[0m"
	composer install --no-dev --no-interaction --prefer-source

clean:
	@echo "\033[0;33m>>> Cleaning workspace\033[0m"
	rm -rf src/built vendor composer.lock phpunit.xml tmp

unit-test:
	@echo "\033[0;33m>>> Running unit tests\033[0m"
	phpunit --testsuite Unit --process-isolation

integration-test:
	@echo "\033[0;33m>>> Running integration tests\033[0m"
	phpunit --testsuite Integration
  

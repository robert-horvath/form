.PHONY: clean build unit-test integration-test

clean:
	@echo "\033[0;33m>>> Cleaning workspace\033[0m"
	rm -rf src/built vendor composer.lock phpunit.xml

build:
	@echo "\033[0;33m>>> Building forms\033[0m"
	./builder/build.py
	mv builder/src src/built

unit-test:
	@echo "\033[0;33m>>> Running unit tests\033[0m"
	vendor/bin/phpunit --testsuite Unit --process-isolation

integration-test:
	@echo "\033[0;33m>>> Running integration tests\033[0m"
	vendor/bin/phpunit --testsuite Integration
  
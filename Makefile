.PHONY: clean check build


clean:
	@echo "\033[0;33m>>> Removing built forms\033[0m"
	rm -rf src/built

build:
	@echo "\033[0;33m>>> Building forms\033[0m"
	./builder/build.py
	mv builder/src src/built

test:
	@echo "\033[0;33m>>> Running unit tests\033[0m"
	vendor/bin/phpunit --testsuite Unit --process-isolation
	@echo "\033[0;33m>>> Running integration tests\033[0m"
	vendor/bin/phpunit --testsuite Integration
  
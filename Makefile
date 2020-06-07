all: install test

clean:
	rm -rf vendor/*

install:
	composer install

test:
	./vendor/bin/phpunit --stop-on-error

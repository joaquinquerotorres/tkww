.PHONY: all deps test fixer phpstan

all: deps test

deps:
	composer install

test:
	php ./vendor/bin/phpunit

fixer:
	php ./vendor/bin/php-cs-fixer fix

phpstan:
	php ./vendor/bin/phpstan analyse --debug --level 4 --memory-limit=1G src tests
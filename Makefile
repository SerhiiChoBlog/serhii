cache:
	php artisan optimize:clear
	php artisan config:cache
	php artisan view:cache
	php artisan route:cache
	php artisan cache:clear
	php artisan optimize

cache-clear:
	php artisan config:clear
	php artisan view:clear
	php artisan route:clear
	php artisan cache:clear
	php artisan optimize:clear

stan:
	php -d memory_limit=2G ./vendor/bin/phpstan analyse

test:
	rm -f database/database.sqlite
	touch database/database.sqlite
	./vendor/bin/phpunit

bint:
	./vendor/bin/pint

check:
	make bint
	make stan
	make test

sitemap:
	php artisan make:sitemap

push:
	make check
	make prod
	git pull origin HEAD
	git push origin HEAD
	git status

build:
	yarn build
	git add .
	git commit -m 'Compiled assets for production'
	git push origin HEAD

deploy:
	git pull origin HEAD
	php artisan migrate
	composer update --no-dev
	make sitemap
	make cache

.DEFAULT_GOAL := build

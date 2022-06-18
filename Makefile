cache:
	php artisan config:cache
	php artisan view:cache
	php artisan route:cache

cache-clear:
	php artisan config:clear
	php artisan view:clear
	php artisan route:clear
	php artisan cache:clear

stan:
	./vendor/bin/phpstan analyse

cs:
	./vendor/bin/phpcs app --colors -p

test:
	touch database/database.sqlite
	php artisan test

check:
	make stan
	make cs
	make test

push:
	make check
	git pull origin HEAD
	git push origin HEAD

deploy:
	git pull origin HEAD
	php artisan migrate
	composer update --no-dev
	make cache

.DEFAULT_GOAL := push

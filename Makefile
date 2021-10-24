cache:
	php artisan config:cache
	php artisan view:cache
	php artisan route:cache

cache-clear:
	php artisan config:clear
	php artisan view:clear
	php artisan route:clear

test:
	php artisan test

push:
	make test
	git pull origin HEAD
	git push origin HEAD

.DEFAULT_GOAL := push
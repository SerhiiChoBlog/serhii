FROM docker.io/php:8.4-fpm-alpine

WORKDIR /var/www/html

RUN apk update && \
    apk add --no-cache \
        git \
        curl-dev \
        libzip-dev \
        oniguruma-dev \
        libxml2-dev && \
    docker-php-ext-install \
        pdo \
        pdo_mysql \
        bcmath \
        curl \
        mbstring \
        xml \
        zip \
        opcache

COPY --from=composer:latest /usr/bin/composer /usr/bin/
COPY services/prod/php/zzz-custom.ini services/prod/php/zzz-opache.ini /usr/local/etc/php/conf.d/

COPY app/composer.* .

RUN composer install --no-interaction --prefer-dist --no-progress --no-dev --no-scripts && \
    composer clear-cache

COPY app .

RUN composer update --no-dev && composer clear-cache

RUN chown -R www-data:www-data .

CMD ["php-fpm"]

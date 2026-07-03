FROM docker.io/php:8.4-fpm-alpine

WORKDIR /var/www/html

RUN apk update && \
    apk add --no-cache \
        git \
        curl-dev \
        libzip-dev \
        oniguruma-dev \
        libxml2-dev \
        nodejs=24.17.0-r0 \
        npm  && \
    docker-php-ext-install \
        pdo \
        pdo_mysql \
        bcmath \
        curl \
        mbstring \
        xml \
        zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/
COPY services/dev/php/zzz-custom.ini /usr/local/etc/php/conf.d/

RUN chown -R www-data:www-data .

CMD ["php-fpm"]

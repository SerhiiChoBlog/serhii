FROM docker.io/php:8.4-fpm-alpine

WORKDIR /var/www/html

RUN apk update && \
    # Install debian packages
    apk add --no-cache \
        git \
        vim \
        bash \
        curl-dev \
        libzip-dev \
        oniguruma-dev \
        libxml2-dev && \
    # Install PHP extensions
    docker-php-ext-install \
        pdo \
        pdo_mysql \
        bcmath \
        curl \
        mbstring \
        xml \
        zip \
        opcache && \
    # Other commands
    echo "alias vi='vim'" >> /etc/profile

COPY --from=composer:latest /usr/bin/composer /usr/bin/
COPY services/prod/php/zzz-custom.ini services/prod/php/zzz-opache.ini /usr/local/etc/php/conf.d/

COPY app/composer.* .

RUN composer install --no-interaction --prefer-dist --no-progress --no-dev --no-scripts && \
    composer clear-cache

COPY app .

RUN composer update --no-dev && \
    composer clear-cache && \
    chown -R www-data:www-data . && \
    # Run php artisan commands here
    php artisan storage:link && \
    php artisan view:cache

CMD ["php-fpm"]

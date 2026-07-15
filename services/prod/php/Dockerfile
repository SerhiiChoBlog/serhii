FROM docker.io/php:8.4-fpm-alpine

WORKDIR /var/www/html

RUN apk update && \
    # Install debian packages
    apk add --no-cache \
        git \
        vim \
        bash \
        curl-dev \
        pecl \
        freetype-dev \
        supervisor \
        libxml2-dev \
        libzip-dev \
        libjpeg-turbo-dev \
        libpng-dev \
        oniguruma-dev && \
    # Install PHP extensions
    docker-php-ext-configure \
        gd --with-freetype --with-jpeg && \
    docker-php-ext-install \
        pdo \
        pdo_mysql \
        bcmath \
        curl \
        mbstring \
        xml \
        zip \
        gd \
        opcache && \
    pecl install redis && \
    docker-php-ext-enable \
        redis && \
    # Other commands
    echo "alias vi='vim'" >> ~/.bashrc && \
    echo "alias ll='ls -hlaF'" >> ~/.bashrc

COPY --from=composer:latest /usr/bin/composer /usr/bin/
COPY services/prod/php/zzz-custom.ini services/prod/php/zzz-opache.ini /usr/local/etc/php/conf.d/
COPY services/prod/jobs/supervisord.conf /etc/
COPY app/composer.* .

RUN composer install -n --prefer-dist --no-progress --no-dev --no-scripts && \
    composer clear-cache

COPY app .

RUN composer update -n --no-dev && \
    composer clear-cache && \
    chown -R www-data:www-data . && \
    php artisan storage:link && \
    php artisan view:cache

CMD [ "php-fpm" ]

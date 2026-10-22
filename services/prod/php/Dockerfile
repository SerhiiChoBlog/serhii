# syntax=docker/dockerfile:1
FROM docker.io/node:24-alpine AS frontend

WORKDIR /var/www/html

COPY app/package*.json ./
RUN npm ci

COPY app ./
RUN npm run build

# -----------------------------------

FROM docker.io/php:8.5-fpm-alpine

WORKDIR /var/www/html

RUN apk update && \
    # Install debian packages
    apk add --no-cache \
        git \
        vim \
        bash \
        curl-dev \
        autoconf \
        g++ \
        make \
        linux-headers \
        php85-pear \
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
    docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_mysql \
        bcmath \
        curl \
        mbstring \
        xml \
        zip \
        gd \
        pcntl && \
    MAKEFLAGS="-j$(nproc)" pecl install redis && \
    docker-php-ext-enable redis && \
    # Other commands
    echo "alias vi='vim'" >> ~/.bashrc && \
    echo "alias ll='ls -hlaF'" >> ~/.bashrc && \
    apk del autoconf g++ make linux-headers

COPY --from=docker.io/library/composer:2 /usr/bin/composer /usr/bin/
COPY services/prod/php/zzz-custom.ini services/prod/php/zzz-opache.ini /usr/local/etc/php/conf.d/
COPY services/prod/jobs/supervisord.conf /etc/
COPY app/composer.* .

RUN composer install -n --prefer-dist --no-progress --no-dev --no-scripts && \
    composer clear-cache

COPY app .
COPY --from=frontend /var/www/html/public/build public/build

RUN composer update -n --no-dev && \
    composer clear-cache && \
    chown -R www-data:www-data . && \
    php artisan storage:link && \
    php artisan view:cache && \
    # Install supercronic for Cron Jobs
    wget -qO /usr/local/bin/supercronic https://github.com/aptible/supercronic/releases/latest/download/supercronic-linux-amd64 && \
    chmod +x /usr/local/bin/supercronic

CMD [ "php-fpm" ]

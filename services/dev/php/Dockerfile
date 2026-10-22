# syntax=docker/dockerfile:1
FROM docker.io/php:8.5-fpm-alpine

ARG TARGETARCH
WORKDIR /var/www/html

RUN apk update && \
    apk add --no-cache \
        bash \
        curl-dev \
        git \
        freetype-dev \
        oniguruma-dev \
        vim \
        autoconf \
        g++ \
        make \
        supervisor \
        linux-headers \
        php84-pear \
        libxml2-dev \
        libzip-dev \
        libjpeg-turbo-dev \
        libpng-dev \
        nodejs \
        npm  && \
    # Install PHP extensions
    docker-php-ext-configure \
        gd --with-freetype --with-jpeg && \
    docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_mysql \
        bcmath \
        curl \
        mbstring \
        gd \
        xml \
        pcntl \
        zip && \
    MAKEFLAGS="-j$(nproc)" pecl install redis && \
    docker-php-ext-enable redis && \
    # Aliases
    echo "alias vi='vim'" >> ~/.bashrc && \
    echo "alias ll='ls -hlaF'" >> ~/.bashrc && \
    # Install supercronic for Cron Jobs
    wget -qO /usr/local/bin/supercronic https://github.com/aptible/supercronic/releases/latest/download/supercronic-linux-${TARGETARCH} && \
    chmod +x /usr/local/bin/supercronic

COPY --from=docker.io/library/composer:2 /usr/bin/composer /usr/bin/
COPY services/dev/php/zzz-custom.ini /usr/local/etc/php/conf.d/
COPY services/prod/jobs/supervisord.conf /etc/

CMD ["php-fpm"]

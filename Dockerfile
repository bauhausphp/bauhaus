ARG PHP

FROM php:${PHP}-alpine3.16

ARG WORKDIR
ENV COMPOSER_VENDOR_DIR /usr/local/composer

RUN apk add --no-cache \
        $PHPIZE_DEPS \
        git \
        vim && \
    curl -sS https://getcomposer.org/installer | php -- \
        --version=2.4.1 \
        --install-dir=/usr/local/bin \
        --filename=composer && \
    curl -sSLf -o /usr/local/bin/install-php-extensions https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions && \
    chmod +x /usr/local/bin/install-php-extensions && \
    install-php-extensions \
        pcov

WORKDIR $WORKDIR
COPY . .

RUN composer install \
        --no-cache \
        --no-scripts

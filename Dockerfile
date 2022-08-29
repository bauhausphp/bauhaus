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
        --filename=composer

WORKDIR $WORKDIR
COPY . .

RUN composer install --no-cache

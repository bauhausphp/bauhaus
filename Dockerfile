ARG PHP

FROM php:${PHP}-alpine3.16

ARG DIR_PACKAGES
ARG DIR_COMPOSER_VENDOR

ENV COMPOSER_VENDOR_DIR=$DIR_COMPOSER_VENDOR

RUN apk add --no-cache \
        $PHPIZE_DEPS \
        gnupg \
        graphviz \
        vim && \
    curl -sSLf \
        -o /usr/local/bin/install-php-extensions \
        https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions && \
    curl -sSLf \
        -o /usr/local/bin/phive \
        https://phar.io/releases/phive.phar && \
    chmod +x \
        /usr/local/bin/install-php-extensions \
        /usr/local/bin/phive && \
    install-php-extensions \
        pcov

WORKDIR $DIR_PACKAGES

COPY ./packages/ $DIR_PACKAGES
RUN yes | phive install && \
    composer install

ENTRYPOINT []

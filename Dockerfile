ARG PHP

FROM php:${PHP}-cli-alpine3.16

ARG DIR_BIN
ARG DIR_PACKAGES
ARG DIR_COMPOSER_VENDOR

ENV COMPOSER_VENDOR_DIR $DIR_COMPOSER_VENDOR
ENV PATH $PATH:$DIR_BIN

RUN apk add --no-cache \
        $PHPIZE_DEPS \
        gnupg \
        graphviz \
        terminus-font \
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

COPY ./bin/ $DIR_BIN
RUN cd $DIR_BIN && yes | phive install

COPY ./packages/ $DIR_PACKAGES
RUN cd $DIR_PACKAGES && composer install

ENTRYPOINT []

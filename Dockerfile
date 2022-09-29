ARG PHP

FROM php:${PHP}-cli-alpine3.16

ARG DIR_BIN
ARG DIR_PACKAGES
ARG DIR_COMPOSER_VENDOR

ENV COMPOSER_VENDOR_DIR $DIR_COMPOSER_VENDOR

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

COPY ./bin/ $DIR_BIN
RUN cd $DIR_BIN && \
    yes | phive install && \
    ln -s $DIR_BIN/composer.phar /usr/local/bin/composer && \
    ln -s $DIR_BIN/deptrac.phar /usr/local/bin/deptrac && \
    ln -s $DIR_BIN/infection.phar /usr/local/bin/infection && \
    ln -s $DIR_BIN/phpcs.phar /usr/local/bin/phpcs && \
    ln -s $DIR_BIN/phpunit.phar /usr/local/bin/phpunit

COPY ./packages/ $DIR_PACKAGES
RUN composer -d $DIR_PACKAGES install

WORKDIR $DIR_PACKAGES
ENTRYPOINT []

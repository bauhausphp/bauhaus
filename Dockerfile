ARG PHP

FROM php:${PHP}-alpine3.16

ARG WORKDIR
ENV COMPOSER_HOME /usr/local/composer
ENV PATH $PATH:$COMPOSER_HOME/vendor/bin

RUN apk add --no-cache \
        $PHPIZE_DEPS \
        gnupg \
        graphviz \
        vim && \
    curl -sS https://getcomposer.org/installer | php -- \
        --install-dir=/usr/local/bin \
        --filename=composer && \
    curl -sSLf https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions \
        -o /usr/local/bin/install-php-extensions && \
    chmod +x \
        /usr/local/bin/install-php-extensions && \
    install-php-extensions \
        pcov
RUN composer global require --no-cache \
        phpunit/phpunit:^9.5 \
        qossmic/deptrac-shim:^0.24.0 \
        squizlabs/php_codesniffer:^3.7
        #infection/infection:^0.26.13 \

WORKDIR $WORKDIR
COPY . .

RUN composer install --no-cache

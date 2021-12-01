FROM php:8.1.0-cli-alpine

ENV WORKDIR /usr/local/bauhaus
ENV COMPOSER_HOME /usr/local/composer
ENV PATH $PATH:$COMPOSER_HOME/vendor/bin:$WORKDIR/vendor/bin

WORKDIR $WORKDIR

COPY composer.* $COMPOSER_HOME/

RUN apk add --no-cache \
        $PHPIZE_DEPS \
        git \
        openssh \
        vim && \
    sh -c "$(curl -s https://raw.githubusercontent.com/fefas/docker-php8-ext-installer/main/installer.sh)" \
        pcov && \
    curl -sS https://getcomposer.org/installer | php -- \
        --version=2.1.5 \
        --install-dir=/usr/local/bin \
        --filename=composer && \
    composer global install \
        --prefer-dist \
        --no-cache

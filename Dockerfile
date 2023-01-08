ARG PHP

FROM php:${PHP}-cli-alpine3.16

ENV HOME_DIR /usr/local/bauhaus
ENV COMPOSER_CODE_DIR $HOME_DIR/composer/phars
ENV COMPOSER_PHARS_DIR $HOME_DIR/composer/code
ENV CODE_DIR $HOME_DIR/code
ENV PHARS_DIR $HOME_DIR/phars
ENV VAR_DIR $HOME_DIR/var

ENV PATH $PATH:$COMPOSER_PHARS_DIR/bin

RUN apk add --no-cache \
        $PHPIZE_DEPS \
        gnupg \
        graphviz \
        make \
        terminus-font \
        vim && \
    curl -sSLf \
        -o /usr/local/bin/composer \
        https://getcomposer.org/download/2.5.1/composer.phar && \
    curl -sSLf \
        -o /usr/local/bin/install-php-extensions \
        https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions && \
    chmod +x \
        /usr/local/bin/composer \
        /usr/local/bin/install-php-extensions && \
    install-php-extensions \
        intl \
        pcov && \
    adduser bauhaus sudo -u 1000 -h $HOME_DIR -s /sbin/nologin -D && \
    chown -R bauhaus:bauhaus $HOME_DIR

WORKDIR $CODE_DIR
USER bauhaus

COPY --chown=bauhaus:bauhaus phars/ $PHARS_DIR/
COPY --chown=bauhaus:bauhaus code/ $CODE_DIR/

RUN make composer/install

ENTRYPOINT []

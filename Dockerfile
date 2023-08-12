ARG PHP

FROM php:${PHP}-cli-alpine3.18

ENV HOME_DIR /usr/local/bauhaus
ENV CACHE_DIR $HOME_DIR/var/cache
ENV PACKAGES_DIR $HOME_DIR/packages
ENV PHARS_DIR $HOME_DIR/phars
ENV REPORTS_DIR $HOME_DIR/var/reports

ENV PATH $PATH:$HOME_DIR/phars/vendor/bin

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
    mkdir -p \
        $CACHE_DIR \
        $PACKAGES_DIR \
        $PHARS_DIR \
        $REPORTS_DIR && \
    chown -R bauhaus:bauhaus $HOME_DIR

WORKDIR $PACKAGES_DIR
USER bauhaus

COPY --chown=bauhaus:bauhaus phars/ $PHARS_DIR/
COPY --chown=bauhaus:bauhaus packages/ $PACKAGES_DIR/

RUN make composer/install

ENTRYPOINT ["make"]

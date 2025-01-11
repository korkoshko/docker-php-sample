FROM php:8.4-fpm AS php_base

ARG TIMEZONE=UTC

RUN ln -snf /usr/share/zoneinfo/$TIMEZONE /etc/localtime && echo $TIMEZONE > /etc/timezone

COPY --from=composer/composer:2.8-bin --link /composer /usr/bin/composer

RUN apt-get update -y && apt-get install -y libpq-dev postgresql-client libicu-dev libxslt1-dev libzip-dev zip unzip \
    && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install -j$(nproc) pdo_pgsql intl xsl zip exif dom;

COPY --from=ghcr.io/php/pie:bin /pie /usr/bin/pie

RUN pie install phpredis/phpredis:6.1.0

WORKDIR /app

FROM php_base AS php_dev

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

COPY ./docker/backend/php.ini "$PHP_INI_DIR/conf.d/php-custom.ini"

ARG USERNAME=app
ARG USER_ID=1000
ARG GROUP_ID=1000

RUN addgroup ${USERNAME} --gid ${GROUP_ID} && \
    adduser --disabled-password --gecos "" --uid "${USER_ID}" --gid="${GROUP_ID}" ${USERNAME}  \
    && sed -i -e 's/#force_color_prompt/force_color_prompt/g' /home/${USERNAME}/.bashrc

COPY --chown=${USERNAME}:${USERNAME} ./docker/backend/.bash_aliases /home/${USERNAME}/.bash_aliases

USER ${USERNAME}
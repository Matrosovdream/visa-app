# syntax=docker/dockerfile:1.6

# ---------- Base ----------
FROM php:8.2-fpm-alpine AS base

RUN apk add --no-cache \
        bash \
        git \
        curl \
        icu-dev \
        libzip-dev \
        zip \
        unzip \
        oniguruma-dev \
        postgresql-dev \
        libpng-dev \
        libjpeg-turbo-dev \
        freetype-dev \
        autoconf \
        g++ \
        make \
        linux-headers \
        supervisor \
        tzdata

RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install -j$(nproc) \
        pdo \
        pdo_pgsql \
        pgsql \
        intl \
        zip \
        bcmath \
        gd \
        opcache \
        pcntl \
        sockets

RUN pecl install redis \
 && docker-php-ext-enable redis

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY docker/php/php.ini /usr/local/etc/php/conf.d/zz-app.ini
COPY docker/php/www.conf /usr/local/etc/php-fpm.d/zz-www.conf

WORKDIR /var/www/html

# Match host UID/GID when building (override with --build-arg)
ARG UID=1000
ARG GID=1000
RUN addgroup -g ${GID} app || true \
 && adduser -D -u ${UID} -G app -s /bin/sh app || true \
 && chown -R app:app /var/www/html

# ---------- Dev ----------
FROM base AS dev

RUN apk add --no-cache nodejs npm \
 && pecl install xdebug \
 && docker-php-ext-enable xdebug

COPY docker/php/xdebug.ini /usr/local/etc/php/conf.d/zz-xdebug.ini

USER app
EXPOSE 9000
CMD ["php-fpm", "-F"]

# ---------- Prod ----------
FROM base AS prod

ENV COMPOSER_ALLOW_SUPERUSER=1

# Install JS toolchain only for asset build, then drop it
COPY --chown=app:app composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --no-interaction --no-progress

COPY --chown=app:app . .

RUN apk add --no-cache --virtual .build-node nodejs npm \
 && npm ci \
 && npm run build \
 && apk del .build-node \
 && rm -rf node_modules

RUN composer dump-autoload --optimize --classmap-authoritative --no-dev \
 && mkdir -p storage/framework/{cache,sessions,views} storage/logs bootstrap/cache \
 && chown -R app:app storage bootstrap/cache \
 && chmod -R ug+rwx storage bootstrap/cache

USER app
EXPOSE 9000
CMD ["php-fpm", "-F"]

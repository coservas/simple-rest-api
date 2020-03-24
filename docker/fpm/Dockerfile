FROM php:7.4.4-fpm-alpine
COPY --from=composer:1.10.1 /usr/bin/composer /usr/bin/composer

RUN apk --no-cache add postgresql-dev \
    && docker-php-ext-configure pgsql \
    && docker-php-ext-install pgsql pdo_pgsql \
    && mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

WORKDIR /var/app
FROM php:7.4-fpm

RUN docker-php-ext-install \
    pdo \
    pdo_mysql

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

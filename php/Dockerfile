FROM php:8.3-fpm

LABEL authors="antonmiroshnikov"

RUN apt update \
    && apt install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip \
    && docker-php-ext-install intl opcache pdo pdo_mysql \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip

WORKDIR /var/www/app

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN touch /var/log/xdebug.log && \
    chmod 777 /var/log/xdebug.log

USER root

FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    libzip-dev \
    git \
    wget \
    --no-install-recommends \
 && apt-get clean \
 && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN wget https://getcomposer.org/download/2.2.6/composer.phar \
    && mv composer.phar /usr/bin/composer \
    && chmod +x /usr/bin/composer

COPY xdebug/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

WORKDIR /var/www

COPY . /var/www
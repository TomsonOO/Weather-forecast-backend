FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    libzip-dev \
    git \
    wget \
    libpq-dev \
    --no-install-recommends \
 && apt-get clean \
 && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN docker-php-ext-install pdo pdo_pgsql pgsql mysqli pdo_mysql zip;

RUN wget https://getcomposer.org/download/2.2.6/composer.phar \
    && mv composer.phar /usr/bin/composer && chmod +x /usr/bin/composer

WORKDIR /var/www

COPY . /var/www
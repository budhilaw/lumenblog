FROM php:7.3.1-fpm

MAINTAINER Abed Halawi <abed.halawi@vinelab.com>

RUN apt-get update
RUN apt-get install -y autoconf pkg-config libssl-dev
RUN pecl install mongodb
RUN docker-php-ext-install bcmath
RUN echo "extension=mongodb.so" >> /usr/local/etc/php/conf.d/mongodb.ini

RUN apt-get update && apt-get install -y libzip-dev libmcrypt-dev git

RUN apt-get install -y zlib1g-dev \
    && docker-php-ext-install zip

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# lumen packages

RUN docker-php-ext-install mbstring tokenizer pdo pdo_mysql

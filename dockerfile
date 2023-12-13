FROM php:8.1-apache

RUN apt-get update \
    && apt-get install -y libpng-dev libjpeg-dev \
    && docker-php-ext-configure gd --with-jpeg \
    && docker-php-ext-install mysqli gd

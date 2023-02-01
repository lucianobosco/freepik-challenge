FROM php:8.1-fpm

ARG uid
ARG user
ARG group

RUN apt update \
    && apt install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip libpq-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install intl opcache pdo pdo_pgsql \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip

WORKDIR /var/www/slim_app

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN git config --global user.email "lucianobosco@gmail.com" \
    && git config --global user.name "Luciano Bosco"

# Create a group and user
RUN useradd -G www-data,root -u ${uid} -d /home/${user} ${user} \
    && chown -R ${group}:${group} /var/www/

USER $user
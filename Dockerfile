FROM php:8.1.1-apache

WORKDIR /var/www/html

RUN apt-get update \
    && apt-get install -y libonig-dev libzip-dev unzip\
    && docker-php-ext-install pdo_mysql mysqli mbstring zip bcmath

RUN curl -fsSL https://deb.nodesource.com/setup_lts.x | bash -
RUN apt-get install -y nodejs
RUN apt-get install -y build-essential

COPY ./src /var/www/html
COPY ./app/php.ini /usr/local/etc/php/php.ini

COPY --from=composer /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER 1

COPY ./app/php.ini /usr/local/etc/php/php.ini
COPY ./app/run-apache2.sh /usr/local/bin/
CMD [ "run-apache2.sh" ]
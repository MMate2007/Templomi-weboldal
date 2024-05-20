FROM php:8.1.12-apache
COPY phpconf/ /usr/local/etc/php/conf.d
COPY forraskod/ /var/www/html
RUN docker-php-ext-install mysqli
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug
RUN apt-get -y update
RUN apt-get -y install git zip unzip
COPY --from=composer/composer:latest-bin /composer /usr/bin/composer
EXPOSE 80
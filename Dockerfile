FROM php:8.1.12-apache
COPY forraskod/ /var/www/html
RUN docker-php-ext-install mysqli
RUN apt-get -y update
RUN apt-get -y install git zip unzip
COPY --from=composer/composer:latest-bin /composer /usr/bin/composer
EXPOSE 80
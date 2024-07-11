FROM php:8.1.12-apache
COPY phpconf/ /usr/local/etc/php/conf.d
COPY forraskod/ /var/www/html
WORKDIR /var/www/html
RUN docker-php-ext-install mysqli
RUN apt-get update
RUN apt-get -y install git zip unzip
COPY --from=composer/composer:latest-bin /composer /usr/bin/composer
RUN composer install --dev
RUN vendor/bin/pscss -s expanded css/customise.scss css/customise.min.css
EXPOSE 80

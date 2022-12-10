FROM php:8.1.12-apache
COPY forraskod/ /var/www/html
RUN docker-php-ext-install mysqli
EXPOSE 80
FROM php:8.4-apache

RUN a2enmod rewrite

RUN docker-php-ext-install opcache

ENV APACHE_DOCUMENT_ROOT=/var/www/public_html

RUN sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf
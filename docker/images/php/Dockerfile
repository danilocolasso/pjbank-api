FROM php:7.2-apache

# lumen packages
RUN docker-php-ext-install pdo_mysql && docker-php-ext-enable pdo_mysql
RUN docker-php-ext-install mysqli pdo && docker-php-ext-enable mysqli pdo
RUN docker-php-ext-install mbstring tokenizer && docker-php-ext-enable mbstring tokenizer

RUN a2enmod rewrite
FROM php:7.4-apache

#RUN docker-php-ext-install -j$(nproc) mysqli
#RUN docker-php-ext-enable  mysqli

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN apt-get update && apt-get upgrade -y

# Use an official PHP runtime as a parent image
FROM php:7.4-apache

# Set the working directory to /var/www/html
WORKDIR /var/www/html

# Copy the current directory contents into the container at /var/www
COPY . /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y \
        libmcrypt-dev \
        zlib1g-dev \
        libzip-dev \
    && docker-php-ext-install pdo_mysql \
    && docker-php-ext-install zip \
    && docker-php-ext-install bcmath
 
# Expose port 80 for web traffic
EXPOSE 80
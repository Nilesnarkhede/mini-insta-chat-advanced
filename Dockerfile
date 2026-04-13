FROM php:8.2-apache

# Install mysqli
RUN docker-php-ext-install mysqli

# Enable rewrite
RUN a2enmod rewrite

# Copy project
COPY . /var/www/html/

# Set working dir
WORKDIR /var/www/html/

# Expose port
EXPOSE 80

FROM php:8.2-cli

# Install mysqli
RUN docker-php-ext-install mysqli

# Set working directory
WORKDIR /app

# Copy project
COPY . /app

# Start PHP server
CMD php -S 0.0.0.0:8080 -t public

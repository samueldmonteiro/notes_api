# Use the official PHP 8.2 image as the base image
FROM php:8.2-apache

# Copy the application files into the container
COPY . /var/www/html

# Set the working directory in the container
WORKDIR /var/www/html

# Install necessary PHP extensions and MariaDB server
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    mariadb-server \
    && docker-php-ext-install \
    intl \
    zip \
    mbstring \
    pdo \
    pdo_mysql \
    bcmath \
    xml \
    && a2enmod rewrite

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install Laravel dependencies
RUN composer install --no-dev --prefer-dist --optimize-autoloader

# Set proper permissions for Laravel
RUN chown -R www-data:www-data /var/www/html

# Configure MariaDB
RUN service mysql start && \
    mysql -e "CREATE DATABASE laravel;" && \
    mysql -e "CREATE USER 'laravel'@'localhost' IDENTIFIED BY 'laravel';" && \
    mysql -e "GRANT ALL PRIVILEGES ON laravel.* TO 'laravel'@'localhost';" && \
    mysql -e "FLUSH PRIVILEGES;"

# Expose port 80 for the web server and 3306 for MariaDB
EXPOSE 80 3306

# Start both Apache and MariaDB services when the container starts
CMD service mysql start && apache2-foreground

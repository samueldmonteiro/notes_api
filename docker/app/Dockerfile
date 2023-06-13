FROM php:8.2.0-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Create system user to run Composer and Artisan Commands
RUN if [ "$user" != "root" ]; then echo "Creating $user" && \
    useradd -G www-data,root -u $uid -d /home/$user $user && \ 
    mkdir -p /home/$user/.compose && \
    chown -R $user:$user /home/$user;fi;

#RUN useradd -G www-data,root -u $uid -d /home/$user $user
#RUN mkdir -p /home/$user/.composer && \
#    chown -R $user:$user /home/$user


# Install node.js
#RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - &&\
 #   apt-get install -y nodejs

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libjpeg-dev

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

RUN docker-php-ext-configure gd --with-jpeg && \
    docker-php-ext-install gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

USER $user

FROM php:8.2-fpm

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*
RUN apt-get update && \
    apt-get install -y libjpeg-dev libpng-dev libfreetype6-dev
# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg --enable-gd

RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd


# Install zip extension using pecl
RUN pecl install zip && docker-php-ext-enable zip

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer


# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

# Set working directory
WORKDIR /var/www

RUN echo "post_max_size = 150M" >> /usr/local/etc/php/php.ini
RUN echo "upload_max_filesize = 150M" >> /usr/local/etc/php/php.ini
RUN echo "memory_limit = 2048M" >> /usr/local/etc/php/php.ini
RUN echo "extension=gd" >> /usr/local/etc/php/php.ini

USER $user

# Base image with PHP 8.2 and Apache
FROM php:8.2-apache

# Install system dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip unzip git curl libzip-dev libssl-dev libpq-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip curl \
    && a2enmod rewrite

# Install Redis PHP extension if you want Redis support (optional)
# RUN pecl install redis && docker-php-ext-enable redis

# Install Composer globally
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . /var/www/html

# Install composer dependencies without dev packages, optimize autoloader
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Generate app key if not set in environment variables
RUN php artisan key:generate

# Set proper permissions on storage and cache folders
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port 80 (Apache)
EXPOSE 80

# Run Apache in foreground
CMD ["apache2-foreground"]

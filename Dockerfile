FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    ca-certificates \
    apt-transport-https \
    gnupg2 \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip unzip git curl libzip-dev libssl-dev libpq-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip curl \
    && a2enmod rewrite \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . /var/www/html

RUN composer install --no-dev --optimize-autoloader --no-interaction

RUN php artisan key:generate

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80

CMD ["apache2-foreground"]

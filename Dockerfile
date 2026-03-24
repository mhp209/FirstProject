# FROM php:8.3-fpm

# # Install dependencies
# RUN apt-get update && apt-get install -y \
#     git curl zip unzip libzip-dev libpng-dev libonig-dev libxml2-dev

# # Install PHP extensions
# RUN docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd zip

# # Install Composer (separate command)
# COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# WORKDIR /var/www

# CMD ["php-fpm"]

# ----------- New --------------
FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev zip \
    libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql zip gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN cp .env.example .env || true

RUN php artisan key:generate || true

RUN chmod -R 777 storage bootstrap/cache

# CMD ["php-fpm"]
# CMD php artisan serve --host=0.0.0.0 --port=80
CMD php -S 0.0.0.0:80 index.php

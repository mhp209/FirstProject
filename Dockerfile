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
    && docker-php-ext-install pdo pdo_mysql zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
COPY . .

RUN composer install --no-dev --optimize-autoloader

CMD ["php-fpm"]
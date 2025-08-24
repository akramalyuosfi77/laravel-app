FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    git unzip libpng-dev libonig-dev libxml2-dev zip curl

COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN composer install --no-dev --optimize-autoloader

RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

EXPOSE 10000

CMD php artisan serve --host=0.0.0.0 --port=10000

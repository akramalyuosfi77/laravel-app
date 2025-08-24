# استخدم صورة PHP مع Apache
FROM php:8.2-apache

# ثبّت المكتبات اللي يحتاجها Laravel و Excel
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql mbstring exif pcntl bcmath

# نسخ composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# حدد مسار العمل
WORKDIR /var/www/html

# انسخ ملفات المشروع
COPY . .

# ثبّت الحزم مع تجاوز فحص gd (احتياطياً)
RUN composer install --ignore-platform-req=ext-gd --no-dev --optimize-autoloader

# Laravel cache
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# افتح بورت 80
EXPOSE 80

# شغل Apache
CMD ["apache2-foreground"]

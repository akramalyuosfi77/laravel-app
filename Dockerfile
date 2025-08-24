# استخدم صورة PHP مع Apache
FROM php:8.2-apache

# ثبّت المكتبات المطلوبة للـ GD و Laravel
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

# نسخ Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# حدد مجلد العمل
WORKDIR /var/www/html

# انسخ ملفات المشروع
COPY . .

# ثبّت الحزم
RUN composer install --no-dev --optimize-autoloader

# Laravel cache
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# افتح بورت 80
EXPOSE 80

# شغل Apache
CMD ["apache2-foreground"]

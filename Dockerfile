FROM php:8.2-apache

# تفعيل rewrite module في Apache
RUN a2enmod rewrite

# تثبيت الامتدادات المطلوبة للـ Laravel
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    sqlite3 \
    libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite zip mbstring exif pcntl bcmath

# تنزيل Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# نسخ المشروع
WORKDIR /var/www/html
COPY . .

# تثبيت المكتبات
RUN composer install --no-dev --optimize-autoloader

# نسخ ملف env إذا موجود
COPY .env /var/www/html/.env

# صلاحيات للـ storage والـ bootstrap
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port
EXPOSE 80

# تشغيل Apache
CMD ["apache2-foreground"]

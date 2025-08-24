# 1) PHP 8.2 + Apache
FROM php:8.2-apache

# 2) اجعل public هو الجذر وافعل rewrite
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && a2enmod rewrite \
    && echo "ServerName localhost" >> /etc/apache2/apache2.conf

# 3) حزم النظام + امتدادات PHP (مع SQLite)
RUN apt-get update && apt-get install -y \
    git unzip zip \
    sqlite3 libsqlite3-dev \
    libzip-dev libonig-dev libxml2-dev \
    libpng-dev libjpeg-dev libfreetype6-dev \
 && docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install -j$(nproc) gd pdo_mysql pdo_sqlite bcmath exif zip

# 4) Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# 5) مجلد العمل + نسخ المشروع
WORKDIR /var/www/html
COPY . .

# 6) تأكد من وجود ملف قاعدة البيانات وصلاحيات Laravel
RUN mkdir -p database storage/logs bootstrap/cache \
 && touch database/database.sqlite storage/logs/laravel.log \
 && chown -R www-data:www-data storage bootstrap/cache database \
 && chmod -R 775 storage bootstrap/cache database

# 7) تثبيت الاعتمادات
RUN composer install --no-interaction --prefer-dist --no-dev --optimize-autoloader

# ملاحظة مهمة: لا تعمل config:cache في مرحلة الـ build
# حتى تأخذ متغيّرات بيئة Render مفعولها وقت التشغيل

EXPOSE 80
CMD ["apache2-foreground"]

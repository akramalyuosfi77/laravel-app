# ===================================================================
# ==                  المرحلة الأولى: البناء (Builder)                ==
# ===================================================================
# استخدم نفس صورة PHP كأساس لمرحلة البناء
FROM php:8.2-apache as builder

# 1) تثبيت كل الحزم المطلوبة للبناء (PHP + Node.js + SQLite)
RUN apt-get update && apt-get install -y \
    git unzip zip \
    sqlite3 libsqlite3-dev \
    libzip-dev libonig-dev libxml2-dev \
    libpng-dev libjpeg-dev libfreetype6-dev \
    nodejs npm \
 && docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install -j$(nproc) gd pdo_mysql pdo_sqlite bcmath exif zip

# 2) تثبيت Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# 3) نسخ ملفات المشروع والبدء في العمل
WORKDIR /var/www/html
COPY . .

# 4) تثبيت اعتماديات PHP
RUN composer install --no-interaction --prefer-dist --no-dev --optimize-autoloader

# 5) تثبيت اعتماديات الواجهة الأمامية وبناء التصميم
RUN npm install
RUN npm run build

# ===================================================================
# ==                المرحلة الثانية: الإنتاج (Production)             ==
# ===================================================================
# ابدأ من صورة PHP-Apache نظيفة للإنتاج
FROM php:8.2-apache

# 1) إعداد Apache
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && a2enmod rewrite \
    && echo "ServerName localhost" >> /etc/apache2/apache2.conf

# 2) تثبيت امتدادات PHP المطلوبة للتشغيل فقط
#    (تم إضافة apt-get update هنا لإصلاح الخطأ)
RUN apt-get update && apt-get install -y \
    sqlite3 libsqlite3-dev \
    libzip-dev libonig-dev libxml2-dev \
    libpng-dev libjpeg-dev libfreetype6-dev \
 && docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install -j$(nproc) gd pdo_mysql pdo_sqlite bcmath exif zip

# 3) نسخ الملفات الجاهزة من مرحلة البناء
WORKDIR /var/www/html
COPY --from=builder /var/www/html .

# 4) تأكد من وجود ملف قاعدة البيانات وصلاحيات Laravel
RUN mkdir -p database storage/logs bootstrap/cache \
 && touch database/database.sqlite storage/logs/laravel.log \
 && chown -R www-data:www-data storage bootstrap/cache database public \
 && chmod -R 775 storage bootstrap/cache database public

EXPOSE 80
CMD ["apache2-foreground"]

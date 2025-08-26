# ===================================================================
# ==                  المرحلة الأولى: البناء (Builder)                ==
# ===================================================================
FROM php:8.2-apache as builder

# 1) تثبيت كل الحزم المطلوبة للبناء
RUN apt-get update && apt-get install -y \
    git unzip zip sqlite3 libsqlite3-dev libzip-dev libonig-dev libxml2-dev \
    libpng-dev libjpeg-dev libfreetype6-dev nodejs npm \
 && docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install -j$(nproc) gd pdo_mysql pdo_sqlite bcmath exif zip

# 2) تثبيت Composer
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# 3) نسخ ملفات المشروع
WORKDIR /var/www/html
COPY . .

# 4) تثبيت اعتماديات PHP
RUN composer install --no-interaction --prefer-dist --no-dev --optimize-autoloader

# 5) بناء الواجهة الأمامية
RUN npm install
RUN npm run build

# ===================================================================
# ==                المرحلة الثانية: الإنتاج (Production)             ==
# ===================================================================
FROM php:8.2-apache

# 1) إعداد Apache
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && a2enmod rewrite \
    && echo "ServerName localhost" >> /etc/apache2/apache2.conf

# 2) تثبيت امتدادات PHP المطلوبة للتشغيل
RUN apt-get update && apt-get install -y \
    sqlite3 libsqlite3-dev libzip-dev libonig-dev libxml2-dev \
    libpng-dev libjpeg-dev libfreetype6-dev \
 && docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install -j$(nproc) gd pdo_mysql pdo_sqlite bcmath exif zip

# 3) نسخ الملفات الجاهزة من مرحلة البناء
WORKDIR /var/www/html
COPY --from=builder /var/www/html .

# ===================================================================
# ==      الخطوة الحاسمة: تشغيل أوامر Laravel بعد النسخ      ==
# ===================================================================
RUN php artisan config:cache \
 && php artisan route:cache \
 && php artisan view:cache \
 && chown -R www-data:www-data /var/www/html \
 && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80
CMD ["apache2-foreground"]

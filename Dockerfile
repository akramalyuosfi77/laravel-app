# 1. ابدأ بصورة PHP الرسمية التي تحتوي على Apache
FROM php:8.2-apache

# 2. تثبيت الأدوات الأساسية وامتدادات PHP التي يحتاجها Laravel
RUN apt-get update && apt-get install -y \
    git unzip zip \
    libzip-dev libonig-dev libxml2-dev \
    libpng-dev libjpeg-dev libfreetype6-dev \
    nodejs npm \
 && docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install -j$(nproc) gd pdo_mysql bcmath exif zip

# 3. تثبيت Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. إعداد مجلد العمل داخل السيرفر
WORKDIR /var/www/html

# 5. نسخ كل ملفات المشروع من جهازك إلى السيرفر
COPY . .

# 6. تثبيت اعتماديات PHP
RUN composer install --no-interaction --no-dev --optimize-autoloader

# 7. بناء ملفات الواجهة الأمامية
RUN npm install && npm run build

# ===================================================================
# ==      الخطوة الحاسمة: تشغيل migrations وإنشاء الجداول      ==
# ===================================================================
# 8. تشغيل أوامر Laravel النهائية
RUN php artisan migrate --force \
 && chown -R www-data:www-data storage bootstrap/cache

# 9. تعديل ملف إعدادات Apache ليشير إلى مجلد public
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf
RUN a2enmod rewrite

# 10. تشغيل الخادم
CMD ["apache2-foreground"]

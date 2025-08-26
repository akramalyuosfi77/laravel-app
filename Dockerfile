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

# 8. ضبط صلاحيات المجلدات التي يكتب فيها Laravel
RUN chown -R www-data:www-data storage bootstrap/cache

# 9. إعداد Apache ليشير إلى مجلد public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN a2enmod rewrite

# 10. تشغيل الخادم
CMD ["apache2-foreground"]

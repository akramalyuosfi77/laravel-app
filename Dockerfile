# 1. استخدم أحدث إصدار من PHP 8.2 مع خادم Apache
FROM php:8.2-apache

# 2. حدد المجلد العام الصحيح لـ Laravel وأخبر Apache بذلك
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN a2enmod rewrite

# 3. ثبّت الحزم والمكتبات الأساسية وامتدادات PHP المطلوبة
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo_mysql bcmath exif zip

# 4. انسخ Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. حدد مجلد العمل
WORKDIR /var/www/html

# 6. انسخ ملفات المشروع
COPY . .

# 7. **أصلح الملكية والصلاحيات (هذه هي الخطوة الأهم)**
# أولاً: غيّر ملكية كل الملفات إلى مستخدم Apache
RUN chown -R www-data:www-data /var/www/html

# 8. **أنشئ ملف السجل وأعطه الصلاحيات الصحيحة (هذا هو الإصلاح الجديد)**
RUN mkdir -p storage/logs && \
    touch storage/logs/laravel.log && \
    chmod -R 775 storage bootstrap/cache && \
    chown -R www-data:www-data storage bootstrap/cache

# 9. ثبّت حزم Laravel
RUN composer install --no-interaction --no-plugins --no-scripts --no-dev --optimize-autoloader

# 10. شغّل أوامر Laravel
RUN php artisan config:cache
RUN php artisan route:cache
RUN php artisan view:cache

# 11. شغّل Apache
CMD ["apache2-foreground"]

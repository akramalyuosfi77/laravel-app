# استخدم PHP مع Apache
FROM php:8.2-apache

# ثبّت المكتبات الضرورية
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo_mysql bcmath exif zip

# انسخ Composer من صورة رسمية
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# عيّن مسار العمل داخل الحاوية
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf

# انسخ الملفات
COPY . .

# ثبّت الحزم بالـ Composer
RUN composer install --no-dev --optimize-autoloader

# Laravel cache
RUN php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# فعّل mod_rewrite في Apache
RUN a2enmod rewrite

# افتح البورت 80
EXPOSE 80

# شغل Apache
CMD ["apache2-foreground"]

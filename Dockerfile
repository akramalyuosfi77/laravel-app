# ===================================================================
# ==                  المرحلة الأولى: البناء (Builder)                ==
# ===================================================================
FROM php:8.2-apache as builder

# ... (كل شيء في مرحلة البناء يبقى كما هو) ...
RUN apt-get update && apt-get install -y \
    git unzip zip sqlite3 libsqlite3-dev libzip-dev libonig-dev libxml2-dev \
    libpng-dev libjpeg-dev libfreetype6-dev nodejs npm \
 && docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install -j$(nproc) gd pdo_mysql pdo_sqlite bcmath exif zip
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer
WORKDIR /var/www/html
COPY . .
RUN composer install --no-interaction --prefer-dist --no-dev --optimize-autoloader
RUN npm install
RUN npm run build

# ===================================================================
# ==                المرحلة الثانية: الإنتاج (Production)             ==
# ===================================================================
FROM php:8.2-apache

# ... (كل شيء في مرحلة الإنتاج يبقى كما هو) ...
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && a2enmod rewrite \
    && echo "ServerName localhost" >> /etc/apache2/apache2.conf
RUN apt-get update && apt-get install -y \
    sqlite3 libsqlite3-dev libzip-dev libonig-dev libxml2-dev \
    libpng-dev libjpeg-dev libfreetype6-dev \
 && docker-php-ext-configure gd --with-freetype --with-jpeg \
 && docker-php-ext-install -j$(nproc) gd pdo_mysql pdo_sqlite bcmath exif zip

WORKDIR /var/www/html

# --- التغيير الحاسم هنا ---
# 1. انسخ كل شيء ما عدا مجلد public
COPY --from=builder /var/www/html/app ./app
COPY --from=builder /var/www/html/bootstrap ./bootstrap
COPY --from=builder /var/www/html/config ./config
COPY --from=builder /var/www/html/database ./database
COPY --from=builder /var/www/html/resources ./resources
COPY --from=builder /var/www/html/routes ./routes
COPY --from=builder /var/www/html/storage ./storage
COPY --from=builder /var/www/html/vendor ./vendor
COPY --from=builder /var/www/html/*.php .
COPY --from=builder /var/www/html/composer.json .
COPY --from=builder /var/www/html/composer.lock .

# 2. انسخ مجلد public بأكمله بشكل صريح ومنفصل
COPY --from=builder /var/www/html/public ./public

# ... (بقية الملف كما هو) ...
RUN mkdir -p database/migrations/tenant \
 && touch database/database.sqlite storage/logs/laravel.log \
 && chown -R www-data:www-data storage bootstrap/cache database public \
 && chmod -R 775 storage bootstrap/cache database public

EXPOSE 80
CMD ["apache2-foreground"]

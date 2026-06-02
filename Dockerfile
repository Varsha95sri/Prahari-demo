FROM php:8.3-apache
WORKDIR /var/www/html
RUN apt-get update && apt-get install -y \
    libzip-dev \
    libpq-dev \
    zip unzip git curl \
    && docker-php-ext-install \
    pdo \
    pdo_pgsql \
    zip \
    && rm -rf /var/lib/apt/lists/*
RUN a2enmod rewrite
# Point Apache to Laravel public folder
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf
COPY . .
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader
RUN mkdir -p /var/www/html/storage/framework/sessions \
    /var/www/html/storage/framework/views \
    /var/www/html/storage/framework/cache/data \
    /var/www/html/bootstrap/cache \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache
EXPOSE 80
COPY start.sh /start.sh
RUN chmod +x /start.sh
CMD ["/start.sh"]
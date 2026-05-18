# ── Stage 1: Build frontend assets ────────────────────────────────────────────
FROM node:20-alpine AS frontend

WORKDIR /app
COPY package.json package-lock.json* ./
RUN npm ci --ignore-scripts
COPY vite.config.js ./
COPY resources/ ./resources/
COPY public/ ./public/
RUN npm run build

# ── Stage 2: Install PHP dependencies ────────────────────────────────────────
FROM composer:2 AS vendor

WORKDIR /app
COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --no-interaction \
    --no-scripts \
    --prefer-dist \
    --optimize-autoloader

# ── Stage 3: Production image ────────────────────────────────────────────────
FROM php:8.3-apache

# Install PHP extensions required by Laravel
RUN apt-get update && apt-get install -y --no-install-recommends \
        libzip-dev \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        libonig-dev \
        libxml2-dev \
        libsqlite3-dev \
        unzip \
        curl \
        ca-certificates \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
        pdo \
        pdo_sqlite \
        mbstring \
        zip \
        gd \
        bcmath \
        opcache \
        xml \
        fileinfo \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Enable Apache mod_rewrite
RUN a2enmod rewrite headers

# Set Apache DocumentRoot to Laravel's public directory
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf

# Allow .htaccess overrides
RUN sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' \
    /etc/apache2/apache2.conf

# Set working directory
WORKDIR /var/www/html

# Copy application code
COPY . .

# Copy vendor dependencies from composer stage
COPY --from=vendor /app/vendor ./vendor

# Copy built frontend assets from node stage
COPY --from=frontend /app/public/build ./public/build

# Apply the Turso driver patch (lastInsertId fix)
COPY docker/patches/LibSQLPDOStatement.php \
     ./vendor/darkterminal/turso-http-laravel/src/Database/LibSQLPDOStatement.php

# Set correct permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# PHP production optimizations
RUN echo "opcache.enable=1" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.memory_consumption=128" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.max_accelerated_files=10000" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.validate_timestamps=0" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "upload_max_filesize=10M" >> /usr/local/etc/php/conf.d/uploads.ini \
    && echo "post_max_size=12M" >> /usr/local/etc/php/conf.d/uploads.ini

# Copy and set entrypoint
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

EXPOSE 80

ENTRYPOINT ["docker-entrypoint.sh"]

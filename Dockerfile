# Gunakan PHP 8.2 CLI (cukup untuk dev pakai php artisan serve)
FROM php:8.2-cli

# Set working directory
WORKDIR /var/www/html

# Install ekstensi yang dibutuhkan Laravel (pdo_mysql, dll)
RUN docker-php-ext-install pdo pdo_mysql

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin --filename=composer

# Copy seluruh source code ke container
COPY . .

# Install dependency Laravel
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Pastikan storage & cache bisa ditulis
RUN mkdir -p storage/framework/cache \
    storage/framework/sessions \
    storage/framework/views \
    && chmod -R 777 storage bootstrap/cache

# Jalankan server Laravel (untuk development)
CMD php artisan serve --host=0.0.0.0 --port=8000

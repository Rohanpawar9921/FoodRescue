FROM php:8.2-apache

# intall sqlite 3
RUN apt-get update && apt-get install -y \
    sqlite3 \
    libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite \
    && apt-get clean \
    && rm -rf /var/lib/ap/lists/*

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html


# Copy application files
COPY . /var/www/html/


# Set permissions for database file
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod 664 /var/www/html/mini_shop.db 2>/dev/null || true

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]


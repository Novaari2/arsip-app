# Base image
FROM php:7.4-apache

# Set working directory
WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql zip

# Enable Apache Rewrite module
RUN a2enmod rewrite

# Copy application files
COPY . /var/www/html

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install application dependencies
RUN composer install --no-scripts --no-autoloader

# Generate optimized autoloader
RUN composer dump-autoload --optimize

# Set environment variables
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Configure Apache virtual host
RUN sed -i -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf \
    && sed -i -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/default-ssl.conf

# Expose port
EXPOSE 80

# Run Apache
CMD ["apache2-foreground"]

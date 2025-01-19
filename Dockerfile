FROM php:8.2-apache

# Install extensions needed by Laravel
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo_mysql zip

# Enable mod_rewrite for Laravel (pretty URLs)
RUN a2enmod rewrite

# Install Composer (Laravel's package manager)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the working directory for your app
WORKDIR /var/www/html

# Copy your project into the container
COPY . /var/www/html

# Change Apache config to make /public the DocumentRoot
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf \
    && sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# Adjust file permissions (especially /storage for logs & cache)
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage

EXPOSE 80
CMD ["apache2-foreground"]

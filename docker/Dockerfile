# Apache
FROM php:8.1.12-apache

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libicu-dev \
    libzip-dev \
    libpq-dev \
    && docker-php-ext-install \
    intl \
    zip \
    pdo_pgsql \
    pdo_mysql

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# RUN docker-php-ext-install pdo mysqli pdo_mysql zip; //

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# RUN composer install --optimize-autoloader // vérifier path to composer.json

# Copy existing application directory permissions
COPY --chown=www:www . /var/www/html/

COPY docker/apache.conf /etc/apache2/sites-enabled/000-default.conf

# Set the working directory
WORKDIR /var/www/html

# Expose port 80
EXPOSE 80

CMD ["apache2-foreground"]
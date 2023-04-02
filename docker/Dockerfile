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
COPY --chown=www-data:www-data . /var/www/html/

COPY docker/apache/apache.conf /etc/apache2/sites-enabled/000-default.conf
COPY docker/php/php.ini /etc/php/

# Set the working directory
WORKDIR /var/www/html

# Expose port 80
EXPOSE 80

CMD ["apache2-foreground"]

# Redirect PHP logs to stdout/stderr
RUN ln -sf /dev/stdout /var/log/apache2/access.log && \
    ln -sf /dev/stderr /var/log/apache2/error.log

# Configure PHP
RUN { \
    echo 'memory_limit = 256M'; \
    echo 'error_reporting = E_ALL'; \
    echo 'display_errors = On'; \
    echo 'log_errors = On'; \
    echo 'error_log = /dev/stderr'; \
} > /usr/local/etc/php/conf.d/docker-php.ini
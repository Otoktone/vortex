# Apache
FROM php:8.1-apache

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libicu-dev \
    libzip-dev

RUN docker-php-ext-install \
    intl \
    zip \
    pdo_mysql \
    mysqli

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Copy existing application directory permissions
# COPY --chown=www-data:www-data . /var/www/html/

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Redirect PHP logs to stdout/stderr
# RUN ln -sf /dev/stdout /var/log/apache2/access.log && \
#     ln -sf /dev/stderr /var/log/apache2/error.log

# Configure PHP
# RUN { \
#     echo 'memory_limit = 256M'; \
#     echo 'error_reporting = E_ALL'; \
#     echo 'display_errors = On'; \
#     echo 'log_errors = On'; \
#     echo 'error_log = /dev/stderr'; \
# } > /usr/local/etc/php/conf.d/docker-php.ini

# TODO match host user id and group id
# TODO change user by default by www-data

# RUN composer install --optimize-autoloader
# COPY composer.json composer.lock /var/www/html/
# RUN composer install --no-interaction --no-ansi --optimize-autoloader

COPY docker/apache/apache.conf /etc/apache2/sites-enabled/000-default.conf
COPY docker/php/php.ini /etc/php/
COPY docker/entrypoint.sh /entrypoint.sh

RUN chmod +x /entrypoint.sh

USER www-data

# Set the working directory
WORKDIR /var/www/html

# Expose port 80
EXPOSE 80

CMD ["apache2-foreground"]

ENTRYPOINT ["/entrypoint.sh"]
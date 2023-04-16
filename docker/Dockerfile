# Apache
FROM php:8.1-apache

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libicu-dev \
    libzip-dev \
    gnupg2 \
    curl

RUN docker-php-ext-install \
    intl \
    zip \
    pdo_mysql \
    mysqli

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

#
COPY docker/apache/apache.conf /etc/apache2/sites-enabled/000-default.conf
COPY docker/php/php.ini /etc/php/
COPY docker/entrypoint.sh /entrypoint.sh

RUN chmod +x /entrypoint.sh

# Match host user id and group id
RUN usermod -u 1000 www-data
RUN groupmod -g 1000 www-data
RUN chown -R www-data:www-data /var/www
USER www-data

# Set the working directory
WORKDIR /var/www/html

ENTRYPOINT ["/entrypoint.sh"]

CMD ["apache2-foreground"]

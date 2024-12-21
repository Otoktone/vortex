# Apache
FROM php:8.1-apache

# Install dependencies
RUN apt-get update && apt-get install -y \
    # Distributed version control system used for managing the application's source code
    git \
    # Utility for extracting compressed files
    unzip \
    # Development libraries for Unicode and international character set support
    libicu-dev \
    # Development libraries for handling compressed files
    libzip-dev \
    # Tool for managing cryptographic keys
    gnupg2 \
    # Tool for making HTTP requests
    curl \
    # Utility for converting file line endings between DOS and Unix formats
    dos2unix

RUN docker-php-ext-install \
    # Extension for internationalization and Unicode character support
    intl \
    zip \
    # Extension for connecting to a MySQL database using PDO
    pdo_mysql \
    # Improved extension for connecting to a MySQL database
    mysqli

# Enable Apache mod_rewrite
# URL rewriting required by web applications
RUN a2enmod rewrite

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHPUnit using Composer
# RUN composer global require phpunit/phpunit

# Make PHPUnit executable globally
# RUN ln -s ~/.composer/vendor/bin/phpunit /usr/local/bin/phpunit

# Copy specific configuration files from the host machine to the corresponding locations inside the Docker container
COPY docker/apache/apache.conf /etc/apache2/sites-enabled/000-default.conf
COPY docker/php/php.ini /etc/php/
COPY docker/entrypoint.sh /entrypoint.sh

# Script to ensure consistent line endings
RUN dos2unix /entrypoint.sh && chmod +x /entrypoint.sh

# Modify the www-data user inside the container to match the user ID and group ID of the host machine
RUN usermod -u 1000 www-data
RUN groupmod -g 1000 www-data
RUN chown -R www-data:www-data /var/www
USER www-data

# Sets the working directory inside the container
WORKDIR /var/www/html

ENTRYPOINT ["/entrypoint.sh"]

# Starts the Apache web server in the foreground
CMD ["apache2-foreground"]

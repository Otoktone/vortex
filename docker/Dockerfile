# Apache
FROM php:8.1-apache

RUN a2enmod rewrite

RUN apt-get update \
  && apt-get install -y libzip-dev git wget --no-install-recommends \
  && apt-get clean \
  && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN docker-php-ext-install pdo mysqli pdo_mysql zip;

# Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY docker/apache.conf /etc/apache2/sites-enabled/000-default.conf

# Copy existing application directory permissions
COPY --chown=www:www . /var/www/html/

WORKDIR /var/www/html/

CMD ["apache2-foreground"]
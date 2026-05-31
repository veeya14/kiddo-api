FROM php:8.2-apache

# Install extension yang dibutuhkan CodeIgniter
RUN apt-get update && apt-get install -y \
    libicu-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-install intl pdo_mysql zip

# Aktifkan rewrite
RUN a2enmod rewrite

# Copy project
COPY . /var/www/html/

# Ubah document root ke public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf

# Permission writable
RUN chown -R www-data:www-data /var/www/html/writable

EXPOSE 80
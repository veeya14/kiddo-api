FROM php:8.2-apache

# Install sistem yang dibutuhkan CodeIgniter
RUN apt-get update && apt-get install -y libicu-dev libzip-dev zip unzip \
    && docker-php-ext-install intl pdo_mysql zip

# Mengaktifkan mod_rewrite untuk URL friendly CodeIgniter
RUN a2enmod rewrite

# Mengarahkan Web Root ke folder public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.docker-php.conf

# Copy file project
COPY . /var/www/html/
# Beri izin akses
RUN chown -R www-data:www-data /var/www/html/writable
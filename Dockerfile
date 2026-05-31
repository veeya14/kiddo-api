FROM php:8.2-cli

WORKDIR /app

# Install dependency sistem
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libicu-dev \
    libzip-dev \
    && docker-php-ext-install intl mysqli pdo_mysql zip

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy project
COPY . .

# Install dependency CodeIgniter
RUN composer install --no-dev --optimize-autoloader

# Permission
RUN chmod -R 777 writable

EXPOSE 8080

CMD ["sh", "-c", "php spark serve --host=0.0.0.0 --port=${PORT:-8080}"]
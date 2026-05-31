FROM php:8.2-cli

WORKDIR /app

# Install extension yang dibutuhkan CodeIgniter 4
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libicu-dev \
    libzip-dev \
    && docker-php-ext-install intl pdo_mysql zip

# Copy seluruh project
COPY . .

# Permission folder writable
RUN chmod -R 777 writable

# Railway akan memberikan PORT otomatis
EXPOSE 8080

CMD php spark serve --host=0.0.0.0 --port=${PORT:-8080}
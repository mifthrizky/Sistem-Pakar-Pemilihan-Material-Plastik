# Gunakan image PHP dengan server Apache
FROM php:8.2-apache

# Install dependensi sistem, termasuk library dev untuk cURL
RUN apt-get update && apt-get install -y \
    npm \
    curl \
    libcurl4-openssl-dev \
    && docker-php-ext-install curl

# Salin semua file dari folder frontend ke root direktori web server di container
COPY . /var/www/html/

# Set direktori kerja
WORKDIR /var/www/html/

# Install dependensi (tailwindcss) dari package.json
RUN npm install
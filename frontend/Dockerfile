# Image PHP dengan server Apache
FROM php:8.2-apache

# Install dependensi sistem
RUN apt-get update && apt-get install -y \
    npm \
    curl \
    libcurl4-openssl-dev \
    && docker-php-ext-install curl

# Salin file ke direktori web server
COPY . /var/www/html/

# Set hak akses agar Apache bisa membaca & mengeksekusi file
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Set direktori kerja
WORKDIR /var/www/html/

# Mengubah DocumentRoot default Apache agar menunjuk ke subfolder /frontend
RUN sed -i 's!/var/www/html!/var/www/html/frontend!g' /etc/apache2/sites-available/000-default.conf

EXPOSE 80

# Install dependensi Node.js (tailwind)
RUN npm install

# Aktifkan mod_rewrite (opsional kalau pakai routing)
RUN a2enmod rewrite

# Pastikan konfigurasi Apache mengizinkan akses
RUN echo '<Directory /var/www/html/>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' > /etc/apache2/conf-available/docker-allow.conf \
    && a2enconf docker-allow

FROM php:8.2-apache

# Install ekstensi yang dibutuhkan
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Copy semua file ke direktori Apache
COPY . /var/www/html/

# Aktifkan mod_rewrite Apache untuk .htaccess (jika perlu)
RUN a2enmod rewrite

EXPOSE 80

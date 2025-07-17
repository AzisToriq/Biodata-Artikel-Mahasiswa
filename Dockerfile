FROM php:8.2-apache

# Aktifkan ekstensi mysqli untuk koneksi database
RUN docker-php-ext-install mysqli

# Salin semua file ke direktori Apache di dalam container
COPY . /var/www/html/

EXPOSE 80

# Gunakan PHP 8.4 Apache
FROM php:8.4-apache

# 1. Gunakan script installer sakti
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

# 2. Install extension (Hapus imagick & pdo_mysql, Tambah pdo_sqlite)
RUN install-php-extensions \
    pdo_sqlite \
    bcmath \
    gd \
    intl \
    zip \
    opcache

# 3. Konfigurasi Apache (Mod Rewrite & Document Root)
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN a2enmod rewrite
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf

RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf

# 4. Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 5. Set Working Directory
WORKDIR /var/www/html

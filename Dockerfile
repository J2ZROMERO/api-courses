FROM php:8.2-apache

# Instala extensiones y librerías necesarias para Laravel
RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev libpq-dev zip libonig-dev libxml2-dev libicu-dev \
  && docker-php-ext-install \
    pdo pdo_pgsql zip \
    mbstring xml bcmath intl \
  && a2enmod rewrite

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
COPY . .

# 🔧 Copia el script de entrada al sistema
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Ajusta el DocumentRoot de Apache
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf \
  && echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Permisos para storage y cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
  && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Dependencias de Composer
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

EXPOSE 80
CMD ["docker-entrypoint.sh"]
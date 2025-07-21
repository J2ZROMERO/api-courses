FROM php:8.2-apache

# Instala extensiones necesarias para Laravel y PostgreSQL
RUN apt-get update && apt-get install -y \
    git unzip curl libzip-dev libpq-dev zip \
    && docker-php-ext-install pdo pdo_pgsql zip

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Establece el directorio de trabajo
WORKDIR /var/www/html

# Copia el proyecto Laravel al contenedor
COPY . .

# Establece la raíz pública en /public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Configura permisos
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# Instala dependencias de Laravel
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Expone el puerto estándar HTTP
EXPOSE 80

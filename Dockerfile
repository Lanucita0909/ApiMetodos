FROM php:8.1-apache

# Instalar extensiones PHP necesarias
RUN docker-php-ext-install pdo pdo_mysql

# Habilitar mod_rewrite para Apache
RUN a2enmod rewrite

# Copiar los archivos del proyecto
COPY . /var/www/html/

# Establecer permisos adecuados
RUN chown -R www-data:www-data /var/www/html/

# Configurar Virtual Host
COPY docker/000-default.conf /etc/apache2/sites-available/000-default.conf

# Exponer puerto 80
EXPOSE 80
#imagen de php
FROM php:8.2-apache


#habilitamos .htaccess
RUN a2enmod rewrite

#directorio de trabajo
WORKDIR /var/www/html

# copiar archivos
COPY ./index.php /var/www/html

# permisos del directorio
RUN chown -R www-data:www-data /var/www/html
RUN docker-php-ext-install pdo pdo_mysql

# puerto expuesto
EXPOSE 80

# arrancar servidor
CMD ["apache2-foreground"]
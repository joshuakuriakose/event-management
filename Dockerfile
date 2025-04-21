FROM php:8.1-apache

RUN docker-php-ext-install mysqli

# Fix permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Copy code after permissions are fixed
COPY . /var/www/html/

EXPOSE 80

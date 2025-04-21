FROM php:8.1-apache

# Install PHP extension
RUN docker-php-ext-install mysqli

# Copy your code
COPY . /var/www/html/

# Set ownership and permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Optional: Add Apache config to allow access
RUN echo '<Directory /var/www/html/>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' > /etc/apache2/conf-available/allow-access.conf \
    && a2enconf allow-access \
    && service apache2 reload

EXPOSE 80

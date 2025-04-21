FROM php:8.1-apache

# Install PHP extension
RUN docker-php-ext-install mysqli

# Copy project files
COPY . /var/www/html/

# Set correct permissions
RUN chown -R www-data:www-data /var/www/html && chmod -R 755 /var/www/html

# Create Apache config file
RUN echo '<Directory /var/www/html/>\n\
    Options Indexes FollowSymLinks\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>' > /etc/apache2/conf-available/allow-access.conf \
    && a2enconf allow-access

# Enable .htaccess support (if needed)
RUN a2enmod rewrite

# Don't run "service apache2 reload" here — it's not needed during build

EXPOSE 80

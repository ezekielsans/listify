FROM php:8.2-apache

# Install the PDO MySQL extension
RUN docker-php-ext-install pdo pdo_mysql

# Copy the PHP code into the container
COPY . /var/www/html/

COPY php.ini 

# Set permissions for Apache
RUN chown -R www-data:www-data /var/www/html

# Expose the port the service will run on
EXPOSE 80
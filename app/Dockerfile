# Use the official PHP image with Apache
FROM php:8.1-apache

# Enable Apache mod_rewrite for URL rewriting (to implement traditional routing like controller/action in URL)
RUN a2enmod rewrite

# Install necessary PHP extensions (e.g., pdo_pgsql for PostgreSQL)
RUN apt-get update && apt-get install -y libpq-dev && docker-php-ext-install pdo pdo_pgsql

# Copy the project files into the container
COPY . /var/www/html/

# Set proper permissions for the web root
RUN chown -R www-data:www-data /var/www/html/

# Expose port 80 for web traffic
EXPOSE 80

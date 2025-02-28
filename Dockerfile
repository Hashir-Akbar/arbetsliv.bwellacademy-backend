# Use PHP 8.2 FPM base image
FROM wyveo/nginx-php-fpm:php82

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . /var/www/html

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage

# Expose port 80 for Heroku
EXPOSE 80

# Start the application
CMD ["nginx", "-g", "daemon off;"]

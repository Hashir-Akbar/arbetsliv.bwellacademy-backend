# Use PHP 8.2 FPM base image
FROM  wyveo/nginx-php-fpm:php82
COPY . /var/www/html

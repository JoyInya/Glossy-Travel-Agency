# Use the official PHP image with Apache
FROM php:8.1-apache

# Copy your project files into the Apache server's root directory
COPY . /var/www/html/

# Expose port 80 for web traffic
EXPOSE 80

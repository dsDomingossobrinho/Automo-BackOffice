# Automo BackOffice Dockerfile
FROM php:8.2-apache

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    dnsutils \
    iputils-ping \
    netcat-traditional \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    libzip-dev \
    libpq-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql mbstring exif pcntl bcmath gd zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Configure Apache
RUN a2enmod rewrite
RUN a2enmod headers
RUN a2enmod expires
RUN a2enmod deflate

# Copy Apache configuration
COPY docker/apache-simple.conf /etc/apache2/sites-available/000-default.conf
COPY docker/apache-global.conf /etc/apache2/conf-available/automo-global.conf
RUN a2enconf automo-global

# Copy network script
COPY docker/ensure-network.sh /usr/local/bin/ensure-network.sh
RUN chmod +x /usr/local/bin/ensure-network.sh

# Copy application files
COPY . /var/www/html/

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 755 /var/www/html/public \
    && chmod -R 755 /var/www/html/public/assets

# Create necessary directories
RUN mkdir -p /var/www/html/storage/logs /var/www/html/public/uploads \
    && chown -R www-data:www-data /var/www/html/storage \
    && chown -R www-data:www-data /var/www/html/public/uploads \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/public/uploads

# Verify assets directory exists
RUN ls -la /var/www/html/public/assets/ || echo "Assets directory not found"

# Expose port
EXPOSE 80

# Health check
HEALTHCHECK --interval=30s --timeout=3s --start-period=5s --retries=3 \
    CMD curl -f http://localhost/login || exit 1

# Start Apache
CMD ["apache2-foreground"]
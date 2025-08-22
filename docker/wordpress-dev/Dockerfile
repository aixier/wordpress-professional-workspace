# WordPress Development Environment with WP-CLI
# Based on official WordPress image with additional development tools
FROM wordpress:6.8.2-php8.2-apache

LABEL maintainer="FSO Team <dev@fsotool.com>"
LABEL description="WordPress development environment with WP-CLI, debugging tools, and optimizations"
LABEL version="1.0.0"

# Install system dependencies
RUN apt-get update && apt-get install -y \
    # Basic tools
    curl \
    wget \
    unzip \
    git \
    vim \
    nano \
    # Image processing
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libwebp-dev \
    # Database tools
    default-mysql-client \
    # Development tools
    node-less \
    # Network tools
    iputils-ping \
    telnet \
    # Clean up
    && rm -rf /var/lib/apt/lists/*

# Configure PHP extensions for better WordPress support
RUN docker-php-ext-configure gd \
        --with-freetype \
        --with-jpeg \
        --with-webp \
    && docker-php-ext-install -j$(nproc) \
        gd \
        exif \
        bcmath

# Install WP-CLI
RUN curl -o /usr/local/bin/wp https://github.com/wp-cli/wp-cli/releases/download/v2.10.0/wp-cli-2.10.0.phar \
    && chmod +x /usr/local/bin/wp

# Verify WP-CLI installation
RUN wp --info --allow-root

# Install Composer for PHP dependency management
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Create wp-cli.yml configuration
COPY wp-cli.yml /var/www/html/wp-cli.yml

# PHP configuration optimizations for development
COPY php.ini /usr/local/etc/php/conf.d/wordpress-dev.ini

# Custom Apache configuration
COPY apache-dev.conf /etc/apache2/sites-available/000-default.conf

# Enable Apache modules for development
RUN a2enmod rewrite headers expires deflate

# Create directories for logs and uploads
RUN mkdir -p /var/www/html/wp-content/uploads \
    && mkdir -p /var/log/wordpress \
    && chown -R www-data:www-data /var/www/html/wp-content \
    && chown -R www-data:www-data /var/log/wordpress

# Install useful WP-CLI packages
RUN wp package install wp-cli/doctor-command --allow-root || true
RUN wp package install wp-cli/profile-command --allow-root || true

# Copy initialization scripts
COPY scripts/ /usr/local/bin/
RUN chmod +x /usr/local/bin/*.sh

# Set working directory
WORKDIR /var/www/html

# Health check
HEALTHCHECK --interval=30s --timeout=3s --start-period=5s --retries=3 \
    CMD curl -f http://localhost/ || exit 1

# Expose port
EXPOSE 80

# Custom entrypoint that includes WP-CLI setup
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["apache2-foreground"]
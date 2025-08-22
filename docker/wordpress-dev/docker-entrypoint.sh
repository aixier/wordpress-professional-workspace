#!/bin/bash

# Custom WordPress Development Docker Entrypoint
# Extends the official WordPress entrypoint with development features

set -e

echo "🚀 Starting WordPress Development Environment..."

# Source the original WordPress entrypoint
source /usr/local/bin/docker-entrypoint.sh

# Custom development setup function
wordpress_dev_init() {
    echo "⚙️  Initializing WordPress development environment..."
    
    # Wait for database if specified
    if [ -n "$WORDPRESS_DB_HOST" ]; then
        echo "⏳ Waiting for database at $WORDPRESS_DB_HOST..."
        
        # Extract host and port
        DB_HOST=$(echo $WORDPRESS_DB_HOST | cut -d: -f1)
        DB_PORT=$(echo $WORDPRESS_DB_HOST | cut -d: -f2)
        DB_PORT=${DB_PORT:-3306}
        
        # Wait for database connection
        while ! mysqladmin ping -h"$DB_HOST" -P"$DB_PORT" --silent; do
            sleep 1
        done
        
        echo "✅ Database connection established"
    fi
    
    # Set correct permissions
    echo "🔐 Setting file permissions..."
    chown -R www-data:www-data /var/www/html/wp-content/ 2>/dev/null || true
    chmod -R 755 /var/www/html/wp-content/ 2>/dev/null || true
    
    # Create log directory
    mkdir -p /var/log/wordpress
    chown www-data:www-data /var/log/wordpress
    
    # Auto-setup WordPress if environment variables are provided
    if [ "$WORDPRESS_AUTO_SETUP" = "true" ]; then
        echo "🏗️  Auto-setup enabled, running complete WordPress installation..."
        
        # Run complete setup script after Apache starts (in background)
        (
            sleep 10  # Wait for Apache to be ready
            
            # Check if WordPress is already installed
            if wp core is-installed --allow-root 2>/dev/null; then
                echo "✅ WordPress is already installed"
            else
                echo "📦 Installing WordPress..."
                
                # Wait for database to be ready
                until wp db check --allow-root 2>/dev/null; do
                    echo "⏳ Waiting for database..."
                    sleep 3
                done
                
                # Install WordPress core
                wp core install \
                    --url="${WORDPRESS_URL:-http://localhost}" \
                    --title="${WORDPRESS_TITLE:-My WordPress Site}" \
                    --admin_user="${WORDPRESS_ADMIN_USER:-admin}" \
                    --admin_password="${WORDPRESS_ADMIN_PASSWORD:-admin123}" \
                    --admin_email="${WORDPRESS_ADMIN_EMAIL:-admin@example.com}" \
                    --skip-email \
                    --allow-root
                
                echo "✅ WordPress core installed"
                
                # Install plugins if specified
                if [ -n "${WORDPRESS_PLUGINS:-}" ]; then
                    IFS=',' read -ra PLUGINS <<< "$WORDPRESS_PLUGINS"
                    for plugin in "${PLUGINS[@]}"; do
                        echo "📦 Installing plugin: $plugin"
                        wp plugin install "$plugin" --activate --allow-root || true
                    done
                fi
                
                # Activate theme if specified
                if [ -n "${WORDPRESS_THEME:-}" ]; then
                    echo "🎨 Activating theme: ${WORDPRESS_THEME}"
                    wp theme activate "${WORDPRESS_THEME}" --allow-root || true
                fi
                
                echo "🎉 WordPress auto-setup complete!"
            fi
        ) &
    elif [ "$WORDPRESS_QUICK_SETUP" = "true" ]; then
        echo "🏗️  Quick setup enabled, running basic WordPress installation..."
        
        # Run basic setup script
        (
            sleep 10  # Wait for Apache to be ready
            /usr/local/bin/wp-dev-setup.sh
        ) &
    fi
    
    echo "🎉 WordPress development environment ready!"
    echo "📝 Useful commands:"
    echo "   wp-dev-setup.sh - Setup fresh WordPress installation"
    echo "   wp-reset.sh - Reset WordPress to clean state"
    echo "   wp-backup.sh - Create backup of current state"
    echo "   wp --help - WP-CLI help"
}

# Development environment initialization
if [ "$1" = 'apache2-foreground' ]; then
    wordpress_dev_init
fi

# Execute the original command
exec "$@"
#!/bin/bash
set -euo pipefail

echo "🚀 Starting WordPress with auto-initialization support..."

# Function to setup WordPress
setup_wordpress() {
    echo "⏳ Waiting for WordPress files to be ready..."
    
    # Wait for WordPress files
    until [ -f /var/www/html/wp-config.php ] || [ -f /var/www/html/wp-config-sample.php ]; do
        sleep 2
    done
    
    echo "⏳ Waiting for database connection..."
    
    # Wait for database
    until wp db check --allow-root 2>/dev/null; do
        sleep 3
    done
    
    echo "✅ Database connection established"
    
    # Check if WordPress is installed
    if ! wp core is-installed --allow-root 2>/dev/null; then
        echo "📦 Installing WordPress..."
        
        wp core install \
            --url="${WORDPRESS_URL:-http://localhost}" \
            --title="${WORDPRESS_TITLE:-My WordPress Site}" \
            --admin_user="${WORDPRESS_ADMIN_USER:-admin}" \
            --admin_password="${WORDPRESS_ADMIN_PASSWORD:-admin123}" \
            --admin_email="${WORDPRESS_ADMIN_EMAIL:-admin@example.com}" \
            --skip-email \
            --allow-root
        
        echo "✅ WordPress installed successfully!"
        
        # Install plugins if specified
        if [ -n "${WORDPRESS_PLUGINS:-}" ]; then
            IFS=',' read -ra PLUGINS <<< "$WORDPRESS_PLUGINS"
            for plugin in "${PLUGINS[@]}"; do
                plugin=$(echo "$plugin" | xargs)  # Trim whitespace
                echo "📦 Installing plugin: $plugin"
                wp plugin install "$plugin" --activate --allow-root || true
            done
        fi
        
        # Activate theme if specified
        if [ -n "${WORDPRESS_THEME:-}" ]; then
            echo "🎨 Activating theme: ${WORDPRESS_THEME}"
            wp theme activate "${WORDPRESS_THEME}" --allow-root || true
        fi
        
        # Set locale if specified
        if [ -n "${WORDPRESS_LOCALE:-}" ] && [ "${WORDPRESS_LOCALE}" != "en_US" ]; then
            echo "🌐 Setting locale to: ${WORDPRESS_LOCALE}"
            wp language core install "${WORDPRESS_LOCALE}" --allow-root || true
            wp site switch-language "${WORDPRESS_LOCALE}" --allow-root || true
        fi
        
        echo "🎉 WordPress setup complete!"
    else
        echo "✅ WordPress is already installed"
    fi
}

# Run auto-setup in background if enabled
if [ "${WORDPRESS_AUTO_SETUP:-false}" = "true" ]; then
    (
        sleep 15  # Give Apache time to start
        setup_wordpress
    ) &
fi

# Run the original WordPress entrypoint
exec /usr/local/bin/docker-entrypoint.sh "$@"
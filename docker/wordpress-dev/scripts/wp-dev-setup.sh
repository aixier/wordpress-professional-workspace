#!/bin/bash

# WordPress Development Environment Setup Script
# This script initializes a fresh WordPress installation for development

set -e

echo "🚀 Starting WordPress Development Environment Setup..."

# Configuration
DB_NAME=${WORDPRESS_DB_NAME:-wordpress}
DB_USER=${WORDPRESS_DB_USER:-wordpress}  
DB_PASSWORD=${WORDPRESS_DB_PASSWORD:-wordpress}
DB_HOST=${WORDPRESS_DB_HOST:-mysql:3306}

WP_TITLE=${WORDPRESS_TITLE:-"WordPress Development Site"}
WP_ADMIN_USER=${WORDPRESS_ADMIN_USER:-admin}
WP_ADMIN_PASSWORD=${WORDPRESS_ADMIN_PASSWORD:-admin123}
WP_ADMIN_EMAIL=${WORDPRESS_ADMIN_EMAIL:-admin@localhost.local}
WP_URL=${WORDPRESS_URL:-http://localhost}
WP_LOCALE=${WORDPRESS_LOCALE:-zh_CN}

# Wait for database to be ready
echo "⏳ Waiting for database connection..."
until wp db check --allow-root 2>/dev/null; do
    echo "Database not ready, waiting..."
    sleep 2
done
echo "✅ Database connection established"

# Check if WordPress is already installed
if wp core is-installed --allow-root 2>/dev/null; then
    echo "ℹ️  WordPress is already installed"
    exit 0
fi

# Download WordPress core if not exists
if [ ! -f wp-config.php ]; then
    echo "📥 Downloading WordPress core..."
    wp core download --locale=$WP_LOCALE --allow-root
fi

# Create wp-config.php
echo "⚙️  Creating wp-config.php..."
wp config create \
    --dbname=$DB_NAME \
    --dbuser=$DB_USER \
    --dbpass=$DB_PASSWORD \
    --dbhost=$DB_HOST \
    --locale=$WP_LOCALE \
    --extra-php < /dev/stdin << 'EOF'
// Development environment settings
define('WP_DEBUG', true);
define('WP_DEBUG_LOG', true);
define('WP_DEBUG_DISPLAY', false);
define('SCRIPT_DEBUG', true);
define('SAVEQUERIES', true);

// Security settings for development
define('DISALLOW_FILE_EDIT', false);
define('AUTOMATIC_UPDATER_DISABLED', true);

// Performance settings
define('WP_MEMORY_LIMIT', '512M');
define('WP_MAX_MEMORY_LIMIT', '512M');

// Cache settings
define('WP_CACHE', false);

// SSL settings
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
    $_SERVER['HTTPS'] = 'on';
    define('FORCE_SSL_ADMIN', true);
}

// Environment
define('WP_ENVIRONMENT_TYPE', 'development');
EOF
    --allow-root

# Install WordPress
echo "🏗️  Installing WordPress..."
wp core install \
    --url=$WP_URL \
    --title="$WP_TITLE" \
    --admin_user=$WP_ADMIN_USER \
    --admin_password=$WP_ADMIN_PASSWORD \
    --admin_email=$WP_ADMIN_EMAIL \
    --skip-email \
    --allow-root

# Install language pack
echo "🌐 Installing language pack..."
wp language core install $WP_LOCALE --activate --allow-root || echo "Language pack installation failed, continuing..."

# Update permalinks
echo "🔗 Setting up permalinks..."
wp rewrite structure '/%postname%/' --allow-root
wp rewrite flush --allow-root

# Install and activate useful development plugins
echo "🔌 Installing development plugins..."
wp plugin install --activate --allow-root \
    query-monitor \
    debug-bar \
    log-deprecated-notices \
    user-switching \
    duplicate-post || echo "Some plugins failed to install, continuing..."

# Install classic editor (for compatibility)
wp plugin install classic-editor --activate --allow-root || echo "Classic editor installation failed, continuing..."

# Create development content
echo "📝 Creating sample content..."

# Create sample pages
wp post create --post_type=page --post_title="Home" --post_status=publish --allow-root || true
wp post create --post_type=page --post_title="About" --post_status=publish --allow-root || true
wp post create --post_type=page --post_title="Contact" --post_status=publish --allow-root || true

# Create sample posts
wp post create --post_title="Welcome to WordPress Development" --post_content="This is a sample post for development." --post_status=publish --allow-root || true

# Create main navigation menu
echo "🧭 Creating navigation menu..."
wp menu create "Main Menu" --allow-root || true
wp menu item add-post main-menu 2 --allow-root || true  # Home page
wp menu item add-post main-menu 3 --allow-root || true  # About page
wp menu item add-post main-menu 4 --allow-root || true  # Contact page
wp menu location assign main-menu primary --allow-root || true

# Set timezone
wp option update timezone_string 'Asia/Shanghai' --allow-root

# Configure media settings
wp option update uploads_use_yearmonth_folders 1 --allow-root
wp option update thumbnail_size_w 150 --allow-root
wp option update thumbnail_size_h 150 --allow-root
wp option update medium_size_w 300 --allow-root
wp option update medium_size_h 300 --allow-root
wp option update large_size_w 1024 --allow-root
wp option update large_size_h 1024 --allow-root

# Configure discussion settings
wp option update default_pingback_flag 0 --allow-root
wp option update default_ping_status 0 --allow-root
wp option update default_comment_status 0 --allow-root

# Clean up default content
wp post delete 1 --force --allow-root || true  # Delete "Hello World" post
wp post delete 2 --force --allow-root || true  # Delete sample page

# Set correct file permissions
chown -R www-data:www-data /var/www/html/wp-content/
chmod -R 755 /var/www/html/wp-content/

echo ""
echo "🎉 WordPress Development Environment Setup Complete!"
echo ""
echo "📊 Site Information:"
echo "   URL: $WP_URL"
echo "   Admin User: $WP_ADMIN_USER"
echo "   Admin Password: $WP_ADMIN_PASSWORD"
echo "   Admin Email: $WP_ADMIN_EMAIL"
echo ""
echo "🛠️  Development Tools Installed:"
echo "   - Query Monitor (performance debugging)"
echo "   - Debug Bar (debug information)"
echo "   - Log Deprecated Notices (deprecation warnings)"
echo "   - User Switching (easy user testing)"
echo "   - Duplicate Post (content duplication)"
echo ""
echo "📝 Next Steps:"
echo "   1. Visit $WP_URL to see your site"
echo "   2. Visit $WP_URL/wp-admin to access admin dashboard"
echo "   3. Install your themes and additional plugins"
echo "   4. Start developing!"
echo ""
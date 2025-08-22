#!/bin/bash

# Complete WordPress CLI Setup Script
# 完全通过CLI初始化WordPress，无需web界面配置

set -e

echo "🚀 Starting Complete WordPress CLI Setup..."

# Configuration (can be overridden by environment variables)
DB_NAME=${WORDPRESS_DB_NAME:-wordpress}
DB_USER=${WORDPRESS_DB_USER:-wordpress}
DB_PASSWORD=${WORDPRESS_DB_PASSWORD:-wordpress}
DB_HOST=${WORDPRESS_DB_HOST:-mysql:3306}

WP_TITLE=${WORDPRESS_TITLE:-"WordPress Site"}
WP_ADMIN_USER=${WORDPRESS_ADMIN_USER:-admin}
WP_ADMIN_PASSWORD=${WORDPRESS_ADMIN_PASSWORD:-admin123}
WP_ADMIN_EMAIL=${WORDPRESS_ADMIN_EMAIL:-admin@example.com}
WP_URL=${WORDPRESS_URL:-http://localhost}
WP_LOCALE=${WORDPRESS_LOCALE:-zh_CN}

# Theme and plugin settings
ACTIVE_THEME=${WORDPRESS_THEME:-twentytwentyfour}
INSTALL_PLUGINS=${WORDPRESS_PLUGINS:-""}

echo "📋 Configuration:"
echo "  Site URL: $WP_URL"
echo "  Title: $WP_TITLE"
echo "  Admin User: $WP_ADMIN_USER"
echo "  Language: $WP_LOCALE"
echo "  Theme: $ACTIVE_THEME"
echo ""

# Wait for database
echo "⏳ Waiting for database connection..."
until wp db check --allow-root 2>/dev/null; do
    echo "Database not ready, waiting..."
    sleep 2
done
echo "✅ Database connection established"

# Check if WordPress is already installed
if wp core is-installed --allow-root 2>/dev/null; then
    echo "ℹ️  WordPress is already installed, skipping installation"
else
    echo "🏗️  Installing WordPress..."

    # Download WordPress core if not exists
    if [ ! -f wp-config.php ]; then
        echo "📥 Downloading WordPress core..."
        wp core download --locale=$WP_LOCALE --allow-root
    fi

    # Create wp-config.php with complete configuration
    echo "⚙️  Creating wp-config.php..."
    wp config create \
        --dbname=$DB_NAME \
        --dbuser=$DB_USER \
        --dbpass=$DB_PASSWORD \
        --dbhost=$DB_HOST \
        --locale=$WP_LOCALE \
        --extra-php < /dev/stdin << 'EOF'
// Security keys (auto-generated)
define('AUTH_KEY',         'put your unique phrase here');
define('SECURE_AUTH_KEY',  'put your unique phrase here');
define('LOGGED_IN_KEY',    'put your unique phrase here');
define('NONCE_KEY',        'put your unique phrase here');
define('AUTH_SALT',        'put your unique phrase here');
define('SECURE_AUTH_SALT', 'put your unique phrase here');
define('LOGGED_IN_SALT',   'put your unique phrase here');
define('NONCE_SALT',       'put your unique phrase here');

// WordPress table prefix
$table_prefix = 'wp_';

// WordPress debugging (for development)
define('WP_DEBUG', false);
define('WP_DEBUG_LOG', false);
define('WP_DEBUG_DISPLAY', false);

// WordPress memory limit
define('WP_MEMORY_LIMIT', '512M');

// Disable file editing in admin
define('DISALLOW_FILE_EDIT', true);

// Auto-updates
define('AUTOMATIC_UPDATER_DISABLED', false);
define('WP_AUTO_UPDATE_CORE', true);

// SSL settings
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
    $_SERVER['HTTPS'] = 'on';
    define('FORCE_SSL_ADMIN', true);
}

// Multisite (disabled by default)
// define('WP_ALLOW_MULTISITE', true);

/* That's all, stop editing! Happy publishing. */
if ( ! defined( 'ABSPATH' ) ) {
    define( 'ABSPATH', __DIR__ . '/' );
}
require_once ABSPATH . 'wp-settings.php';
EOF
        --allow-root

    # Install WordPress with admin user
    echo "🏗️  Installing WordPress with admin user..."
    wp core install \
        --url=$WP_URL \
        --title="$WP_TITLE" \
        --admin_user=$WP_ADMIN_USER \
        --admin_password=$WP_ADMIN_PASSWORD \
        --admin_email=$WP_ADMIN_EMAIL \
        --skip-email \
        --allow-root

    echo "✅ WordPress installation completed"
fi

# Install and activate language pack
echo "🌐 Setting up language..."
if [ "$WP_LOCALE" != "en_US" ]; then
    wp language core install $WP_LOCALE --activate --allow-root || echo "Language pack installation failed, continuing..."
fi

# Set timezone
echo "⏰ Setting timezone..."
wp option update timezone_string 'Asia/Shanghai' --allow-root

# Configure basic WordPress settings
echo "⚙️  Configuring WordPress settings..."

# General settings
wp option update blogdescription "Professional WordPress site" --allow-root
wp option update users_can_register 0 --allow-root
wp option update default_role 'subscriber' --allow-root

# Reading settings  
wp option update show_on_front 'posts' --allow-root
wp option update posts_per_page 10 --allow-root

# Discussion settings
wp option update default_pingback_flag 0 --allow-root
wp option update default_ping_status 0 --allow-root
wp option update default_comment_status 0 --allow-root
wp option update require_name_email 1 --allow-root
wp option update comment_registration 1 --allow-root
wp option update comment_moderation 1 --allow-root

# Media settings
wp option update uploads_use_yearmonth_folders 1 --allow-root
wp option update thumbnail_size_w 150 --allow-root
wp option update thumbnail_size_h 150 --allow-root
wp option update medium_size_w 300 --allow-root
wp option update medium_size_h 300 --allow-root
wp option update large_size_w 1024 --allow-root
wp option update large_size_h 1024 --allow-root

# Permalink structure
echo "🔗 Setting up permalinks..."
wp rewrite structure '/%postname%/' --allow-root
wp rewrite flush --allow-root

# Theme setup
echo "🎨 Setting up theme..."
if [ "$ACTIVE_THEME" != "twentytwentyfour" ]; then
    # Install custom theme if specified
    if wp theme is-installed $ACTIVE_THEME --allow-root; then
        wp theme activate $ACTIVE_THEME --allow-root
        echo "✅ Activated theme: $ACTIVE_THEME"
    else
        echo "⚠️  Theme $ACTIVE_THEME not found, using default theme"
        wp theme activate twentytwentyfour --allow-root
    fi
else
    wp theme activate twentytwentyfour --allow-root
fi

# Clean up default content
echo "🧹 Cleaning up default content..."
wp post delete 1 --force --allow-root 2>/dev/null || true  # Hello World post
wp post delete 2 --force --allow-root 2>/dev/null || true  # Sample page
wp comment delete 1 --force --allow-root 2>/dev/null || true  # Default comment

# Install and activate plugins
if [ -n "$INSTALL_PLUGINS" ]; then
    echo "🔌 Installing plugins..."
    IFS=',' read -ra PLUGINS <<< "$INSTALL_PLUGINS"
    for plugin in "${PLUGINS[@]}"; do
        plugin=$(echo $plugin | xargs)  # trim whitespace
        if [ -n "$plugin" ]; then
            echo "Installing plugin: $plugin"
            wp plugin install $plugin --activate --allow-root || echo "Failed to install $plugin, continuing..."
        fi
    done
fi

# Create a welcome post
echo "📝 Creating welcome content..."
wp post create \
    --post_title="Welcome to Your WordPress Site" \
    --post_content="<h2>Your WordPress site is ready!</h2><p>This site has been automatically configured and is ready for use. You can:</p><ul><li>Log in to the admin panel at <a href=\"$WP_URL/wp-admin\">$WP_URL/wp-admin</a></li><li>Start creating content</li><li>Customize your theme</li><li>Install additional plugins</li></ul><p>Admin credentials:<br>Username: <strong>$WP_ADMIN_USER</strong><br>Password: <strong>$WP_ADMIN_PASSWORD</strong></p>" \
    --post_status=publish \
    --post_type=post \
    --allow-root

# Create basic pages
echo "📄 Creating basic pages..."
wp post create \
    --post_type=page \
    --post_title="About" \
    --post_content="<h2>About Us</h2><p>This is the about page. You can edit this content in the WordPress admin.</p>" \
    --post_status=publish \
    --allow-root

wp post create \
    --post_type=page \
    --post_title="Contact" \
    --post_content="<h2>Contact Us</h2><p>Get in touch with us through this contact page.</p>" \
    --post_status=publish \
    --allow-root

# Create and assign main menu
echo "🧭 Creating navigation menu..."
MENU_ID=$(wp menu create "Main Menu" --porcelain --allow-root)
if [ -n "$MENU_ID" ]; then
    # Add pages to menu
    wp menu item add-post $MENU_ID $(wp post list --post_type=page --field=ID --allow-root | head -1) --allow-root 2>/dev/null || true
    wp menu item add-post $MENU_ID $(wp post list --post_type=page --field=ID --allow-root | tail -1) --allow-root 2>/dev/null || true
    
    # Assign menu to primary location (if theme supports it)
    wp menu location assign $MENU_ID primary --allow-root 2>/dev/null || echo "Primary menu location not available in current theme"
fi

# Set correct file permissions
echo "🔐 Setting file permissions..."
chown -R www-data:www-data /var/www/html/wp-content/ 2>/dev/null || true
chmod -R 755 /var/www/html/wp-content/ 2>/dev/null || true

# Generate security salts
echo "🔒 Updating security salts..."
wp config shuffle-salts --allow-root

# Final optimization
echo "⚡ Final optimizations..."
wp cache flush --allow-root 2>/dev/null || true
wp db optimize --allow-root

echo ""
echo "🎉 WordPress CLI Setup Complete!"
echo "========================================"
echo "🌐 Site URL: $WP_URL"
echo "👤 Admin User: $WP_ADMIN_USER"
echo "🔑 Admin Password: $WP_ADMIN_PASSWORD"
echo "📧 Admin Email: $WP_ADMIN_EMAIL"
echo "🎨 Active Theme: $(wp theme status --allow-root | grep 'Active Theme' | cut -d: -f2 | xargs)"
echo "🔌 Installed Plugins: $(wp plugin list --status=active --field=name --allow-root | tr '\n' ', ' | sed 's/,$//')"
echo ""
echo "✅ Your WordPress site is fully configured and ready to use!"
echo "🚀 Users can now visit $WP_URL and start using the site immediately"
echo ""
echo "📊 Site Status:"
wp cli info --allow-root | head -5
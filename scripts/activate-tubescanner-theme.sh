#!/bin/bash

# TubeScanner Theme Activation Script
# This script activates the TubeScanner theme in WordPress

set -e

echo "🚀 Activating TubeScanner Theme..."

# Configuration
WP_PATH="/mnt/d/work/wordpress_pages/wordpress"
THEME_NAME="tubescanner-theme"
CONTAINER_NAME="apple-test_wp"

# Function to run WP-CLI in container
wp_cli() {
    docker exec $CONTAINER_NAME wp "$@" --allow-root
}

echo "📋 Checking WordPress container status..."
if ! docker ps | grep -q $CONTAINER_NAME; then
    echo "❌ WordPress container '$CONTAINER_NAME' is not running"
    echo "Please start your WordPress environment first"
    exit 1
fi

echo "✅ WordPress container is running"

echo "📋 Checking theme installation..."
if wp_cli theme is-installed $THEME_NAME; then
    echo "✅ TubeScanner theme is installed"
else
    echo "❌ TubeScanner theme is not installed"
    echo "Please ensure the theme is copied to wp-content/themes/"
    exit 1
fi

echo "🎨 Activating TubeScanner theme..."
if wp_cli theme activate $THEME_NAME; then
    echo "✅ TubeScanner theme activated successfully!"
else
    echo "❌ Failed to activate TubeScanner theme"
    exit 1
fi

echo "📋 Setting up theme requirements..."

# Create sample content if needed
echo "Creating sample menu..."
wp_cli menu create "Primary Menu" || echo "Menu might already exist"

# Set up homepage
echo "Setting up front page..."
wp_cli option update show_on_front 'posts'

# Set timezone
wp_cli option update timezone_string 'Asia/Shanghai'

# Set language (optional)
echo "Configuring language settings..."
wp_cli language core install zh_CN || echo "Language pack might already be installed"

# Set site info
wp_cli option update blogname "TubeScanner - YouTube & TikTok Analytics Tool"
wp_cli option update blogdescription "Professional social media analytics for cross-border e-commerce"

# Configure permalink structure
wp_cli rewrite structure '/%postname%/' --hard

# Flush rewrite rules
wp_cli rewrite flush

echo "🔧 Theme setup complete!"

echo "📊 Current theme status:"
wp_cli theme status $THEME_NAME

echo ""
echo "🎉 TubeScanner theme is now active!"
echo "📱 Visit your site: http://localhost:8080"
echo "⚙️  WordPress Admin: http://localhost:8080/wp-admin"
echo ""
echo "📝 Next steps:"
echo "1. Go to WordPress admin"
echo "2. Navigate to Appearance > Customize"
echo "3. Configure your hero section and CTA settings"
echo "4. Add your content and customize as needed"
echo ""
echo "✨ Your TubeScanner landing page is ready!"
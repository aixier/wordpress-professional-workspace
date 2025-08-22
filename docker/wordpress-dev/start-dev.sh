#!/bin/bash

# WordPress Development Environment Startup Script
# Quick start script for the complete development environment

set -e

echo "🚀 Starting WordPress Development Environment..."

# Configuration
COMPOSE_FILE="docker-compose.yml"
PROJECT_NAME="wordpress-dev"

# Check if Docker is running
if ! docker info > /dev/null 2>&1; then
    echo "❌ Docker is not running. Please start Docker first."
    exit 1
fi

# Check if docker-compose is available
if ! command -v docker-compose &> /dev/null; then
    echo "❌ docker-compose is not installed. Please install docker-compose first."
    exit 1
fi

# Build image if it doesn't exist
if ! docker images | grep -q "fsotool/wordpress-dev"; then
    echo "🏗️  WordPress development image not found. Building..."
    ./build.sh
fi

# Create necessary directories
echo "📁 Creating development directories..."
mkdir -p themes plugins logs backups

# Start the environment
echo "🐳 Starting Docker containers..."
docker-compose -p $PROJECT_NAME up -d

# Wait for services to be ready
echo "⏳ Waiting for services to start..."
sleep 10

# Check service status
echo "📊 Checking service status..."
docker-compose -p $PROJECT_NAME ps

# Test WordPress availability
echo "🧪 Testing WordPress availability..."
for i in {1..30}; do
    if curl -sf http://localhost:8080 > /dev/null; then
        echo "✅ WordPress is ready!"
        break
    fi
    if [ $i -eq 30 ]; then
        echo "❌ WordPress failed to start after 30 attempts"
        exit 1
    fi
    echo "Waiting for WordPress... ($i/30)"
    sleep 2
done

# Display access information
echo ""
echo "🎉 WordPress Development Environment Started Successfully!"
echo ""
echo "📱 Access Information:"
echo "   WordPress Site:    http://localhost:8080"
echo "   WordPress Admin:   http://localhost:8080/wp-admin"
echo "   phpMyAdmin:        http://localhost:8081"
echo "   MailHog:           http://localhost:8025"
echo ""
echo "🔑 Default Credentials:"
echo "   WordPress Admin:   admin / admin123"
echo "   MySQL Root:        root / rootpassword"
echo "   MySQL WordPress:   wordpress / wordpress"
echo ""
echo "🛠️  Useful Commands:"
echo "   View logs:         docker-compose -p $PROJECT_NAME logs -f"
echo "   Stop environment:  docker-compose -p $PROJECT_NAME down"
echo "   Enter container:   docker-compose -p $PROJECT_NAME exec wordpress bash"
echo "   WP-CLI:           docker-compose -p $PROJECT_NAME exec wordpress wp --help --allow-root"
echo ""
echo "📂 Development Directories:"
echo "   Themes:    ./themes/    → /wp-content/themes/custom/"
echo "   Plugins:   ./plugins/   → /wp-content/plugins/custom/"
echo "   Logs:      ./logs/      → /var/log/wordpress/"
echo "   Backups:   ./backups/   → /var/www/html/backups/"
echo ""
echo "🔧 Development Tools Available:"
echo "   - WP-CLI 2.10.0"
echo "   - Query Monitor"
echo "   - Debug Bar"
echo "   - User Switching"
echo "   - Duplicate Post"
echo "   - Composer"
echo ""
echo "Happy coding! 🎯"
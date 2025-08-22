#!/bin/bash

# Production WordPress Deployment Script
# Deploy a fully configured WordPress site using CLI only

set -e

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

echo -e "${BLUE}🚀 WordPress Production Deployment${NC}"
echo "===================================="
echo ""

# Configuration
SITE_TITLE=${1:-"My WordPress Site"}
ADMIN_USER=${2:-"admin"}
ADMIN_PASSWORD=${3:-"admin123"}
ADMIN_EMAIL=${4:-"admin@example.com"}
SITE_URL=${5:-"http://localhost"}
LOCALE=${6:-"zh_CN"}

echo -e "${YELLOW}📋 Deployment Configuration:${NC}"
echo "  Site Title: $SITE_TITLE"
echo "  Admin User: $ADMIN_USER"
echo "  Admin Email: $ADMIN_EMAIL"
echo "  Site URL: $SITE_URL"
echo "  Language: $LOCALE"
echo ""

# Create environment file
echo -e "${BLUE}⚙️  Creating environment configuration...${NC}"
cat > .env.production << EOF
# WordPress Database
WP_DB_PASSWORD=secure_password_$(date +%s)
MYSQL_ROOT_PASSWORD=root_password_$(date +%s)

# WordPress Admin
WP_ADMIN_PASSWORD=$ADMIN_PASSWORD

# WordPress Configuration
WORDPRESS_TITLE=$SITE_TITLE
WORDPRESS_ADMIN_USER=$ADMIN_USER
WORDPRESS_ADMIN_EMAIL=$ADMIN_EMAIL
WORDPRESS_URL=$SITE_URL
WORDPRESS_LOCALE=$LOCALE
EOF

echo "✅ Environment file created"

# Create necessary directories
echo -e "${BLUE}📁 Creating directories...${NC}"
mkdir -p themes plugins logs backups mysql-init

# Create production docker-compose with environment
echo -e "${BLUE}🐳 Starting WordPress production environment...${NC}"
export $(cat .env.production | xargs)

# Start the services
docker-compose -f docker-compose.production.yml up -d

echo -e "${YELLOW}⏳ Waiting for services to start...${NC}"
sleep 20

# Check if WordPress is ready
echo -e "${BLUE}🧪 Checking WordPress status...${NC}"
for i in {1..30}; do
    if curl -sf $SITE_URL > /dev/null 2>&1; then
        echo -e "${GREEN}✅ WordPress is ready!${NC}"
        break
    fi
    if [ $i -eq 30 ]; then
        echo -e "${RED}❌ WordPress failed to start after 30 attempts${NC}"
        echo "Please check logs: docker-compose -f docker-compose.production.yml logs"
        exit 1
    fi
    echo "Waiting for WordPress... ($i/30)"
    sleep 2
done

# Verify CLI setup completion
echo -e "${BLUE}🔍 Verifying WordPress CLI setup...${NC}"
docker-compose -f docker-compose.production.yml exec -T wordpress wp cli info --allow-root

# Check if user was created successfully
echo -e "${BLUE}👤 Verifying admin user...${NC}"
docker-compose -f docker-compose.production.yml exec -T wordpress wp user list --allow-root

# Verify theme activation
echo -e "${BLUE}🎨 Checking active theme...${NC}"
docker-compose -f docker-compose.production.yml exec -T wordpress wp theme status --allow-root

echo ""
echo -e "${GREEN}🎉 WordPress Production Deployment Complete!${NC}"
echo "=============================================="
echo ""
echo -e "${BLUE}🌐 Site Information:${NC}"
echo "  URL: $SITE_URL"
echo "  Admin Panel: $SITE_URL/wp-admin"
echo "  Admin User: $ADMIN_USER"
echo "  Admin Password: $ADMIN_PASSWORD"
echo ""
echo -e "${BLUE}🔧 Management Commands:${NC}"
echo "  View logs: docker-compose -f docker-compose.production.yml logs -f"
echo "  Stop site: docker-compose -f docker-compose.production.yml down"
echo "  Backup: docker-compose -f docker-compose.production.yml exec wordpress wp-backup.sh"
echo "  CLI access: docker-compose -f docker-compose.production.yml exec wordpress bash"
echo ""
echo -e "${BLUE}🛠️  WP-CLI Examples:${NC}"
echo "  List themes: docker-compose -f docker-compose.production.yml exec wordpress wp theme list --allow-root"
echo "  Install plugin: docker-compose -f docker-compose.production.yml exec wordpress wp plugin install plugin-name --activate --allow-root"
echo "  Create post: docker-compose -f docker-compose.production.yml exec wordpress wp post create --post_title='Hello' --post_status=publish --allow-root"
echo ""
echo -e "${GREEN}✨ Your WordPress site is ready for immediate use!${NC}"
echo -e "${GREEN}   No manual configuration required - users can start using it right away!${NC}"
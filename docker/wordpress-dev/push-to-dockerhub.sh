#!/bin/bash

# WordPress Development Image Push to Docker Hub Script
# Builds, tags, and pushes the WordPress development image to Docker Hub

set -e

# Configuration
DOCKER_HUB_USER="fsotool"
IMAGE_NAME="wordpress-dev"
FULL_IMAGE_NAME="$DOCKER_HUB_USER/$IMAGE_NAME"
VERSION="1.0.0"
WORDPRESS_VERSION="6.8.2"
PHP_VERSION="8.2"

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

echo -e "${BLUE}🐳 WordPress Development Image - Docker Hub Push${NC}"
echo "=========================================="
echo -e "📦 Image: ${GREEN}$FULL_IMAGE_NAME${NC}"
echo -e "🏷️  Version: ${GREEN}$VERSION${NC}"
echo -e "🌐 WordPress: ${GREEN}$WORDPRESS_VERSION${NC}"
echo -e "🐘 PHP: ${GREEN}$PHP_VERSION${NC}"
echo ""

# Check if Docker is running
if ! docker info > /dev/null 2>&1; then
    echo -e "${RED}❌ Docker is not running. Please start Docker first.${NC}"
    exit 1
fi

# Check if user is logged in to Docker Hub
if ! docker info 2>/dev/null | grep -q "Username"; then
    echo -e "${YELLOW}⚠️  Not logged in to Docker Hub. Please log in first:${NC}"
    echo "   docker login"
    exit 1
fi

# Build the image if it doesn't exist or force rebuild
echo -e "${BLUE}🏗️  Building WordPress Development Image...${NC}"
if [[ "$1" == "--rebuild" ]] || ! docker images | grep -q "$FULL_IMAGE_NAME"; then
    echo "Building from scratch..."
    ./build.sh
else
    echo "Image exists, skipping build. Use --rebuild to force rebuild."
fi

# Create multiple tags
echo -e "${BLUE}🏷️  Creating image tags...${NC}"
echo "Tagging with multiple versions:"

# Latest tag
docker tag $FULL_IMAGE_NAME:latest $FULL_IMAGE_NAME:latest
echo -e "  ✅ ${GREEN}$FULL_IMAGE_NAME:latest${NC}"

# Version tag
docker tag $FULL_IMAGE_NAME:latest $FULL_IMAGE_NAME:$VERSION
echo -e "  ✅ ${GREEN}$FULL_IMAGE_NAME:$VERSION${NC}"

# WordPress version tag
docker tag $FULL_IMAGE_NAME:latest $FULL_IMAGE_NAME:$WORDPRESS_VERSION
echo -e "  ✅ ${GREEN}$FULL_IMAGE_NAME:$WORDPRESS_VERSION${NC}"

# PHP version tag
docker tag $FULL_IMAGE_NAME:latest $FULL_IMAGE_NAME:php$PHP_VERSION
echo -e "  ✅ ${GREEN}$FULL_IMAGE_NAME:php$PHP_VERSION${NC}"

# Production tag
docker tag $FULL_IMAGE_NAME:latest $FULL_IMAGE_NAME:production
echo -e "  ✅ ${GREEN}$FULL_IMAGE_NAME:production${NC}"

# Date tag
DATE_TAG=$(date +%Y%m%d)
docker tag $FULL_IMAGE_NAME:latest $FULL_IMAGE_NAME:$DATE_TAG
echo -e "  ✅ ${GREEN}$FULL_IMAGE_NAME:$DATE_TAG${NC}"

echo ""

# Test the image before pushing
echo -e "${BLUE}🧪 Testing image before push...${NC}"
TEST_OUTPUT=$(docker run --rm $FULL_IMAGE_NAME:latest wp --info --allow-root 2>/dev/null | head -5)
if [[ $? -eq 0 ]]; then
    echo -e "  ✅ ${GREEN}Image test passed${NC}"
    echo "  📋 WP-CLI Version: $(echo "$TEST_OUTPUT" | grep "WP-CLI version" | cut -d: -f2 | xargs)"
else
    echo -e "  ❌ ${RED}Image test failed${NC}"
    exit 1
fi

echo ""

# Confirm before pushing
echo -e "${YELLOW}📤 Ready to push the following tags to Docker Hub:${NC}"
echo "   - $FULL_IMAGE_NAME:latest"
echo "   - $FULL_IMAGE_NAME:$VERSION"
echo "   - $FULL_IMAGE_NAME:$WORDPRESS_VERSION"
echo "   - $FULL_IMAGE_NAME:php$PHP_VERSION"
echo "   - $FULL_IMAGE_NAME:production"
echo "   - $FULL_IMAGE_NAME:$DATE_TAG"
echo ""

if [[ "$1" != "--yes" ]] && [[ "$2" != "--yes" ]]; then
    read -p "Do you want to continue? (y/N): " -n 1 -r
    echo
    if [[ ! $REPLY =~ ^[Yy]$ ]]; then
        echo -e "${YELLOW}❌ Push cancelled by user${NC}"
        exit 1
    fi
fi

# Push all tags
echo -e "${BLUE}📤 Pushing images to Docker Hub...${NC}"

TAGS=("latest" "$VERSION" "$WORDPRESS_VERSION" "php$PHP_VERSION" "production" "$DATE_TAG")

for tag in "${TAGS[@]}"; do
    echo -e "Pushing ${GREEN}$FULL_IMAGE_NAME:$tag${NC}..."
    if docker push $FULL_IMAGE_NAME:$tag; then
        echo -e "  ✅ ${GREEN}Successfully pushed $FULL_IMAGE_NAME:$tag${NC}"
    else
        echo -e "  ❌ ${RED}Failed to push $FULL_IMAGE_NAME:$tag${NC}"
        exit 1
    fi
done

echo ""
echo -e "${GREEN}🎉 All images pushed successfully!${NC}"
echo ""

# Display push summary
echo -e "${BLUE}📊 Push Summary:${NC}"
echo "==============================="
echo -e "🐳 Repository: ${GREEN}https://hub.docker.com/r/$DOCKER_HUB_USER/$IMAGE_NAME${NC}"
echo -e "📦 Total tags pushed: ${GREEN}${#TAGS[@]}${NC}"
echo -e "📏 Image size: ${GREEN}$(docker images $FULL_IMAGE_NAME:latest --format "{{.Size}}")${NC}"
echo ""

echo -e "${BLUE}🚀 Usage Examples:${NC}"
echo "==============================="
echo "# Pull and run latest version:"
echo "docker run -d -p 8080:80 -e WORDPRESS_AUTO_SETUP=true $FULL_IMAGE_NAME:latest"
echo ""
echo "# Pull specific version:"
echo "docker pull $FULL_IMAGE_NAME:$VERSION"
echo ""
echo "# Use in Docker Compose:"
echo "services:"
echo "  wordpress:"
echo "    image: $FULL_IMAGE_NAME:latest"
echo "    ports:"
echo "      - \"8080:80\""
echo ""

echo -e "${BLUE}🔗 Next Steps:${NC}"
echo "==============================="
echo "1. 📝 Update Docker Hub description with README content"
echo "2. 🏷️  Add additional tags if needed"
echo "3. 📢 Announce the release"
echo "4. 📊 Monitor download statistics"
echo ""

echo -e "${GREEN}✨ WordPress Development Environment is now available on Docker Hub!${NC}"
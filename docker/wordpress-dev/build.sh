#!/bin/bash

# WordPress Development Image Build Script
# Builds and optionally pushes the custom WordPress development image

set -e

# Configuration
IMAGE_NAME="fsotool/wordpress-dev"
IMAGE_TAG="latest"
DOCKERFILE_PATH="./Dockerfile"
BUILD_CONTEXT="."

# Build arguments
PHP_VERSION="8.2"
WORDPRESS_VERSION="6.8.2"
WPCLI_VERSION="2.10.0"

echo "🏗️  Building WordPress Development Image..."
echo "📋 Build Information:"
echo "   Image: $IMAGE_NAME:$IMAGE_TAG"
echo "   WordPress: $WORDPRESS_VERSION"
echo "   PHP: $PHP_VERSION"
echo "   WP-CLI: $WPCLI_VERSION"
echo ""

# Build the image
echo "🔨 Building Docker image..."
docker build \
    --build-arg PHP_VERSION=$PHP_VERSION \
    --build-arg WORDPRESS_VERSION=$WORDPRESS_VERSION \
    --build-arg WPCLI_VERSION=$WPCLI_VERSION \
    --tag $IMAGE_NAME:$IMAGE_TAG \
    --tag $IMAGE_NAME:$WORDPRESS_VERSION \
    --file $DOCKERFILE_PATH \
    $BUILD_CONTEXT

echo "✅ Build completed successfully!"

# Test the image
echo "🧪 Testing the built image..."
docker run --rm $IMAGE_NAME:$IMAGE_TAG wp --info --allow-root

echo "✅ Image test passed!"

# Size information
echo "📊 Image size information:"
docker images $IMAGE_NAME:$IMAGE_TAG --format "table {{.Repository}}\t{{.Tag}}\t{{.Size}}"

echo ""
echo "🎉 WordPress Development Image built successfully!"
echo ""
echo "📝 Usage examples:"
echo "   # Run with auto-setup"
echo "   docker run -d -p 8080:80 -e WORDPRESS_AUTO_SETUP=true $IMAGE_NAME:$IMAGE_TAG"
echo ""
echo "   # Run with custom database"
echo "   docker run -d -p 8080:80 \\"
echo "     -e WORDPRESS_DB_HOST=mysql:3306 \\"
echo "     -e WORDPRESS_DB_NAME=mydb \\"
echo "     -e WORDPRESS_DB_USER=myuser \\"
echo "     -e WORDPRESS_DB_PASSWORD=mypass \\"
echo "     $IMAGE_NAME:$IMAGE_TAG"
echo ""
echo "   # Push to registry"
echo "   docker push $IMAGE_NAME:$IMAGE_TAG"
echo "   docker push $IMAGE_NAME:$WORDPRESS_VERSION"
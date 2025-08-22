#!/bin/bash

# WordPress Development Image Build Script (Minimal Version)
# Quick build for testing and development

set -e

IMAGE_NAME="fsotool/wordpress-dev"
IMAGE_TAG="minimal"

echo "🏗️  Building Minimal WordPress Development Image..."
echo "📋 Build Information:"
echo "   Image: $IMAGE_NAME:$IMAGE_TAG"
echo ""

# Build the image
echo "🔨 Building Docker image..."
docker build \
    --tag $IMAGE_NAME:$IMAGE_TAG \
    --file Dockerfile.minimal \
    .

echo "✅ Build completed successfully!"

# Test the image
echo "🧪 Testing the built image..."
docker run --rm $IMAGE_NAME:$IMAGE_TAG wp --info --allow-root

echo "✅ Image test passed!"

# Size information
echo "📊 Image size information:"
docker images $IMAGE_NAME:$IMAGE_TAG --format "table {{.Repository}}\t{{.Tag}}\t{{.Size}}"

echo ""
echo "🎉 Minimal WordPress Development Image built successfully!"
echo ""
echo "📝 Usage example:"
echo "   docker run -d -p 8080:80 $IMAGE_NAME:$IMAGE_TAG"
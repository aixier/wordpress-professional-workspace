#!/bin/bash

# Push Minimal WordPress Development Image to Docker Hub
# Quick push script for the minimal version

set -e

IMAGE_NAME="fsotool/wordpress-dev"
IMAGE_TAG="minimal"

echo "🐳 Pushing Minimal WordPress Development Image to Docker Hub"
echo "=============================================="
echo "📦 Image: $IMAGE_NAME:$IMAGE_TAG"
echo ""

# Check if image exists
if ! docker images | grep -q "$IMAGE_NAME.*$IMAGE_TAG"; then
    echo "❌ Image $IMAGE_NAME:$IMAGE_TAG not found. Please build it first:"
    echo "   ./build-minimal.sh"
    exit 1
fi

# Check Docker login
if ! docker info 2>/dev/null | grep -q "Username"; then
    echo "⚠️  Please log in to Docker Hub first:"
    echo "   docker login"
    exit 1
fi

# Create additional tags
echo "🏷️  Creating additional tags..."
docker tag $IMAGE_NAME:$IMAGE_TAG $IMAGE_NAME:latest
docker tag $IMAGE_NAME:$IMAGE_TAG $IMAGE_NAME:v1.0.0-minimal

echo "🧪 Testing image before push..."
docker run --rm $IMAGE_NAME:$IMAGE_TAG wp --info --allow-root | head -5

echo ""
echo "📤 Ready to push tags:"
echo "   - $IMAGE_NAME:minimal"
echo "   - $IMAGE_NAME:latest"
echo "   - $IMAGE_NAME:v1.0.0-minimal"
echo ""

read -p "Continue with push? (y/N): " -n 1 -r
echo
if [[ ! $REPLY =~ ^[Yy]$ ]]; then
    echo "❌ Push cancelled"
    exit 1
fi

# Push images
echo "📤 Pushing images..."

echo "Pushing $IMAGE_NAME:minimal..."
docker push $IMAGE_NAME:minimal

echo "Pushing $IMAGE_NAME:latest..."
docker push $IMAGE_NAME:latest

echo "Pushing $IMAGE_NAME:v1.0.0-minimal..."
docker push $IMAGE_NAME:v1.0.0-minimal

echo ""
echo "🎉 Successfully pushed to Docker Hub!"
echo ""
echo "📊 Image Details:"
echo "   Repository: https://hub.docker.com/r/$IMAGE_NAME"
echo "   Size: $(docker images $IMAGE_NAME:$IMAGE_TAG --format "{{.Size}}")"
echo "   Tags: minimal, latest, v1.0.0-minimal"
echo ""
echo "🚀 Usage:"
echo "   docker run -d -p 8080:80 $IMAGE_NAME:latest"
echo ""
echo "📝 Next steps:"
echo "1. Update Docker Hub README"
echo "2. Test pull from Docker Hub"
echo "3. Update documentation"
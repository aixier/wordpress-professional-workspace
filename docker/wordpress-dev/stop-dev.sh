#!/bin/bash

# WordPress Development Environment Stop Script
# Gracefully stops the development environment

set -e

PROJECT_NAME="wordpress-dev"

echo "🛑 Stopping WordPress Development Environment..."

# Stop containers
echo "📦 Stopping Docker containers..."
docker-compose -p $PROJECT_NAME down

# Optional: Remove volumes (uncomment if you want to clear all data)
# echo "🗑️  Removing volumes..."
# docker-compose -p $PROJECT_NAME down -v

# Optional: Remove images (uncomment if you want to clean up completely)
# echo "🖼️  Removing images..."
# docker rmi fsotool/wordpress-dev:latest || true

echo "✅ WordPress Development Environment stopped successfully!"
echo ""
echo "📝 To start again:"
echo "   ./start-dev.sh"
echo ""
echo "🗑️  To completely clean up (remove all data):"
echo "   docker-compose -p $PROJECT_NAME down -v"
echo "   docker rmi fsotool/wordpress-dev:latest"
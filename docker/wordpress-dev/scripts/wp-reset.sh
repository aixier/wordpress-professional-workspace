#!/bin/bash

# WordPress Development Environment Reset Script
# This script resets WordPress to a clean state for testing

set -e

echo "🔄 Resetting WordPress Development Environment..."

# Confirmation prompt
read -p "⚠️  This will delete all WordPress data. Are you sure? (y/N): " -n 1 -r
echo
if [[ ! $REPLY =~ ^[Yy]$ ]]; then
    echo "❌ Reset cancelled"
    exit 1
fi

# Drop and recreate database
echo "🗄️  Resetting database..."
wp db reset --yes --allow-root

# Run fresh setup
echo "🏗️  Running fresh WordPress setup..."
/usr/local/bin/wp-dev-setup.sh

echo "✅ WordPress environment reset complete!"
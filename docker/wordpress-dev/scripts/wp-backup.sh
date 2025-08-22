#!/bin/bash

# WordPress Development Environment Backup Script
# Creates backups of database and files

set -e

BACKUP_DIR="/var/www/html/backups"
TIMESTAMP=$(date +"%Y%m%d_%H%M%S")
BACKUP_NAME="wp_backup_${TIMESTAMP}"

echo "💾 Creating WordPress backup..."

# Create backup directory
mkdir -p $BACKUP_DIR

# Database backup
echo "🗄️  Backing up database..."
wp db export "$BACKUP_DIR/${BACKUP_NAME}_database.sql" --allow-root

# Files backup (excluding backups directory itself)
echo "📁 Backing up files..."
tar -czf "$BACKUP_DIR/${BACKUP_NAME}_files.tar.gz" \
    --exclude="./backups" \
    --exclude="./wp-config.php" \
    -C /var/www/html .

# Create backup info file
cat > "$BACKUP_DIR/${BACKUP_NAME}_info.txt" << EOF
WordPress Backup Information
===========================
Backup Date: $(date)
WordPress Version: $(wp core version --allow-root)
PHP Version: $(php -v | head -n1)
Database Name: $(wp config get DB_NAME --allow-root)
Site URL: $(wp option get siteurl --allow-root)
Active Theme: $(wp theme status | grep "Active Theme" | cut -d: -f2 | xargs)

Files:
- ${BACKUP_NAME}_database.sql (Database dump)
- ${BACKUP_NAME}_files.tar.gz (WordPress files)
- ${BACKUP_NAME}_info.txt (This info file)

Restore Instructions:
1. Import database: wp db import ${BACKUP_NAME}_database.sql --allow-root
2. Extract files: tar -xzf ${BACKUP_NAME}_files.tar.gz
3. Update URLs if needed: wp search-replace old_url new_url --allow-root
EOF

echo "✅ Backup created successfully!"
echo "📍 Backup location: $BACKUP_DIR"
echo "📋 Files created:"
echo "   - ${BACKUP_NAME}_database.sql"
echo "   - ${BACKUP_NAME}_files.tar.gz"
echo "   - ${BACKUP_NAME}_info.txt"
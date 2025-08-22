# 🐳 WordPress Development Environment - Professional WP-CLI Enabled Platform

[![Docker Pulls](https://img.shields.io/docker/pulls/fsotool/wordpress-dev)](https://hub.docker.com/r/fsotool/wordpress-dev)
[![Docker Image Size](https://img.shields.io/docker/image-size/fsotool/wordpress-dev/latest)](https://hub.docker.com/r/fsotool/wordpress-dev)
[![GitHub Stars](https://img.shields.io/github/stars/fsotool/wordpress-pages?style=social)](https://github.com/fsotool/wordpress-pages/stargazers)
[![GitHub](https://img.shields.io/badge/GitHub-wordpress--pages-blue)](https://github.com/fsotool/wordpress-pages)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
[![WordPress](https://img.shields.io/badge/WordPress-6.8.2-blue)](https://wordpress.org/)
[![PHP](https://img.shields.io/badge/PHP-8.2-777BB4)](https://php.net/)

## 🚀 Complete WordPress Development Environment with WP-CLI Integration

**WordPress Development Environment** provides a comprehensive, production-ready Docker image for WordPress development with pre-installed WP-CLI, debugging tools, and performance optimizations. Perfect for developers, agencies, and teams building WordPress themes and plugins.

## ✨ What's New in v1.0.0

### 🎯 Complete Development Stack
- **🛠️ WP-CLI 2.10.0**: Full command-line interface pre-installed
- **🔧 Development Plugins**: Query Monitor, Debug Bar, User Switching
- **🌐 Multi-language**: Chinese (zh_CN) and English (en_US) support
- **⚡ Performance Optimized**: PHP 8.2, OPcache, Apache modules

## 🌟 Key Features

### 🛠️ **WP-CLI Integration**
- **Complete WP-CLI 2.10.0** - All WordPress management commands available
- **Auto-configuration** - Pre-configured for immediate use
- **Development helpers** - Custom scripts for setup, backup, reset
- **Database management** - Built-in import/export capabilities

### 🔧 **Development Tools**
- **Query Monitor** - Performance and database query debugging
- **Debug Bar** - Development debugging information
- **User Switching** - Easy user testing and switching
- **Composer** - PHP dependency management included
- **Git** - Version control tools ready

### 🌐 **Multi-language Support**
- **Chinese (zh_CN)** - Default simplified Chinese
- **English (en_US)** - Full English localization
- **Auto-detection** - Language based on environment variables
- **Easy switching** - Configure via WORDPRESS_LOCALE

### ⚡ **Performance Optimizations**
- **PHP 8.2** - Latest stable PHP with optimizations
- **OPcache enabled** - Bytecode caching for performance
- **Apache modules** - Rewrite, headers, expires, deflate
- **Memory optimized** - 512MB default, configurable

## 📦 Quick Start

### Option 1: Simple WordPress Setup
```bash
docker run -d -p 8080:80 \
  -e WORDPRESS_AUTO_SETUP=true \
  fsotool/wordpress-dev:latest
# Access at http://localhost:8080 (admin/admin123)
```

### Option 2: Custom Configuration
```bash
docker run -d -p 8080:80 \
  -e WORDPRESS_DB_HOST=mysql:3306 \
  -e WORDPRESS_DB_NAME=my_wordpress \
  -e WORDPRESS_DB_USER=wp_user \
  -e WORDPRESS_DB_PASSWORD=secure_password \
  -e WORDPRESS_TITLE="我的WordPress站点" \
  -e WORDPRESS_LOCALE=zh_CN \
  -e WORDPRESS_AUTO_SETUP=true \
  fsotool/wordpress-dev:latest
```

### Option 3: Complete Development Stack
```yaml
version: '3.8'
services:
  wordpress:
    image: fsotool/wordpress-dev:latest
    ports:
      - "8080:80"
    environment:
      - WORDPRESS_DB_HOST=mysql:3306
      - WORDPRESS_DB_NAME=wordpress
      - WORDPRESS_DB_USER=wordpress
      - WORDPRESS_DB_PASSWORD=wordpress
      - WORDPRESS_AUTO_SETUP=true
      - WORDPRESS_LOCALE=zh_CN
    volumes:
      - ./themes:/var/www/html/wp-content/themes/custom
      - ./plugins:/var/www/html/wp-content/plugins/custom
    depends_on:
      - mysql

  mysql:
    image: mysql:8.0
    environment:
      - MYSQL_ROOT_PASSWORD=rootpassword
      - MYSQL_DATABASE=wordpress
      - MYSQL_USER=wordpress
      - MYSQL_PASSWORD=wordpress
    volumes:
      - mysql_data:/var/lib/mysql

  phpmyadmin:
    image: phpmyadmin/phpmyadmin:latest
    ports:
      - "8081:80"
    environment:
      - PMA_HOST=mysql
      - PMA_USER=root
      - PMA_PASSWORD=rootpassword

volumes:
  mysql_data:
```

## 🔧 Configuration

### Environment Variables
```bash
# WordPress Configuration
WORDPRESS_DB_HOST=mysql:3306          # Database host
WORDPRESS_DB_NAME=wordpress           # Database name
WORDPRESS_DB_USER=wordpress           # Database user
WORDPRESS_DB_PASSWORD=wordpress       # Database password
WORDPRESS_TITLE="Development Site"    # Site title
WORDPRESS_ADMIN_USER=admin            # Admin username
WORDPRESS_ADMIN_PASSWORD=admin123     # Admin password
WORDPRESS_ADMIN_EMAIL=admin@localhost.local # Admin email
WORDPRESS_URL=http://localhost:8080   # Site URL
WORDPRESS_LOCALE=zh_CN                # Language (zh_CN/en_US)
WORDPRESS_AUTO_SETUP=true             # Auto-install WordPress

# Development Settings
WP_DEBUG=true                         # Enable debugging
WP_DEBUG_LOG=true                     # Enable debug logging
SCRIPT_DEBUG=true                     # Enable script debugging
```

### Volume Mounts
```bash
# Theme development
-v ./themes:/var/www/html/wp-content/themes/custom

# Plugin development  
-v ./plugins:/var/www/html/wp-content/plugins/custom

# Logs and debugging
-v ./logs:/var/log/wordpress

# Backups
-v ./backups:/var/www/html/backups
```

## 🎯 Use Cases

### For WordPress Developers
- **Theme Development** - Complete environment with debugging tools
- **Plugin Development** - Isolated development with WP-CLI integration
- **Client Projects** - Rapid setup for custom WordPress sites
- **Migration Projects** - Convert static sites to WordPress themes

### For Agencies & Teams
- **Standardized Environment** - Consistent development across team
- **Quick Prototyping** - Rapid WordPress setup for demos
- **Client Onboarding** - Fast environment creation
- **Training Environment** - Safe development sandbox

### For DevOps & CI/CD
- **Automated Testing** - WordPress testing in pipelines
- **Deployment Preparation** - Production-ready configurations
- **Environment Provisioning** - Quick dev/staging environments
- **Backup & Migration** - Built-in database management

## 🛠️ WP-CLI Usage Examples

### Theme Management
```bash
# List themes
docker exec wordpress wp theme list --allow-root

# Activate theme
docker exec wordpress wp theme activate my-theme --allow-root

# Install theme from repository
docker exec wordpress wp theme install twentytwentyfour --activate --allow-root
```

### Plugin Management
```bash
# List plugins
docker exec wordpress wp plugin list --allow-root

# Install and activate plugin
docker exec wordpress wp plugin install contact-form-7 --activate --allow-root

# Update all plugins
docker exec wordpress wp plugin update --all --allow-root
```

### Database Operations
```bash
# Export database
docker exec wordpress wp db export backup.sql --allow-root

# Import database
docker exec wordpress wp db import backup.sql --allow-root

# Search and replace URLs
docker exec wordpress wp search-replace 'oldurl.com' 'newurl.com' --allow-root
```

### Content Management
```bash
# Create posts
docker exec wordpress wp post create --post_title="Hello World" --post_status=publish --allow-root

# List users
docker exec wordpress wp user list --allow-root

# Update site URL
docker exec wordpress wp option update siteurl 'https://newdomain.com' --allow-root
```

## 🏷️ Available Tags

- `latest` - Latest stable release (v1.0.0)
- `v1.0.0` - WordPress 6.8.2 + PHP 8.2 + WP-CLI 2.10.0
- `production` - Production-optimized version
- `6.8.2` - WordPress version specific
- `php8.2` - PHP version specific

## 🚀 Built-in Scripts

### Management Scripts
```bash
# Fresh WordPress installation
docker exec wordpress wp-dev-setup.sh

# Complete environment reset
docker exec wordpress wp-reset.sh

# Create backup
docker exec wordpress wp-backup.sh
```

### Health Checks
```bash
# WordPress health check
docker exec wordpress wp doctor check --all --allow-root

# Database connectivity
docker exec wordpress wp db check --allow-root

# System information
docker exec wordpress wp --info --allow-root
```

## 📊 Performance

- **Startup Time**: < 30 seconds for complete stack
- **Memory Usage**: ~512MB base WordPress setup
- **PHP Performance**: OPcache enabled, optimized settings
- **Database**: MySQL 8.0 with development optimizations
- **Image Size**: ~800MB (includes all development tools)

## 🛡️ Security Features

### Development Security
- **Debug mode** - Enabled for development, easily disabled for production
- **File permissions** - Proper WordPress file permissions
- **Database isolation** - Containerized database with access controls
- **Environment variables** - Secure configuration management

### Production Ready
- **SSL/HTTPS support** - Ready for production SSL configuration
- **Security headers** - Apache security headers configured
- **Updates management** - Easy WordPress and plugin updates via WP-CLI
- **Backup strategies** - Built-in backup and restore capabilities

## 🔗 Resources

- 📖 [Complete Documentation](https://github.com/fsotool/wordpress-pages/tree/main/docker/wordpress-dev)
- 🚀 [Quick Start Guide](https://github.com/fsotool/wordpress-pages/blob/main/docker/wordpress-dev/README.md)
- 📋 [Migration SOP](https://github.com/fsotool/wordpress-pages/blob/main/docs/reference/sop.md)
- 💡 [Docker Guide](https://github.com/fsotool/wordpress-pages/blob/main/docs/docker-image-guide.md)
- 🐛 [Issue Tracker](https://github.com/fsotool/wordpress-pages/issues)
- ⭐ [Star on GitHub](https://github.com/fsotool/wordpress-pages)

## 🌐 Multi-language Examples

### Chinese Environment
```bash
docker run -d -p 8080:80 \
  -e WORDPRESS_LOCALE=zh_CN \
  -e WORDPRESS_TITLE="WordPress开发环境" \
  -e WORDPRESS_AUTO_SETUP=true \
  fsotool/wordpress-dev:latest
```

### English Environment
```bash
docker run -d -p 8080:80 \
  -e WORDPRESS_LOCALE=en_US \
  -e WORDPRESS_TITLE="WordPress Development" \
  -e WORDPRESS_AUTO_SETUP=true \
  fsotool/wordpress-dev:latest
```

## 🤝 Contributing

We welcome contributions to improve this WordPress development environment!

- 🔧 [Development Guide](https://github.com/fsotool/wordpress-pages/blob/main/CONTRIBUTING.md)
- 💬 [Discussions](https://github.com/fsotool/wordpress-pages/discussions)
- 🐛 [Bug Reports](https://github.com/fsotool/wordpress-pages/issues)
- 📝 [Documentation](https://github.com/fsotool/wordpress-pages/tree/main/docs)

## 📈 What's Next

### Upcoming Features
- **WordPress 6.9** support when released
- **PHP 8.3** compatibility
- **Additional development plugins**
- **Enhanced debugging tools**
- **Performance monitoring integration**

## 📝 License

MIT License - Free for commercial and personal use.

---

**Keywords**: WordPress, Docker, WP-CLI, PHP 8.2, MySQL, Development Environment, Theme Development, Plugin Development, Multi-language, Chinese, English, phpMyAdmin, Debug Bar, Query Monitor, Performance, Apache, Composer, Git

---

**Maintained by**: [FSO Tool Team](https://github.com/fsotool)  
**Support**: [GitHub Issues](https://github.com/fsotool/wordpress-pages/issues)  
**Version**: 1.0.0
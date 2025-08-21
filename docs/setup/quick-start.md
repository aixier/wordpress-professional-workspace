# ⚡ Quick Start Guide

> Get your CardPlanet WordPress development environment running in under 60 seconds!

## 🚀 Prerequisites

Make sure you have these installed:

- [Docker](https://www.docker.com/get-started) (20.10+) 
- [Docker Compose](https://docs.docker.com/compose/install/) (2.0+)
- [Git](https://git-scm.com/downloads) (2.20+)

## 📦 Installation

### Step 1: Clone & Setup

```bash
# Clone the repository
git clone https://github.com/your-username/cardplanet-wordpress.git
cd cardplanet-wordpress

# Copy environment configuration
cp .env.example .env
```

### Step 2: Launch Development Environment

```bash
# One-command setup
make setup
```

**Alternative method:**
```bash
./scripts/setup.sh
```

### Step 3: Verify Installation

```bash
# Check if containers are running
docker ps

# Test WordPress access
curl -I http://localhost:8080
```

## 🎯 Access Your Environment

| Service | URL | Credentials |
|---------|-----|-------------|
| **WordPress Site** | http://localhost:8080 | N/A |
| **Admin Dashboard** | http://localhost:8080/wp-admin | `admin` / `admin123` |
| **Database Manager** | http://localhost:8081 | `wordpress` / `wordpress` |

## ⚙️ Quick Commands

```bash
# Build and deploy themes
make build

# View logs
make logs

# Stop environment
make clean

# Restart environment
make setup
```

## 🎨 Start Development

### Create Your First Theme

```bash
# Navigate to themes directory
cd src/themes

# Create new theme directory
mkdir my-awesome-theme
cd my-awesome-theme

# Create basic files
touch style.css functions.php index.php

# Build and activate
make build
```

### Basic Theme Structure

**style.css:**
```css
/*
Theme Name: My Awesome Theme
Description: Custom WordPress theme
Version: 1.0.0
*/
```

**index.php:**
```php
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <title><?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>
<body>
    <h1>Hello WordPress!</h1>
    <?php wp_footer(); ?>
</body>
</html>
```

## 🐛 Common Issues

### Port Conflicts

If port 8080 is already in use:

```bash
# Edit .env file
nano .env

# Change ports
WORDPRESS_PORT=8090
PHPMYADMIN_PORT=8091

# Restart environment
make setup
```

### Permission Errors

```bash
# Fix script permissions
chmod +x scripts/*.sh

# Fix Docker permissions (Linux/WSL)
sudo chown $USER:$USER -R .
```

### Containers Won't Start

```bash
# Check Docker is running
docker --version

# Clean up and restart
make clean
make setup
```

## 📚 Next Steps

1. **📖 Read the Documentation**: [docs/](../README.md)
2. **🎨 Start Theme Development**: [Theme Guide](../development/theme-development.md)
3. **🔄 Migrate Existing Sites**: [Migration SOP](../reference/sop.md)
4. **🚀 Deploy to Production**: [Deployment Guide](../deployment/docker.md)

## 💡 Pro Tips

- **Save Time**: Use `make` commands instead of long Docker commands
- **Stay Organized**: Keep themes in `src/` and let the build process handle deployment
- **Monitor Logs**: Use `docker logs cardplanet_wp` for troubleshooting
- **Backup Regularly**: Your work is in `src/` - keep it version controlled!

---

**🎉 Congratulations!** Your CardPlanet WordPress development environment is ready. Start building amazing themes!

**Need help?** Check our [troubleshooting guide](../reference/troubleshooting.md) or [open an issue](https://github.com/your-username/cardplanet-wordpress/issues).
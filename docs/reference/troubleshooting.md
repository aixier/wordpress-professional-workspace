# 🔧 Troubleshooting Guide

> Common issues and solutions for CardPlanet WordPress development environment

## 🚨 Quick Diagnostics

Before diving into specific issues, run these commands to get an overview:

```bash
# Check system status
make status  # or: docker ps

# View recent logs
docker logs cardplanet_wp --tail 20
docker logs cardplanet_mysql --tail 20

# Test connectivity
curl -I http://localhost:8080
```

---

## 🐳 Docker & Container Issues

### Container Won't Start

**Symptoms:** `docker ps` shows no cardplanet containers

**Solutions:**
```bash
# 1. Check Docker daemon
docker --version
sudo systemctl status docker  # Linux
# or: Docker Desktop running? (Windows/Mac)

# 2. Check for port conflicts
netstat -tulpn | grep :8080
lsof -i :8080  # Mac/Linux

# 3. Clean restart
make clean
make setup

# 4. Check system resources
docker system df
docker system prune  # Free up space
```

### Port Conflicts

**Symptoms:** "Port already in use" errors

**Solutions:**
```bash
# Find which process uses the port
sudo netstat -tulpn | grep :8080

# Option 1: Kill the process
sudo kill $(sudo lsof -t -i:8080)

# Option 2: Change ports in .env
nano .env
# Change:
WORDPRESS_PORT=8090
PHPMYADMIN_PORT=8091

make setup
```

### MySQL Container Crashes

**Symptoms:** WordPress shows "database connection error"

**Solutions:**
```bash
# Check MySQL logs
docker logs cardplanet_mysql

# Common fix: Clear MySQL data
docker stop cardplanet_mysql
docker rm cardplanet_mysql
docker volume rm cardplanet-wordpress_mysql_data
make setup

# Check database connection
docker exec cardplanet_mysql mysql -u wordpress -p wordpress -e "SELECT 1;"
```

---

## 🌐 WordPress Issues

### White Screen of Death

**Symptoms:** Blank white page instead of WordPress

**Solutions:**
```bash
# 1. Check PHP errors
docker logs cardplanet_wp | tail -50

# 2. Enable WordPress debug mode
docker exec cardplanet_wp wp config set WP_DEBUG true --allow-root
docker exec cardplanet_wp wp config set WP_DEBUG_LOG true --allow-root

# 3. Check theme issues
docker exec cardplanet_wp wp theme list --allow-root
docker exec cardplanet_wp wp theme activate twentytwentythree --allow-root

# 4. Check for corrupted files
docker exec cardplanet_wp wp core verify-checksums --allow-root
```

### Theme Not Loading

**Symptoms:** Theme appears broken or default theme loads

**Solutions:**
```bash
# 1. Verify theme files exist
docker exec cardplanet_wp ls /var/www/html/wp-content/themes/

# 2. Check theme syntax
docker exec cardplanet_wp wp theme status [theme-name] --allow-root

# 3. Rebuild and redeploy
make build

# 4. Check file permissions
docker exec cardplanet_wp find /var/www/html/wp-content/themes/ -type f -exec chmod 644 {} \;
docker exec cardplanet_wp find /var/www/html/wp-content/themes/ -type d -exec chmod 755 {} \;
```

### Plugin Issues

**Symptoms:** Plugins not working, admin errors

**Solutions:**
```bash
# List active plugins
docker exec cardplanet_wp wp plugin list --allow-root

# Deactivate all plugins
docker exec cardplanet_wp wp plugin deactivate --all --allow-root

# Test with default theme
docker exec cardplanet_wp wp theme activate twentytwentythree --allow-root

# Check plugin conflicts
docker exec cardplanet_wp wp plugin activate [plugin-name] --allow-root
```

---

## 🎨 Theme Development Issues

### CSS Not Loading

**Symptoms:** Styles don't appear, broken layout

**Solutions:**
```bash
# 1. Check if CSS file exists
curl -I http://localhost:8080/wp-content/themes/your-theme/style.css

# 2. Verify functions.php enqueue
docker exec cardplanet_wp wp eval 'wp_styles()->print_styles();' --allow-root

# 3. Clear any caching
docker exec cardplanet_wp wp cache flush --allow-root

# 4. Check CSS syntax
# Use browser dev tools or CSS validator
```

### JavaScript Errors

**Symptoms:** Interactive elements not working, console errors

**Solutions:**
```bash
# 1. Check browser console for errors
# Open browser dev tools (F12)

# 2. Verify JS file loading
curl -I http://localhost:8080/wp-content/themes/your-theme/assets/js/main.js

# 3. Check WordPress jQuery conflicts
# Ensure proper WordPress jQuery usage:
# Use jQuery(document).ready() instead of $(document).ready()

# 4. Test JS file directly
curl http://localhost:8080/wp-content/themes/your-theme/assets/js/main.js
```

### Images Missing

**Symptoms:** Broken image icons, 404 errors for images

**Solutions:**
```bash
# 1. Check image path and file existence
docker exec cardplanet_wp ls /var/www/html/wp-content/themes/your-theme/assets/images/

# 2. Verify image URLs in templates
# Check if paths are correct in your theme files

# 3. Test image accessibility
curl -I http://localhost:8080/wp-content/themes/your-theme/assets/images/logo.png

# 4. Check file permissions
docker exec cardplanet_wp chmod 644 /var/www/html/wp-content/themes/your-theme/assets/images/*
```

---

## 🔧 Development Workflow Issues

### Make Commands Not Working

**Symptoms:** `make: command not found` or `make` targets fail

**Solutions:**
```bash
# 1. Install make (if missing)
# Ubuntu/Debian:
sudo apt-get install make

# Mac:
xcode-select --install

# Windows:
# Use WSL or Git Bash

# 2. Run scripts directly
./scripts/setup.sh
./scripts/build.sh
./scripts/deploy.sh

# 3. Check Makefile exists
ls -la Makefile
```

### Permission Errors

**Symptoms:** "Permission denied" when running scripts or accessing files

**Solutions:**
```bash
# 1. Fix script permissions
chmod +x scripts/*.sh
chmod +x restructure.sh

# 2. Fix Docker permissions (Linux/WSL)
sudo chown $USER:$USER -R .

# 3. Fix WordPress file permissions
docker exec cardplanet_wp chown -R www-data:www-data /var/www/html

# 4. SELinux issues (RHEL/CentOS)
sudo setsebool -P httpd_execmem 1
```

### Git Issues

**Symptoms:** Git conflicts, large files, repository issues

**Solutions:**
```bash
# 1. Check .gitignore is working
git status
git check-ignore -v [file-path]

# 2. Remove accidentally committed large files
git filter-branch --index-filter 'git rm --cached --ignore-unmatch [large-file]' HEAD

# 3. Reset to clean state
git stash
git reset --hard HEAD

# 4. Clean untracked files
git clean -fd
```

---

## 🚀 Performance Issues

### Slow Page Loading

**Symptoms:** Website takes long time to load

**Solutions:**
```bash
# 1. Check container resources
docker stats

# 2. Optimize images
# Use tools like imageoptim, tinypng

# 3. Enable WordPress caching
docker exec cardplanet_wp wp plugin install w3-total-cache --activate --allow-root

# 4. Check database performance
docker exec cardplanet_mysql mysql -u wordpress -p -e "SHOW PROCESSLIST;"
```

### High Memory Usage

**Symptoms:** System running slow, Docker using too much RAM

**Solutions:**
```bash
# 1. Check Docker memory usage
docker stats --no-stream

# 2. Limit container memory
# Add to docker-compose.yml:
# mem_limit: 512m

# 3. Clear Docker unused resources
docker system prune -a
docker volume prune

# 4. Restart containers
make clean
make setup
```

---

## 🔍 Advanced Debugging

### Enable WordPress Debug Mode

```bash
# Enable all debugging
docker exec cardplanet_wp wp config set WP_DEBUG true --allow-root
docker exec cardplanet_wp wp config set WP_DEBUG_LOG true --allow-root
docker exec cardplanet_wp wp config set WP_DEBUG_DISPLAY false --allow-root
docker exec cardplanet_wp wp config set SCRIPT_DEBUG true --allow-root

# Check debug log
docker exec cardplanet_wp tail -f /var/www/html/wp-content/debug.log
```

### Database Debugging

```bash
# Connect to MySQL directly
docker exec -it cardplanet_mysql mysql -u wordpress -p

# Check WordPress tables
SHOW TABLES LIKE 'wp_%';
SELECT * FROM wp_options WHERE option_name LIKE '%theme%';

# Check for corrupted tables
CHECK TABLE wp_posts;
REPAIR TABLE wp_posts;
```

### Network Debugging

```bash
# Test internal container networking
docker network ls
docker network inspect cardplanet-wordpress_default

# Test DNS resolution
docker exec cardplanet_wp nslookup cardplanet_mysql
docker exec cardplanet_wp ping cardplanet_mysql

# Check port mapping
docker port cardplanet_wp
```

---

## 🆘 Emergency Recovery

### Complete Environment Reset

```bash
# Nuclear option - reset everything
make clean
docker system prune -a --volumes
docker network prune
rm -rf wordpress/wp-content/uploads/*

# Restore from backup (if available)
tar -xzf cardplanet_backup_*.tar.gz
make setup
```

### Restore from Backup

```bash
# List available backups
ls -la resources/backups/

# Restore theme files
tar -xzf resources/backups/cardplanet_backup_20231201.tar.gz

# Restore database
docker exec cardplanet_mysql mysql -u wordpress -p wordpress < backup.sql

# Restart services
make deploy
```

---

## 📞 Getting Help

### Before Asking for Help

1. **Check logs first**: `docker logs cardplanet_wp`
2. **Try basic troubleshooting**: restart containers
3. **Search existing issues**: [GitHub Issues](https://github.com/your-username/cardplanet-wordpress/issues)
4. **Gather information**: system specs, error messages, steps to reproduce

### How to Report Issues

```bash
# Gather system information
echo "System: $(uname -a)"
echo "Docker: $(docker --version)"
echo "Compose: $(docker-compose --version)"

# Export logs
docker logs cardplanet_wp > wordpress.log 2>&1
docker logs cardplanet_mysql > mysql.log 2>&1

# Create minimal reproduction case
# Include steps to reproduce the issue
```

### Useful Resources

- **WordPress Support**: https://wordpress.org/support/
- **Docker Documentation**: https://docs.docker.com/
- **PHP Debugging**: https://www.php.net/manual/en/debugger.php
- **MySQL Documentation**: https://dev.mysql.com/doc/

---

**💡 Pro Tip**: Most issues can be resolved by restarting containers with `make clean && make setup`. When in doubt, start there!

**Still stuck?** [Open an issue](https://github.com/your-username/cardplanet-wordpress/issues/new) with detailed information about your problem.
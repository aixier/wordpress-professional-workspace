# Troubleshooting Guide

This guide covers common issues you might encounter during WordPress migration and their solutions.

## 🚨 Common Issues

### 1. Docker-related Issues

#### Problem: Docker containers won't start
**Symptoms:**
- Error: "port is already in use"
- Error: "network already exists"

**Solutions:**
```bash
# Check what's using the port
lsof -i :8080

# Stop conflicting containers
docker stop $(docker ps -q --filter "publish=8080")

# Remove old networks
docker network rm wordpress_network

# Restart with different ports
./scripts/init-environment.sh my-project -p 9080 --pma-port 9081
```

#### Problem: MySQL container fails to start
**Symptoms:**
- MySQL container exits immediately
- Database connection errors

**Solutions:**
```bash
# Check MySQL logs
docker logs PROJECT_NAME_mysql

# Remove corrupted MySQL data
docker volume rm PROJECT_NAME_mysql_data

# Restart MySQL container
docker run -d --name PROJECT_NAME_mysql \
  --network PROJECT_NAME_network \
  -e MYSQL_ROOT_PASSWORD=new_password \
  -e MYSQL_DATABASE=wordpress \
  -e MYSQL_USER=wordpress \
  -e MYSQL_PASSWORD=wordpress \
  mysql:5.7
```

### 2. WordPress Issues

#### Problem: WordPress shows "Error establishing database connection"
**Symptoms:**
- White page with database error
- WordPress won't load

**Solutions:**
```bash
# Check container network
docker network inspect PROJECT_NAME_network

# Verify MySQL is running
docker exec PROJECT_NAME_mysql mysql -uwordpress -pwordpress -e "SELECT 1"

# Check WordPress environment variables
docker inspect PROJECT_NAME_wp | grep -i mysql

# Recreate WordPress container with correct settings
docker rm -f PROJECT_NAME_wp
docker run -d --name PROJECT_NAME_wp \
  --network PROJECT_NAME_network \
  -p 8080:80 \
  -e WORDPRESS_DB_HOST=PROJECT_NAME_mysql \
  -e WORDPRESS_DB_USER=wordpress \
  -e WORDPRESS_DB_PASSWORD=wordpress \
  -e WORDPRESS_DB_NAME=wordpress \
  wordpress:latest
```

#### Problem: WordPress shows blank page
**Symptoms:**
- Page loads but shows nothing
- No error messages visible

**Solutions:**
```bash
# Enable WordPress debugging
docker exec PROJECT_NAME_wp bash -c "echo \"define('WP_DEBUG', true); define('WP_DEBUG_LOG', true); define('WP_DEBUG_DISPLAY', true);\" >> /var/www/html/wp-config.php"

# Check WordPress error logs
docker exec PROJECT_NAME_wp tail -f /var/www/html/wp-content/debug.log

# Check Apache error logs
docker logs PROJECT_NAME_wp

# Test with minimal theme
docker cp templates/basic-theme/. PROJECT_NAME_wp:/var/www/html/wp-content/themes/test-theme/
```

### 3. Theme-related Issues

#### Problem: Theme doesn't appear in WordPress admin
**Symptoms:**
- Custom theme not listed in Appearance > Themes
- WordPress uses default theme

**Solutions:**
```bash
# Check theme files exist
docker exec PROJECT_NAME_wp ls -la /var/www/html/wp-content/themes/YOUR_THEME/

# Verify style.css has proper header
docker exec PROJECT_NAME_wp head -10 /var/www/html/wp-content/themes/YOUR_THEME/style.css

# Check file permissions
docker exec PROJECT_NAME_wp chown -R www-data:www-data /var/www/html/wp-content/themes/YOUR_THEME/

# Activate theme via database
docker exec PROJECT_NAME_mysql mysql -uwordpress -pwordpress wordpress -e "UPDATE wp_options SET option_value='YOUR_THEME' WHERE option_name='template'"
```

#### Problem: CSS styles not loading
**Symptoms:**
- Page shows unstyled content
- Styles appear broken

**Solutions:**
```bash
# Check CSS file exists and is accessible
curl -I http://localhost:8080/wp-content/themes/YOUR_THEME/style.css

# Verify wp_head() is called in header.php
docker exec PROJECT_NAME_wp grep -n "wp_head" /var/www/html/wp-content/themes/YOUR_THEME/header.php

# Check functions.php for style enqueue
docker exec PROJECT_NAME_wp grep -n "wp_enqueue_style" /var/www/html/wp-content/themes/YOUR_THEME/functions.php

# Test with inline styles
# Add styles directly in the template file temporarily
```

#### Problem: Images not displaying
**Symptoms:**
- Broken image icons
- 404 errors for image files

**Solutions:**
```bash
# Check image files exist
docker exec PROJECT_NAME_wp find /var/www/html/wp-content/themes/YOUR_THEME/ -name "*.jpg" -o -name "*.png"

# Update image paths in theme
# Use get_template_directory_uri() instead of relative paths
# Example: <?php echo get_template_directory_uri(); ?>/assets/images/logo.png

# Copy images to theme directory
docker cp /path/to/original/images/. PROJECT_NAME_wp:/var/www/html/wp-content/themes/YOUR_THEME/assets/images/

# Check image permissions
docker exec PROJECT_NAME_wp ls -la /var/www/html/wp-content/themes/YOUR_THEME/assets/images/
```

### 4. Migration-specific Issues

#### Problem: JavaScript functionality not working
**Symptoms:**
- Interactive elements don't respond
- Console shows JavaScript errors

**Solutions:**
```bash
# Check browser console for errors
# Open browser dev tools and look for JavaScript errors

# Verify JavaScript files are loaded
curl -I http://localhost:8080/wp-content/themes/YOUR_THEME/assets/js/main.js

# Check jQuery conflicts
# WordPress loads its own jQuery, which might conflict

# Enqueue scripts properly in functions.php
# wp_enqueue_script('theme-js', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '1.0.0', true);

# Test with simple JavaScript first
echo "console.log('JavaScript loaded');" > test.js
docker cp test.js PROJECT_NAME_wp:/var/www/html/wp-content/themes/YOUR_THEME/assets/js/
```

#### Problem: Forms not submitting
**Symptoms:**
- Contact forms don't work
- Form submissions return errors

**Solutions:**
```bash
# Check form action URLs
# Update form actions to use WordPress URLs

# Add WordPress nonce for security
# <?php wp_nonce_field('form_action', 'form_nonce'); ?>

# Create form handler in functions.php
# add_action('wp_ajax_handle_form', 'handle_form_submission');
# add_action('wp_ajax_nopriv_handle_form', 'handle_form_submission');

# Test with simple form first
# Create minimal working form to verify functionality
```

## 🔧 Diagnostic Commands

### Quick Health Check
```bash
# Check all containers status
docker ps --filter "name=PROJECT_NAME"

# Test WordPress connection
curl -I http://localhost:8080/

# Check database connection
docker exec PROJECT_NAME_mysql mysql -uwordpress -pwordpress wordpress -e "SELECT 1"

# View recent logs
docker logs --tail 50 PROJECT_NAME_wp
```

### Theme Validation
```bash
# Check theme structure
docker exec PROJECT_NAME_wp find /var/www/html/wp-content/themes/YOUR_THEME -type f -name "*.php"

# Validate PHP syntax
docker exec PROJECT_NAME_wp php -l /var/www/html/wp-content/themes/YOUR_THEME/index.php

# Check WordPress requirements
docker exec PROJECT_NAME_wp ls -la /var/www/html/wp-content/themes/YOUR_THEME/ | grep -E "(style.css|index.php)"
```

### Performance Analysis
```bash
# Test page load time
time curl -s http://localhost:8080/ > /dev/null

# Check resource loading
curl -s http://localhost:8080/ | grep -o 'src="[^"]*"' | head -10

# Monitor container resources
docker stats PROJECT_NAME_wp PROJECT_NAME_mysql
```

## 🚨 Emergency Recovery

### Complete Environment Reset
```bash
# Stop all containers
docker stop PROJECT_NAME_wp PROJECT_NAME_mysql PROJECT_NAME_pma

# Remove all containers
docker rm PROJECT_NAME_wp PROJECT_NAME_mysql PROJECT_NAME_pma

# Remove network
docker network rm PROJECT_NAME_network

# Remove volumes (WARNING: This deletes all data!)
docker volume rm PROJECT_NAME_mysql_data PROJECT_NAME_wp_content

# Restart fresh environment
./scripts/init-environment.sh PROJECT_NAME
```

### Restore from Backup
```bash
# Restore theme files
docker cp backup/themes/YOUR_THEME/. PROJECT_NAME_wp:/var/www/html/wp-content/themes/YOUR_THEME/

# Restore database
docker exec PROJECT_NAME_mysql mysql -uwordpress -pwordpress wordpress < backup/database.sql

# Restart containers
docker restart PROJECT_NAME_wp PROJECT_NAME_mysql
```

## 📞 Getting Help

### Before Asking for Help
1. Check this troubleshooting guide
2. Review the migration documentation
3. Check container logs: `docker logs PROJECT_NAME_wp`
4. Test with minimal examples
5. Document error messages exactly

### Providing Information
When seeking help, please provide:
- Operating system and Docker version
- Exact error messages
- Steps to reproduce the issue
- Container logs
- WordPress and theme versions

### Resources
- [WordPress Documentation](https://wordpress.org/documentation/)
- [Docker Documentation](https://docs.docker.com/)
- [GitHub Issues](https://github.com/[username]/wordpress-migration-toolkit/issues)
- [Community Discussions](https://github.com/[username]/wordpress-migration-toolkit/discussions)

## ✅ Prevention Tips

1. **Always backup before making changes**
2. **Test in development environment first**
3. **Use version control for theme files**
4. **Document custom modifications**
5. **Keep container logs for debugging**
6. **Test on multiple browsers and devices**
7. **Validate HTML/CSS before migration**
8. **Monitor resource usage during migration**

Remember: Most issues are common and have been solved before. Check existing documentation and community resources first!
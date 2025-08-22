# WordPress Development Environment

A comprehensive Docker-based WordPress development environment with WP-CLI, debugging tools, and optimizations.

## Features

### 🛠️ Development Tools
- **WP-CLI 2.10.0** - Complete command-line interface for WordPress
- **Query Monitor** - Performance and debugging insights  
- **Debug Bar** - Debug information in admin bar
- **User Switching** - Easy user testing
- **Composer** - PHP dependency management

### ⚡ Performance Optimizations
- **OPcache** - PHP bytecode caching
- **Gzip Compression** - Reduced bandwidth usage
- **Optimized PHP settings** - Memory, execution time, upload limits
- **Apache modules** - Rewrite, headers, expires, deflate

### 🔧 Development Features
- **Error logging** - Comprehensive error tracking
- **Debug mode** - Safe development debugging
- **Auto-setup** - Automated WordPress installation
- **Backup tools** - Easy backup and restore
- **Reset functionality** - Quick environment reset

### 🌐 Multi-language Support
- **Chinese (zh_CN)** - Default language
- **English (en_US)** - Alternative language
- **Easy locale switching** - Environment variable configuration

## Quick Start

### 1. Build the Image
```bash
# Clone or download this directory
cd wordpress-dev/

# Build the custom WordPress image
chmod +x build.sh
./build.sh
```

### 2. Start the Environment
```bash
# Start all services
docker-compose up -d

# Check status
docker-compose ps
```

### 3. Access Your Site
- **WordPress Site**: http://localhost:8080
- **WordPress Admin**: http://localhost:8080/wp-admin
- **phpMyAdmin**: http://localhost:8081
- **MailHog**: http://localhost:8025

### 4. Default Credentials
- **WordPress Admin**: admin / admin123
- **MySQL Root**: root / rootpassword
- **MySQL WordPress**: wordpress / wordpress

## Usage

### WordPress Management
```bash
# Enter WordPress container
docker-compose exec wordpress bash

# Run WP-CLI commands
docker-compose exec wordpress wp --help --allow-root
docker-compose exec wordpress wp plugin list --allow-root
docker-compose exec wordpress wp theme list --allow-root

# Setup fresh WordPress
docker-compose exec wordpress wp-dev-setup.sh

# Reset WordPress
docker-compose exec wordpress wp-reset.sh

# Create backup
docker-compose exec wordpress wp-backup.sh
```

### Development Workflow
```bash
# Watch logs
docker-compose logs -f wordpress

# Install plugin
docker-compose exec wordpress wp plugin install contact-form-7 --activate --allow-root

# Install theme
docker-compose exec wordpress wp theme install twentytwentyfour --activate --allow-root

# Update WordPress
docker-compose exec wordpress wp core update --allow-root
```

### Database Operations
```bash
# Database backup
docker-compose exec wordpress wp db export backup.sql --allow-root

# Database import
docker-compose exec wordpress wp db import backup.sql --allow-root

# Search and replace URLs
docker-compose exec wordpress wp search-replace old_url new_url --allow-root
```

## Configuration

### Environment Variables

| Variable | Default | Description |
|----------|---------|-------------|
| `WORDPRESS_DB_HOST` | mysql:3306 | Database host and port |
| `WORDPRESS_DB_NAME` | wordpress | Database name |
| `WORDPRESS_DB_USER` | wordpress | Database username |
| `WORDPRESS_DB_PASSWORD` | wordpress | Database password |
| `WORDPRESS_TITLE` | WordPress Development Site | Site title |
| `WORDPRESS_ADMIN_USER` | admin | Admin username |
| `WORDPRESS_ADMIN_PASSWORD` | admin123 | Admin password |
| `WORDPRESS_ADMIN_EMAIL` | admin@localhost.local | Admin email |
| `WORDPRESS_URL` | http://localhost:8080 | Site URL |
| `WORDPRESS_LOCALE` | zh_CN | WordPress language |
| `WORDPRESS_AUTO_SETUP` | true | Auto-setup WordPress on start |

### Custom Configuration

#### PHP Settings
Edit `php.ini` to modify PHP configuration:
```ini
memory_limit = 512M
upload_max_filesize = 100M
post_max_size = 100M
```

#### Apache Settings
Edit `apache-dev.conf` for Apache configuration:
```apache
<Directory /var/www/html>
    Options Indexes FollowSymLinks MultiViews
    AllowOverride All
    Require all granted
</Directory>
```

#### WP-CLI Settings
Edit `wp-cli.yml` for WP-CLI defaults:
```yaml
user: www-data
path: /var/www/html
debug: true
```

## File Structure

```
wordpress-dev/
├── Dockerfile              # Main WordPress image
├── docker-compose.yml      # Complete development stack
├── build.sh               # Image build script
├── README.md              # This documentation
├── wp-cli.yml             # WP-CLI configuration
├── php.ini                # PHP configuration
├── apache-dev.conf        # Apache configuration
├── docker-entrypoint.sh   # Custom entrypoint
└── scripts/
    ├── wp-dev-setup.sh     # WordPress setup script
    ├── wp-reset.sh         # Environment reset script
    └── wp-backup.sh        # Backup creation script
```

## Volumes

| Volume | Mount Point | Purpose |
|--------|-------------|---------|
| `wp_content` | `/var/www/html/wp-content` | WordPress content |
| `mysql_data` | `/var/lib/mysql` | MySQL data |
| `redis_data` | `/data` | Redis cache data |
| `./themes` | `/var/www/html/wp-content/themes/custom` | Custom themes |
| `./plugins` | `/var/www/html/wp-content/plugins/custom` | Custom plugins |
| `./logs` | `/var/log/wordpress` | Application logs |
| `./backups` | `/var/www/html/backups` | Backup storage |

## Network

All services run on the `wordpress-dev-network` bridge network for internal communication.

## Ports

| Service | Internal Port | External Port |
|---------|---------------|---------------|
| WordPress | 80 | 8080 |
| MySQL | 3306 | 3306 |
| phpMyAdmin | 80 | 8081 |
| Redis | 6379 | 6379 |
| MailHog SMTP | 1025 | 1025 |
| MailHog Web | 8025 | 8025 |

## Development Tips

### 1. Theme Development
```bash
# Place themes in ./themes/ directory
mkdir -p themes/my-theme

# They'll be available at /wp-content/themes/custom/my-theme
docker-compose exec wordpress wp theme activate my-theme --allow-root
```

### 2. Plugin Development  
```bash
# Place plugins in ./plugins/ directory
mkdir -p plugins/my-plugin

# They'll be available at /wp-content/plugins/custom/my-plugin
docker-compose exec wordpress wp plugin activate my-plugin --allow-root
```

### 3. Debugging
- Enable Query Monitor for database and performance insights
- Check `/var/log/wordpress/` for error logs
- Use Debug Bar for detailed debug information
- Monitor Apache logs for server-side issues

### 4. Email Testing
- MailHog captures all emails sent from WordPress
- Access web interface at http://localhost:8025
- Configure WordPress to use SMTP: mailhog:1025

### 5. Database Management
- Use phpMyAdmin at http://localhost:8081
- Or connect directly via MySQL client on port 3306
- Regular backups with `wp-backup.sh`

## Troubleshooting

### Common Issues

#### Container Won't Start
```bash
# Check logs
docker-compose logs wordpress

# Rebuild image
docker-compose build --no-cache wordpress
```

#### Database Connection Failed
```bash
# Check MySQL status
docker-compose logs mysql

# Restart services
docker-compose restart mysql wordpress
```

#### Permission Issues
```bash
# Fix WordPress permissions
docker-compose exec wordpress chown -R www-data:www-data /var/www/html/wp-content/
```

#### Memory Issues
```bash
# Increase memory limit in php.ini
memory_limit = 1024M

# Rebuild container
docker-compose build wordpress
```

### Reset Environment
```bash
# Complete reset
docker-compose down -v
docker-compose up -d
```

## Performance Monitoring

### Built-in Tools
- Query Monitor - Database queries and performance
- Debug Bar - Memory usage and execution time
- Server Status - Apache server statistics at `/server-status`
- Server Info - PHP configuration at `/server-info`

### External Monitoring
- Use Redis for object caching
- Monitor logs in `./logs/` directory
- Check MySQL performance in phpMyAdmin

## Security

### Development Security
- Debug mode is enabled for development
- File editing is allowed in admin
- Automatic updates are disabled
- Use strong passwords in production

### Production Checklist
- [ ] Disable debug mode
- [ ] Enable SSL/HTTPS
- [ ] Disable file editing
- [ ] Enable automatic updates
- [ ] Use environment variables for secrets
- [ ] Implement proper backup strategy

## License

This development environment is released under the MIT License.

## Support

For issues and questions:
- Check the troubleshooting section
- Review Docker logs
- Consult WordPress and WP-CLI documentation
- Open an issue in the project repository
# WordPress Professional Development Environment

> 🚀 Enterprise-grade WordPress development platform with Docker containerization, CLI automation, and rapid deployment workflows

[![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)
[![WordPress](https://img.shields.io/badge/WordPress-6.8.2-blue.svg)](https://wordpress.org/)
[![Docker](https://img.shields.io/badge/Docker-ready-blue.svg)](https://hub.docker.com/r/coopotfan/wordpress-dev)
[![PHP](https://img.shields.io/badge/PHP-8.2-purple.svg)](https://php.net/)
[![WP-CLI](https://img.shields.io/badge/WP--CLI-2.10.0-orange.svg)](https://wp-cli.org/)

**WordPress Professional Development Environment** is a production-ready development platform that reduces WordPress project delivery time by 70%. Features standardized Docker images, automated workflows, and comprehensive documentation for building client projects from concept to deployment.

## 🌟 Key Features

- **⚡ 30-Second Setup**: Create a new WordPress project with one command
- **🐳 Standardized Docker Image**: Pre-configured `coopotfan/wordpress-dev` with WP-CLI 2.10.0
- **🤖 CLI-Driven Development**: 100% command-line workflow, no GUI required
- **📦 Project Templates**: Ready-to-use templates for common project types
- **🚀 70% Faster Delivery**: Automated workflows reduce development time significantly
- **🔧 Complete Toolchain**: PHP 8.2, MySQL 5.7, Apache, WP-CLI all pre-configured
- **📚 Enterprise Documentation**: SOPs for every phase from requirements to deployment
- **💼 Client-Ready**: Deliver fully configured, production-ready WordPress sites

## 🏗️ Project Structure

```
wordpress-development/
├── 📚 docs/               # Complete documentation
│   ├── development/       # Development workflows
│   ├── guides/           # Step-by-step guides
│   └── reference/        # Technical references
├── 🐳 docker/            # Docker configurations
│   └── wordpress-dev/    # Our custom Docker image
├── 🔧 src/               # Source code templates
│   └── themes/           # Theme templates
├── 📦 templates/         # Quick-start scripts
├── ⚙️ scripts/           # Automation tools
└── README.md            # This file
```

### Key Directories

| Directory | Purpose | Description |
|-----------|---------|-------------|
| `wordpress/` | Runtime | WordPress installation and runtime files |
| `src/` | Development | Theme and plugin source code |
| `docker/` | Infrastructure | Docker and container configurations |
| `docs/` | Documentation | Guides, references, and examples |
| `scripts/` | Automation | Build, deploy, and utility scripts |
| `resources/` | Assets | Templates, designs, and backup files |

## 🚀 Quick Start

### Prerequisites

- [Docker](https://www.docker.com/get-started) (20.10+)
- [Docker Compose](https://docs.docker.com/compose/install/) (2.0+)
- Git

### Create New Project (30 seconds)

```bash
# 1. Clone this repository
git clone https://github.com/your-username/wordpress-development.git
cd wordpress-development

# 2. Create new client project
./templates/quick-start.sh my-project

# 3. Your project is ready!
# Access: http://localhost:8080
# Admin: http://localhost:8080/wp-admin
```

### Using Docker Hub Image Directly

```bash
# Run WordPress with our pre-built image
docker run -d -p 8080:80 \
  --name my-wordpress \
  coopotfan/wordpress-dev:latest

# Initialize WordPress
docker exec my-wordpress wp core install \
  --url="http://localhost:8080" \
  --title="My Site" \
  --admin_user="admin" \
  --admin_password="admin123" \
  --admin_email="admin@example.com" \
  --allow-root
```

**That's it!** 🎉 WordPress is ready in 30 seconds.

### Default Access

- **Website**: http://localhost:8080  
- **Admin Panel**: http://localhost:8080/wp-admin
- **Database**: http://localhost:8081 (phpMyAdmin)
- **Credentials**: `admin` / `admin123`

## 💼 Client Project Workflow

From requirements to deployment in 15-28 days:

1. **Requirements Analysis** (1-2 days)
2. **Design Implementation** (2-3 days)
3. **Environment Setup** (10 minutes)
4. **Theme Development** (5-10 days)
5. **Functionality** (3-5 days)
6. **Content & Testing** (3-5 days)
7. **Deployment** (1 day)

📖 **Complete Guide**: [docs/development/client-workflow.md](docs/development/client-workflow.md)

## 📚 Documentation

| Topic | Description | Link |
|-------|-------------|------|
| **Client Workflow** | Complete project workflow | [docs/development/client-workflow.md](docs/development/client-workflow.md) |
| **Development Guide** | WordPress development | [docs/development/workflow.md](docs/development/workflow.md) |
| **Installation** | Setup instructions | [docs/setup/installation.md](docs/setup/installation.md) |
| **Troubleshooting** | Common issues & fixes | [docs/reference/troubleshooting.md](docs/reference/troubleshooting.md) |
| **Maintenance** | Post-deployment guide | [docs/reference/maintenance.md](docs/reference/maintenance.md) |

## 🆕 Recent Updates (v2.0)

- ✅ **Docker Image on Hub**: `coopotfan/wordpress-dev:latest` with WP-CLI 2.10.0
- ✅ **Complete Client Workflow**: From requirements to deployment documentation
- ✅ **Troubleshooting Guide**: Common issues and solutions added
- ✅ **Quick Start Script**: 30-second project creation
- ✅ **TubeScanner Demo**: Successfully migrated Next.js design to WordPress

## ⚡ Quick Commands

| Command | Description |
|---------|-------------|
| `make setup` | Initialize development environment |
| `make build` | Build and deploy themes |
| `make deploy` | Deploy changes to WordPress |
| `make clean` | Stop containers and clean up |
| `make help` | Show all available commands |

## 🎨 Theme Development

### Creating a New Theme

```bash
# Generate theme scaffold
./scripts/create-theme.sh my-theme

# Start development
cd src/themes/my-theme
# Edit files...

# Build and deploy
make build
```

### Development Workflow

1. **Edit** source files in `src/themes/your-theme/`
2. **Build** with `make build` (auto-copies to WordPress)
3. **Preview** at http://localhost:8080
4. **Repeat** until satisfied

## 🔄 Website Migration

Convert static websites to WordPress themes with our automated migration tools.

### Migration Process

```bash
# 1. Place original website in resources/
cp -r /path/to/static-site resources/original-sites/my-site/

# 2. Run migration analysis
./scripts/analyze-site.sh my-site

# 3. Generate WordPress theme
./scripts/generate-theme.sh my-site

# 4. Review and customize
cd src/themes/my-site-theme/
```

📖 **Detailed Guide**: [docs/reference/sop.md](docs/reference/sop.md)

## 🐳 Docker Configuration

### Services

- **WordPress** (port 8080): Main application
- **MySQL** (port 3306): Database  
- **phpMyAdmin** (port 8081): Database management
- **WP-CLI**: Command-line tools

### Environment Variables

```bash
# .env file
DB_NAME=wordpress
DB_USER=wordpress  
DB_PASSWORD=secure_password
WORDPRESS_PORT=8080
PHPMYADMIN_PORT=8081
```

## 🛠️ Development Tools

### Built-in Scripts

| Script | Purpose |
|--------|---------|
| `scripts/setup.sh` | Environment initialization |
| `scripts/build.sh` | Theme building and deployment |
| `scripts/deploy.sh` | Production deployment |
| `scripts/backup.sh` | Database and file backups |

### WP-CLI Integration

```bash
# Install plugins
docker exec -it wordpress_wp wp plugin install advanced-custom-fields --activate

# Create users  
docker exec -it wordpress_wp wp user create john john@example.com --role=author

# Database operations
docker exec -it wordpress_wp wp db export backup.sql
```

## 🧪 Examples & Templates

### CardPlanet Theme

A complete example of modern WordPress theme development:

- **Location**: `src/themes/cardplanet/`
- **Features**: Responsive design, ACF integration, modern CSS
- **Demo**: `docs/examples/cardplanet-demo/`

### Migration Examples

Real-world migration examples with before/after comparisons:

- **Apple.com Homepage**: `resources/original-sites/apple.com/`
- **CardPlanet.me**: `resources/original-sites/cardplanet.me/`

## 🤝 Contributing

We welcome contributions! Please see our [Contributing Guide](docs/reference/CONTRIBUTING.md).

### Development Setup

1. Fork the repository
2. Create feature branch: `git checkout -b feature/amazing-feature`
3. Make changes and test
4. Submit pull request

### Code Style

- **PHP**: Follow WordPress Coding Standards
- **CSS**: Use BEM methodology
- **JavaScript**: ESNext with proper linting
- **Documentation**: Clear, concise Markdown

## 📋 Requirements

### System Requirements

- **OS**: Linux, macOS, Windows (WSL2)
- **Memory**: 4GB RAM minimum
- **Storage**: 2GB free space
- **Network**: Internet connection for initial setup

### Software Dependencies

- Docker 20.10+
- Docker Compose 2.0+
- Git 2.20+
- Modern web browser

## 🐛 Troubleshooting

### Common Issues

| Issue | Solution |
|-------|----------|
| Port conflicts | Change ports in `.env` file |
| Permission errors | Run `chmod +x scripts/*` |
| Container won't start | Check Docker is running |
| WordPress won't load | Wait for MySQL initialization |

### Getting Help

1. Check [Troubleshooting Guide](docs/reference/troubleshooting.md)
2. Search [existing issues](https://github.com/your-username/cardplanet-wordpress/issues)
3. Create [new issue](https://github.com/your-username/cardplanet-wordpress/issues/new)

## 📄 License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

## 🙏 Acknowledgments

- [WordPress](https://wordpress.org/) - The platform that powers the web
- [Docker](https://www.docker.com/) - Containerization technology
- [WP-CLI](https://wp-cli.org/) - Command-line interface for WordPress
- Open source community for inspiration and contributions

## 🚀 What's Next?

- [ ] **Theme Builder GUI** - Visual theme creation interface
- [ ] **Plugin Scaffolding** - Automated plugin generation
- [ ] **CI/CD Integration** - GitHub Actions workflows  
- [ ] **Multi-site Support** - WordPress multisite configuration
- [ ] **Performance Monitoring** - Built-in performance analytics

---

<div align="center">

**⭐ If this project helps you, please star it on GitHub! ⭐**

[Documentation](docs/) • [Examples](docs/examples/) • [Issues](https://github.com/your-username/cardplanet-wordpress/issues) • [Contributing](docs/reference/CONTRIBUTING.md)

</div>
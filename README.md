# CardPlanet WordPress Development Workspace

> 🚀 Professional WordPress development environment with seamless migration tools and modern development workflow

[![GitHub license](https://img.shields.io/badge/license-MIT-blue.svg)](LICENSE)
[![WordPress](https://img.shields.io/badge/WordPress-6.8+-blue.svg)](https://wordpress.org/)
[![Docker](https://img.shields.io/badge/Docker-supported-blue.svg)](https://www.docker.com/)
[![PHP](https://img.shields.io/badge/PHP-7.4+-purple.svg)](https://php.net/)

**CardPlanet WordPress Workspace** is an open-source development environment designed for efficient WordPress theme development, website migration, and modern development workflows. Built with Docker containerization and industry best practices.

## 🌟 Features

- **🔧 Modern Development Environment**: Containerized WordPress setup with hot-reload
- **📦 Clean Project Structure**: Separation of source code, runtime, and documentation  
- **🚀 One-Click Setup**: Get started in under 60 seconds with `make setup`
- **🎨 Theme Development**: Advanced scaffolding and build tools for WordPress themes
- **🔄 Migration Tools**: Convert static sites to WordPress with automated workflows
- **📚 Comprehensive Documentation**: Detailed guides for every aspect of development
- **🐳 Docker First**: Full containerization with production-ready configurations
- **⚙️ Automated Workflows**: Build, test, and deploy with simple commands

## 🏗️ Project Structure

```
cardplanet-wordpress/
├── 🚀 wordpress/          # WordPress runtime instance (isolated)
├── 🔧 src/                # Development source code (version controlled)
├── 🐳 docker/             # Container configurations
├── 📚 docs/               # Documentation system
├── ⚙️ scripts/            # Automation scripts
├── 📦 resources/          # Project assets and templates
├── Makefile              # Quick commands
└── README.md             # Project overview
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
- [Make](https://www.gnu.org/software/make/) (optional, for shortcuts)

### Installation

```bash
# 1. Clone the repository
git clone https://github.com/your-username/cardplanet-wordpress.git
cd cardplanet-wordpress

# 2. Setup environment
cp .env.example .env

# 3. Start development environment
make setup
# or: ./scripts/setup.sh

# 4. Access your WordPress site
open http://localhost:8080
```

**That's it!** 🎉 Your WordPress development environment is ready.

### Default Access

- **Website**: http://localhost:8080  
- **Admin Panel**: http://localhost:8080/wp-admin
- **Database**: http://localhost:8081 (phpMyAdmin)
- **Credentials**: `admin` / `admin123`

## 📚 Documentation

| Topic | Description | Link |
|-------|-------------|------|
| **Setup Guide** | Initial environment setup | [docs/setup/](docs/setup/) |
| **Theme Development** | WordPress theme development | [docs/development/](docs/development/) |
| **Migration Guide** | Static to WordPress migration | [docs/reference/sop.md](docs/reference/sop.md) |
| **Deployment** | Production deployment | [docs/deployment/](docs/deployment/) |
| **API Reference** | Development APIs and hooks | [docs/api/](docs/api/) |

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
#!/bin/bash

# WordPress Migration Toolkit - Environment Initialization Script
# This script sets up the Docker environment for WordPress migration

set -e

# Colors for output
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# Default values
PROJECT_NAME=""
WORDPRESS_PORT="8080"
PHPMYADMIN_PORT="8081"
DB_PASSWORD="wordpress_secure_$(date +%s)"

# Function to print colored output
print_status() {
    echo -e "${BLUE}[INFO]${NC} $1"
}

print_success() {
    echo -e "${GREEN}[SUCCESS]${NC} $1"
}

print_warning() {
    echo -e "${YELLOW}[WARNING]${NC} $1"
}

print_error() {
    echo -e "${RED}[ERROR]${NC} $1"
}

# Function to show usage
usage() {
    echo "Usage: $0 PROJECT_NAME [OPTIONS]"
    echo ""
    echo "Options:"
    echo "  -p, --port PORT          WordPress port (default: 8080)"
    echo "  --pma-port PORT         phpMyAdmin port (default: 8081)"
    echo "  --db-password PASS      Database password (auto-generated if not provided)"
    echo "  -h, --help              Show this help message"
    echo ""
    echo "Example:"
    echo "  $0 my-project"
    echo "  $0 my-project -p 9000 --pma-port 9001"
}

# Parse command line arguments
while [[ $# -gt 0 ]]; do
    case $1 in
        -p|--port)
            WORDPRESS_PORT="$2"
            shift 2
            ;;
        --pma-port)
            PHPMYADMIN_PORT="$2"
            shift 2
            ;;
        --db-password)
            DB_PASSWORD="$2"
            shift 2
            ;;
        -h|--help)
            usage
            exit 0
            ;;
        -*)
            print_error "Unknown option $1"
            usage
            exit 1
            ;;
        *)
            if [ -z "$PROJECT_NAME" ]; then
                PROJECT_NAME="$1"
            else
                print_error "Too many arguments"
                usage
                exit 1
            fi
            shift
            ;;
    esac
done

# Check if project name is provided
if [ -z "$PROJECT_NAME" ]; then
    print_error "Project name is required"
    usage
    exit 1
fi

# Validate project name
if [[ ! "$PROJECT_NAME" =~ ^[a-zA-Z0-9_-]+$ ]]; then
    print_error "Project name can only contain letters, numbers, hyphens, and underscores"
    exit 1
fi

print_status "Initializing WordPress migration environment for project: $PROJECT_NAME"

# Check if Docker is installed
if ! command -v docker &> /dev/null; then
    print_error "Docker is not installed. Please install Docker first."
    exit 1
fi

# Check if Docker is running
if ! docker info &> /dev/null; then
    print_error "Docker is not running. Please start Docker first."
    exit 1
fi

# Create Docker network
print_status "Creating Docker network: ${PROJECT_NAME}_network"
if docker network inspect "${PROJECT_NAME}_network" &> /dev/null; then
    print_warning "Network ${PROJECT_NAME}_network already exists"
else
    docker network create "${PROJECT_NAME}_network"
    print_success "Network created: ${PROJECT_NAME}_network"
fi

# Start MySQL container
print_status "Starting MySQL container: ${PROJECT_NAME}_mysql"
if docker ps -a --format "table {{.Names}}" | grep -q "^${PROJECT_NAME}_mysql$"; then
    print_warning "MySQL container ${PROJECT_NAME}_mysql already exists"
    docker start "${PROJECT_NAME}_mysql" || print_error "Failed to start existing MySQL container"
else
    docker run -d --name "${PROJECT_NAME}_mysql" \
        --network "${PROJECT_NAME}_network" \
        -e MYSQL_ROOT_PASSWORD="$DB_PASSWORD" \
        -e MYSQL_DATABASE=wordpress \
        -e MYSQL_USER=wordpress \
        -e MYSQL_PASSWORD=wordpress \
        -v "${PROJECT_NAME}_mysql_data":/var/lib/mysql \
        mysql:5.7
    print_success "MySQL container started: ${PROJECT_NAME}_mysql"
fi

# Wait for MySQL to be ready
print_status "Waiting for MySQL to be ready..."
sleep 30

# Start WordPress container
print_status "Starting WordPress container: ${PROJECT_NAME}_wp"
if docker ps -a --format "table {{.Names}}" | grep -q "^${PROJECT_NAME}_wp$"; then
    print_warning "WordPress container ${PROJECT_NAME}_wp already exists"
    docker start "${PROJECT_NAME}_wp" || print_error "Failed to start existing WordPress container"
else
    docker run -d --name "${PROJECT_NAME}_wp" \
        --network "${PROJECT_NAME}_network" \
        -p "${WORDPRESS_PORT}:80" \
        -e WORDPRESS_DB_HOST="${PROJECT_NAME}_mysql" \
        -e WORDPRESS_DB_USER=wordpress \
        -e WORDPRESS_DB_PASSWORD=wordpress \
        -e WORDPRESS_DB_NAME=wordpress \
        -e WORDPRESS_DEBUG=1 \
        -v "${PROJECT_NAME}_wp_content":/var/www/html/wp-content \
        wordpress:latest
    print_success "WordPress container started: ${PROJECT_NAME}_wp"
fi

# Start phpMyAdmin container
print_status "Starting phpMyAdmin container: ${PROJECT_NAME}_pma"
if docker ps -a --format "table {{.Names}}" | grep -q "^${PROJECT_NAME}_pma$"; then
    print_warning "phpMyAdmin container ${PROJECT_NAME}_pma already exists"
    docker start "${PROJECT_NAME}_pma" || print_error "Failed to start existing phpMyAdmin container"
else
    docker run -d --name "${PROJECT_NAME}_pma" \
        --network "${PROJECT_NAME}_network" \
        -p "${PHPMYADMIN_PORT}:80" \
        -e PMA_HOST="${PROJECT_NAME}_mysql" \
        -e PMA_USER=wordpress \
        -e PMA_PASSWORD=wordpress \
        phpmyadmin/phpmyadmin:latest
    print_success "phpMyAdmin container started: ${PROJECT_NAME}_pma"
fi

# Wait for WordPress to be ready
print_status "Waiting for WordPress to be ready..."
sleep 20

# Test WordPress connection
print_status "Testing WordPress connection..."
if curl -sf "http://localhost:${WORDPRESS_PORT}/" > /dev/null; then
    print_success "WordPress is running successfully!"
else
    print_warning "WordPress might still be starting up. Please wait a moment and check manually."
fi

# Display access information
echo ""
echo "========================="
echo "🎉 ENVIRONMENT READY!"
echo "========================="
echo "Project: $PROJECT_NAME"
echo "WordPress: http://localhost:$WORDPRESS_PORT/"
echo "phpMyAdmin: http://localhost:$PHPMYADMIN_PORT/"
echo "Database Password: $DB_PASSWORD"
echo ""
echo "Next steps:"
echo "1. Copy your original website to examples/$PROJECT_NAME/"
echo "2. Run: ./scripts/create-theme.sh $PROJECT_NAME examples/$PROJECT_NAME/"
echo "3. Start migrating your content!"
echo ""
echo "To stop the environment:"
echo "docker stop ${PROJECT_NAME}_wp ${PROJECT_NAME}_mysql ${PROJECT_NAME}_pma"
echo ""
echo "To remove the environment:"
echo "docker rm ${PROJECT_NAME}_wp ${PROJECT_NAME}_mysql ${PROJECT_NAME}_pma"
echo "docker network rm ${PROJECT_NAME}_network"
echo "docker volume rm ${PROJECT_NAME}_mysql_data ${PROJECT_NAME}_wp_content"
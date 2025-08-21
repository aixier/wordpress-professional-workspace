#!/bin/bash
# CardPlanet WordPress 项目结构重构脚本
# 将混乱的项目结构重新组织为清晰简洁的架构

set -e  # 遇到错误立即退出

echo "🔄 开始 CardPlanet WordPress 项目重构..."

# 颜色定义
RED='\033[0;31m'
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
BLUE='\033[0;34m'
NC='\033[0m' # No Color

# 1. 创建备份
echo -e "${YELLOW}📦 创建项目备份...${NC}"
BACKUP_NAME="cardplanet_backup_$(date +%Y%m%d_%H%M%S).tar.gz"
tar -czf "$BACKUP_NAME" . --exclude="*.tar.gz" --exclude=".git" 2>/dev/null || true
echo -e "${GREEN}✅ 备份完成: $BACKUP_NAME${NC}"

# 2. 创建新目录结构
echo -e "${YELLOW}🏗️  创建新目录结构...${NC}"
mkdir -p wordpress-new
mkdir -p src/themes/cardplanet
mkdir -p src/plugins
mkdir -p docker/{wordpress,mysql,nginx}
mkdir -p docs/{setup,development,deployment,reference}
mkdir -p scripts
mkdir -p resources/{design,templates,backups}

# 3. 移动WordPress核心文件 (选择最完整的版本)
echo -e "${YELLOW}📂 整理WordPress核心文件...${NC}"
if [ -d "app" ] && [ "$(ls -A app/)" ]; then
    echo "使用app/目录作为WordPress核心"
    cp -r app/* wordpress-new/ 2>/dev/null || true
elif [ -d "wordpress" ] && [ "$(ls -A wordpress/)" ]; then
    echo "使用wordpress/目录作为WordPress核心"
    cp -r wordpress/* wordpress-new/ 2>/dev/null || true
else
    echo "从根目录收集WordPress文件"
    cp -r wp-* xmlrpc.php index.php license.txt readme.html wordpress-new/ 2>/dev/null || true
fi

# 4. 整理主题源码
echo -e "${YELLOW}🎨 整理主题源码...${NC}"
if [ -d "src/themes/cardplanet" ] && [ "$(ls -A src/themes/cardplanet/)" ]; then
    echo "主题源码已存在"
else
    # 从各个位置收集主题文件
    find . -name "cardplanet*" -type d | while read dir; do
        if [ -f "$dir/style.css" ] || [ -f "$dir/functions.php" ]; then
            echo "发现主题目录: $dir"
            cp -r "$dir"/* src/themes/cardplanet/ 2>/dev/null || true
        fi
    done
fi

# 5. 整理Docker配置
echo -e "${YELLOW}🐳 整理Docker配置...${NC}"
if [ -d "infrastructure/docker" ]; then
    cp -r infrastructure/docker/* docker/ 2>/dev/null || true
fi
if [ -f "docker-compose.yml" ]; then
    mv docker-compose.yml docker/ 2>/dev/null || true
fi

# 6. 整理文档
echo -e "${YELLOW}📚 重新组织文档...${NC}"

# 项目概述文档
if [ -f "README.md" ]; then
    cp README.md docs/README.md
fi

# 设置文档
if [ -f "docs/guides/setup/QUICK_START.md" ]; then
    cp docs/guides/setup/QUICK_START.md docs/setup/quick-start.md
fi
if [ -f "docs/guides/setup/WordPress命令行建站手册.md" ]; then
    cp "docs/guides/setup/WordPress命令行建站手册.md" docs/setup/installation.md
fi

# 开发文档
echo "# 主题开发指南" > docs/development/theme-development.md
echo "# 开发工作流程" > docs/development/workflow.md

# 部署文档
if [ -f "docs/guides/deployment/DEPLOY.md" ]; then
    cp docs/guides/deployment/DEPLOY.md docs/deployment/docker.md
fi

# 参考文档
if [ -f "docs/reference/SOP-WordPress-Migration-Manual.md" ]; then
    cp docs/reference/SOP-WordPress-Migration-Manual.md docs/reference/sop.md
fi
if [ -f "docs/reference/Content-Update-Manual.md" ]; then
    cp docs/reference/Content-Update-Manual.md docs/reference/maintenance.md
fi

# 7. 创建脚本
echo -e "${YELLOW}🛠️  创建自动化脚本...${NC}"

# 环境设置脚本
cat > scripts/setup.sh << 'EOF'
#!/bin/bash
echo "🚀 初始化 CardPlanet WordPress 开发环境..."
cd docker
docker-compose up -d
echo "✅ 环境启动完成！访问: http://localhost:8080"
EOF

# 主题构建脚本
cat > scripts/build.sh << 'EOF'
#!/bin/bash
echo "🔨 构建CardPlanet主题..."
cp -r src/themes/cardplanet/* wordpress/wp-content/themes/cardplanet/
echo "✅ 主题构建完成！"
EOF

# 部署脚本
cat > scripts/deploy.sh << 'EOF'
#!/bin/bash
echo "🚀 部署CardPlanet WordPress..."
./scripts/build.sh
cd docker
docker-compose restart
echo "✅ 部署完成！"
EOF

chmod +x scripts/*.sh

# 8. 创建配置文件
echo -e "${YELLOW}⚙️  创建配置文件...${NC}"

# 环境变量模板
cat > .env.example << 'EOF'
# CardPlanet WordPress Environment Configuration

# Database Configuration
DB_NAME=wordpress
DB_USER=wordpress
DB_PASSWORD=wordpress
DB_ROOT_PASSWORD=root_password

# WordPress Configuration
WORDPRESS_PORT=8080
PHPMYADMIN_PORT=8081

# Project Configuration
PROJECT_NAME=cardplanet
EOF

# Makefile
cat > Makefile << 'EOF'
.PHONY: setup build deploy clean

setup:
	@./scripts/setup.sh

build:
	@./scripts/build.sh

deploy:
	@./scripts/deploy.sh

clean:
	@cd docker && docker-compose down
	@docker system prune -f

help:
	@echo "CardPlanet WordPress 快捷命令:"
	@echo "  make setup  - 初始化开发环境"
	@echo "  make build  - 构建主题"
	@echo "  make deploy - 部署更新"
	@echo "  make clean  - 清理环境"
EOF

# 9. 更新.gitignore
cat > .gitignore << 'EOF'
# WordPress Core Files
wordpress/wp-admin/
wordpress/wp-includes/
wordpress/wp-*.php
wordpress/xmlrpc.php
wordpress/license.txt
wordpress/readme.html

# Configuration Files
.env
wordpress/wp-config.php

# Uploads and Cache
wordpress/wp-content/uploads/
wordpress/wp-content/cache/
*.log

# Development Dependencies
node_modules/
vendor/
.DS_Store
.vscode/
.idea/

# Docker
docker-compose.override.yml

# Backups
resources/backups/*
*.sql
*.tar.gz
!.gitkeep

# Temporary Files
*.tmp
*.swp
*~

# Keep Custom Content
!wordpress/wp-content/themes/cardplanet/
EOF

# 10. 清理老文件
echo -e "${YELLOW}🧹 清理冗余文件...${NC}"

# 删除临时和安装文件
rm -f install-*.php activate-*.php unzip-*.php 2>/dev/null || true
rm -f STRUCTURE_REDESIGN_PLAN.md REORGANIZATION_COMPLETE.md 2>/dev/null || true
rm -f cookies.txt login_cookies.txt .htaccess 2>/dev/null || true

# 移动WordPress到最终位置
rm -rf wordpress 2>/dev/null || true
mv wordpress-new wordpress

# 清理老目录
rm -rf app/ infrastructure/ 2>/dev/null || true

# 清理空目录
find . -type d -empty -delete 2>/dev/null || true

echo -e "${GREEN}✅ 项目重构完成！${NC}"
echo ""
echo -e "${BLUE}📁 新项目结构预览:${NC}"
echo "├── wordpress/          # WordPress运行实例"
echo "├── src/               # 开发源码"
echo "├── docker/            # 容器配置"  
echo "├── docs/              # 文档系统"
echo "├── scripts/           # 自动化脚本"
echo "├── resources/         # 项目资源"
echo "├── .env.example       # 环境配置模板"
echo "├── Makefile          # 快捷命令"
echo "└── README.md         # 项目说明"
echo ""
echo -e "${GREEN}🚀 快速开始:${NC}"
echo "1. cp .env.example .env"
echo "2. make setup"
echo "3. 访问 http://localhost:8080"
echo ""
echo -e "${YELLOW}💾 原始文件备份: $BACKUP_NAME${NC}"
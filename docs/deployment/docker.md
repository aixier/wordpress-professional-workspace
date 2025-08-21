# 🚀 CardPlanet WordPress Docker 部署指南

使用指定Docker镜像的专业部署方案，避免镜像拉取问题。

## 📋 所需镜像

```bash
WordPress: c23b6f0d5357 (wordpress:latest)
MySQL: 5107333e08a8 (mysql:5.7)
WP-CLI: 78f7b77ef7b5 (wordpress:cli-php8.2)
phpMyAdmin: 21c6d797c79c (phpmyadmin:latest)
```

## 🚀 一键部署脚本

### 1. 启动数据库
```bash
docker run -d \
  --name cardplanet_mysql \
  -e MYSQL_ROOT_PASSWORD=root \
  -e MYSQL_DATABASE=wordpress \
  -e MYSQL_USER=wordpress \
  -e MYSQL_PASSWORD=wordpress \
  -v $(pwd)/mysql-data:/var/lib/mysql \
  5107333e08a8
```

### 2. 启动WordPress
```bash
docker run -d \
  --name cardplanet_wp \
  --link cardplanet_mysql:mysql \
  -e WORDPRESS_DB_HOST=mysql \
  -e WORDPRESS_DB_USER=wordpress \
  -e WORDPRESS_DB_PASSWORD=wordpress \
  -e WORDPRESS_DB_NAME=wordpress \
  -p 8080:80 \
  -v $(pwd)/wordpress:/var/www/html \
  -v $(pwd)/themes:/var/www/html/wp-content/themes \
  c23b6f0d5357
```

### 3. 启动phpMyAdmin
```bash
docker run -d \
  --name cardplanet_pma \
  --link cardplanet_mysql:db \
  -e PMA_HOST=db \
  -p 8081:80 \
  21c6d797c79c
```

## 🛠️ WP-CLI 开发命令

### 基础命令格式
```bash
# WP-CLI命令模板
docker run --rm \
  --link cardplanet_mysql:mysql \
  --link cardplanet_wp:wordpress \
  -v $(pwd)/wordpress:/var/www/html \
  78f7b77ef7b5 wp [命令] --allow-root
```

### 常用开发命令

#### 安装ACF插件
```bash
docker run --rm \
  --link cardplanet_mysql:mysql \
  --link cardplanet_wp:wordpress \
  -v $(pwd)/wordpress:/var/www/html \
  78f7b77ef7b5 wp plugin install advanced-custom-fields --activate --allow-root
```

#### 创建管理员用户
```bash
docker run --rm \
  --link cardplanet_mysql:mysql \
  --link cardplanet_wp:wordpress \
  -v $(pwd)/wordpress:/var/www/html \
  78f7b77ef7b5 wp user create petron admin@cardplanet.local \
  --role=administrator \
  --user_pass=Petron12345^ \
  --allow-root
```

#### 激活主题
```bash
docker run --rm \
  --link cardplanet_mysql:mysql \
  --link cardplanet_wp:wordpress \
  -v $(pwd)/wordpress:/var/www/html \
  78f7b77ef7b5 wp theme activate cardplanet-theme --allow-root
```

#### 创建首页
```bash
docker run --rm \
  --link cardplanet_mysql:mysql \
  --link cardplanet_wp:wordpress \
  -v $(pwd)/wordpress:/var/www/html \
  78f7b77ef7b5 wp post create \
  --post_type=page \
  --post_title="CardPlanet首页" \
  --post_status=publish \
  --allow-root
```

#### 设置首页
```bash
# 获取页面ID
PAGE_ID=$(docker run --rm \
  --link cardplanet_mysql:mysql \
  --link cardplanet_wp:wordpress \
  -v $(pwd)/wordpress:/var/www/html \
  78f7b77ef7b5 wp post list --post_type=page --name=cardplanet首页 --field=ID --allow-root)

# 设置为首页
docker run --rm \
  --link cardplanet_mysql:mysql \
  --link cardplanet_wp:wordpress \
  -v $(pwd)/wordpress:/var/www/html \
  78f7b77ef7b5 wp option update show_on_front page --allow-root

docker run --rm \
  --link cardplanet_mysql:mysql \
  --link cardplanet_wp:wordpress \
  -v $(pwd)/wordpress:/var/www/html \
  78f7b77ef7b5 wp option update page_on_front $PAGE_ID --allow-root
```

## 🔧 快捷脚本

### 创建别名函数
```bash
# 添加到 ~/.bashrc 或 ~/.zshrc
alias wp-cli="docker run --rm \
  --link cardplanet_mysql:mysql \
  --link cardplanet_wp:wordpress \
  -v $(pwd)/wordpress:/var/www/html \
  78f7b77ef7b5 wp"

# 使用示例
wp-cli plugin list --allow-root
wp-cli theme list --allow-root
wp-cli user list --allow-root
```

### 完整初始化脚本
```bash
#!/bin/bash
# cardplanet-init.sh

echo "🚀 初始化CardPlanet WordPress..."

# 等待数据库启动
sleep 10

# 安装WordPress
docker run --rm \
  --link cardplanet_mysql:mysql \
  --link cardplanet_wp:wordpress \
  -v $(pwd)/wordpress:/var/www/html \
  78f7b77ef7b5 wp core install \
  --url=http://localhost:8080 \
  --title="CardPlanet" \
  --admin_user=petron \
  --admin_password=Petron12345^ \
  --admin_email=admin@cardplanet.local \
  --allow-root

# 安装ACF
docker run --rm \
  --link cardplanet_mysql:mysql \
  --link cardplanet_wp:wordpress \
  -v $(pwd)/wordpress:/var/www/html \
  78f7b77ef7b5 wp plugin install advanced-custom-fields --activate --allow-root

# 激活主题
docker run --rm \
  --link cardplanet_mysql:mysql \
  --link cardplanet_wp:wordpress \
  -v $(pwd)/wordpress:/var/www/html \
  78f7b77ef7b5 wp theme activate cardplanet-theme --allow-root

echo "✅ CardPlanet初始化完成！"
```

## 📊 容器管理

### 启动所有服务
```bash
# 1. MySQL
docker start cardplanet_mysql

# 2. WordPress  
docker start cardplanet_wp

# 3. phpMyAdmin
docker start cardplanet_pma
```

### 停止所有服务
```bash
docker stop cardplanet_pma cardplanet_wp cardplanet_mysql
```

### 清理容器
```bash
docker rm cardplanet_pma cardplanet_wp cardplanet_mysql
docker volume prune
```

## 🌐 访问地址

- **网站**: http://localhost:8080
- **后台**: http://localhost:8080/wp-admin
- **数据库**: http://localhost:8081
- **登录**: petron / Petron12345^

## 📝 开发工作流

1. **启动环境** - 运行MySQL和WordPress容器
2. **初始化** - 运行初始化脚本
3. **开发** - 使用WP-CLI进行开发操作
4. **测试** - 访问网站验证功能
5. **部署** - 备份并部署到生产环境

---

**优势**：
✅ 无需拉取镜像  
✅ 指定镜像ID，确保一致性  
✅ WP-CLI专业开发  
✅ 容器独立，易于管理
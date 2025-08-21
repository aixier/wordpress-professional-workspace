#!/bin/bash
# CardPlanet WordPress 启动脚本

set -e

echo "🚀 启动CardPlanet WordPress环境..."

# 停止现有容器
echo "🛑 停止现有容器..."
docker stop cardplanet_pma cardplanet_wp cardplanet_mysql 2>/dev/null || true
docker rm cardplanet_pma cardplanet_wp cardplanet_mysql 2>/dev/null || true

# 启动MySQL
echo "🗄️ 启动MySQL数据库..."
docker run -d \
  --name cardplanet_mysql \
  -e MYSQL_ROOT_PASSWORD=root \
  -e MYSQL_DATABASE=wordpress \
  -e MYSQL_USER=wordpress \
  -e MYSQL_PASSWORD=wordpress \
  -v "$(pwd)/mysql-data:/var/lib/mysql" \
  5107333e08a8

# 等待MySQL启动
echo "⏳ 等待MySQL启动..."
sleep 15

# 启动WordPress
echo "📝 启动WordPress..."
docker run -d \
  --name cardplanet_wp \
  --link cardplanet_mysql:mysql \
  -e WORDPRESS_DB_HOST=mysql \
  -e WORDPRESS_DB_USER=wordpress \
  -e WORDPRESS_DB_PASSWORD=wordpress \
  -e WORDPRESS_DB_NAME=wordpress \
  -p 8080:80 \
  -v "$(pwd)/wordpress:/var/www/html" \
  -v "$(pwd)/themes:/var/www/html/wp-content/themes" \
  c23b6f0d5357

# 启动phpMyAdmin
echo "🔧 启动phpMyAdmin..."
docker run -d \
  --name cardplanet_pma \
  --link cardplanet_mysql:db \
  -e PMA_HOST=db \
  -p 8081:80 \
  21c6d797c79c

# 等待WordPress启动
echo "⏳ 等待WordPress启动..."
sleep 10

# 检查服务状态
echo "📊 检查服务状态..."
if docker ps | grep -q cardplanet_mysql; then
    echo "✅ MySQL: 运行中"
else
    echo "❌ MySQL: 启动失败"
fi

if docker ps | grep -q cardplanet_wp; then
    echo "✅ WordPress: 运行中"
else
    echo "❌ WordPress: 启动失败"
fi

if docker ps | grep -q cardplanet_pma; then
    echo "✅ phpMyAdmin: 运行中"
else
    echo "❌ phpMyAdmin: 启动失败"
fi

echo ""
echo "🎉 CardPlanet环境启动完成！"
echo "🌐 访问地址："
echo "├── 网站: http://localhost:8080"
echo "├── 后台: http://localhost:8080/wp-admin"
echo "└── 数据库: http://localhost:8081"
echo ""
echo "📋 下一步："
echo "1. 运行: ./init.sh  (初始化WordPress)"
echo "2. 或使用WP-CLI命令进行开发"
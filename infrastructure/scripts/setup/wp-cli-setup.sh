#!/bin/bash
# WordPress CLI 完整部署脚本

set -e

echo "🚀 开始WordPress CLI部署..."

# 检查容器状态
if ! docker exec wp_site_simple echo "Container is running" 2>/dev/null; then
    echo "❌ WordPress容器未运行"
    exit 1
fi

echo "✅ WordPress容器运行正常"

# 安装必要工具
echo "📦 安装必要工具..."
docker exec wp_site_simple apt-get update -qq
docker exec wp_site_simple apt-get install -y wget curl unzip less mysql-client

echo "📥 安装WP-CLI..."
docker exec wp_site_simple bash -c "
wget https://github.com/wp-cli/wp-cli/releases/download/v2.8.1/wp-cli-2.8.1.phar -O wp-cli.phar --no-check-certificate
chmod +x wp-cli.phar
mv wp-cli.phar /usr/local/bin/wp
"

echo "🔍 验证WP-CLI安装..."
if docker exec wp_site_simple wp --version --allow-root 2>/dev/null; then
    echo "✅ WP-CLI安装成功"
else
    echo "❌ WP-CLI安装失败"
    exit 1
fi

echo "🔌 安装ACF插件..."
docker exec wp_site_simple wp plugin install advanced-custom-fields --activate --allow-root

echo "📄 创建首页..."
HOME_ID=$(docker exec wp_site_simple wp post create \
    --post_type=page \
    --post_title="CardPlanet首页" \
    --post_name=home \
    --post_status=publish \
    --porcelain \
    --allow-root)

echo "🏠 设置为首页..."
docker exec wp_site_simple wp option update show_on_front page --allow-root
docker exec wp_site_simple wp option update page_on_front $HOME_ID --allow-root

echo "🎨 激活主题..."
docker exec wp_site_simple wp theme activate cardplanet-theme --allow-root

echo "📋 创建导航菜单..."
MENU_ID=$(docker exec wp_site_simple wp menu create "主导航" --porcelain --allow-root)
docker exec wp_site_simple wp menu item add-post $MENU_ID $HOME_ID --title="首页" --allow-root
docker exec wp_site_simple wp menu location assign $MENU_ID primary --allow-root

echo "⚙️ 优化设置..."
# 设置永久链接
docker exec wp_site_simple wp rewrite structure '/%postname%/' --allow-root
docker exec wp_site_simple wp rewrite flush --allow-root

# 设置时区
docker exec wp_site_simple wp option update timezone_string 'Asia/Shanghai' --allow-root

# 禁用不需要的插件
docker exec wp_site_simple wp plugin deactivate hello akismet --allow-root 2>/dev/null || true

echo ""
echo "🎉 WordPress CLI部署完成！"
echo "📊 部署摘要："
echo "├── WordPress版本: $(docker exec wp_site_simple wp core version --allow-root)"
echo "├── 活跃主题: $(docker exec wp_site_simple wp theme list --status=active --field=name --allow-root)"
echo "├── 活跃插件: $(docker exec wp_site_simple wp plugin list --status=active --field=name --allow-root | wc -l)个"
echo "└── 首页ID: $HOME_ID"
echo ""
echo "🌐 访问地址:"
echo "├── 网站: http://localhost:8080"
echo "├── 后台: http://localhost:8080/wp-admin"
echo "└── 登录: petron / Petron12345^"
echo ""
echo "✅ CardPlanet准备就绪！"
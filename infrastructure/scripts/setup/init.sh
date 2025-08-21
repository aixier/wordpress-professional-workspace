#!/bin/bash
# CardPlanet WordPress 初始化脚本

set -e

echo "🔧 初始化CardPlanet WordPress..."

# WP-CLI命令别名
WP_CLI="docker run --rm \
  --link cardplanet_mysql:mysql \
  --link cardplanet_wp:wordpress \
  -v $(pwd)/wordpress:/var/www/html \
  78f7b77ef7b5 wp"

# 检查容器状态
if ! docker ps | grep -q cardplanet_wp; then
    echo "❌ WordPress容器未运行，请先执行: ./start.sh"
    exit 1
fi

echo "⏳ 等待WordPress就绪..."
sleep 5

# 检查WordPress是否已安装
if $WP_CLI core is-installed --allow-root 2>/dev/null; then
    echo "ℹ️  WordPress已安装，跳过核心安装"
else
    echo "📦 安装WordPress核心..."
    $WP_CLI core install \
      --url=http://localhost:8080 \
      --title="CardPlanet" \
      --admin_user=petron \
      --admin_password=Petron12345^ \
      --admin_email=admin@cardplanet.local \
      --allow-root
    echo "✅ WordPress核心安装完成"
fi

# 安装ACF插件
echo "🔌 安装Advanced Custom Fields插件..."
if $WP_CLI plugin is-installed advanced-custom-fields --allow-root; then
    echo "ℹ️  ACF插件已安装"
    if ! $WP_CLI plugin is-active advanced-custom-fields --allow-root; then
        $WP_CLI plugin activate advanced-custom-fields --allow-root
        echo "✅ ACF插件已激活"
    fi
else
    $WP_CLI plugin install advanced-custom-fields --activate --allow-root
    echo "✅ ACF插件安装并激活完成"
fi

# 激活CardPlanet主题
echo "🎨 激活CardPlanet主题..."
if $WP_CLI theme is-active cardplanet-theme --allow-root; then
    echo "ℹ️  CardPlanet主题已激活"
else
    $WP_CLI theme activate cardplanet-theme --allow-root
    echo "✅ CardPlanet主题激活完成"
fi

# 创建首页
echo "📄 创建首页..."
HOME_ID=$($WP_CLI post create \
  --post_type=page \
  --post_title="CardPlanet首页" \
  --post_name=home \
  --post_status=publish \
  --porcelain \
  --allow-root 2>/dev/null || $WP_CLI post list --post_type=page --name=home --field=ID --allow-root | head -1)

if [ -n "$HOME_ID" ]; then
    echo "✅ 首页创建完成 (ID: $HOME_ID)"
    
    # 设置为首页
    echo "🏠 设置静态首页..."
    $WP_CLI option update show_on_front page --allow-root
    $WP_CLI option update page_on_front $HOME_ID --allow-root
    echo "✅ 首页设置完成"
else
    echo "⚠️  首页创建可能失败"
fi

# 创建导航菜单
echo "📋 创建导航菜单..."
MENU_ID=$($WP_CLI menu create "主导航" --porcelain --allow-root 2>/dev/null || $WP_CLI menu list --field=term_id --allow-root | head -1)

if [ -n "$MENU_ID" ] && [ -n "$HOME_ID" ]; then
    $WP_CLI menu item add-post $MENU_ID $HOME_ID --title="首页" --allow-root 2>/dev/null || true
    $WP_CLI menu location assign $MENU_ID primary --allow-root 2>/dev/null || true
    echo "✅ 导航菜单设置完成"
fi

# 优化设置
echo "⚙️ 优化WordPress设置..."
$WP_CLI rewrite structure '/%postname%/' --allow-root
$WP_CLI rewrite flush --allow-root
$WP_CLI option update timezone_string 'Asia/Shanghai' --allow-root

# 禁用默认插件
echo "🧹 清理默认插件..."
$WP_CLI plugin deactivate hello akismet --allow-root 2>/dev/null || true

# 显示状态
echo ""
echo "📊 安装状态："
echo "├── WordPress版本: $($WP_CLI core version --allow-root)"
echo "├── 活跃主题: $($WP_CLI theme list --status=active --field=name --allow-root)"
echo "├── 活跃插件: $($WP_CLI plugin list --status=active --format=count --allow-root)个"
echo "└── 用户数量: $($WP_CLI user list --format=count --allow-root)个"

echo ""
echo "🎉 CardPlanet初始化完成！"
echo ""
echo "🌐 访问地址："
echo "├── 网站: http://localhost:8080"
echo "├── 后台: http://localhost:8080/wp-admin" 
echo "└── 登录: petron / Petron12345^"
echo ""
echo "🛠️ 常用WP-CLI命令："
echo "├── 查看插件: $WP_CLI plugin list --allow-root"
echo "├── 查看主题: $WP_CLI theme list --allow-root"
echo "└── 查看用户: $WP_CLI user list --allow-root"
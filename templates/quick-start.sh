#!/bin/bash
# WordPress项目快速启动脚本
# 使用方法: ./quick-start.sh project-name

PROJECT_NAME=${1:-"client-project"}
ADMIN_PASSWORD=$(openssl rand -base64 12)

echo "🚀 正在创建WordPress项目: $PROJECT_NAME"

# 创建项目结构
mkdir -p $PROJECT_NAME/{docs,src/themes/$PROJECT_NAME-theme,docker}
cd $PROJECT_NAME

# 创建docker-compose.yml
cat > docker-compose.yml << EOF
version: '3.8'
services:
  wordpress:
    image: coopotfan/wordpress-dev:latest
    container_name: ${PROJECT_NAME}-wordpress
    ports:
      - "8080:80"
    environment:
      WORDPRESS_DB_HOST: mysql:3306
      WORDPRESS_DB_NAME: ${PROJECT_NAME}_db
      WORDPRESS_DB_USER: wordpress
      WORDPRESS_DB_PASSWORD: wordpress
    volumes:
      - ./src/themes/${PROJECT_NAME}-theme:/var/www/html/wp-content/themes/${PROJECT_NAME}-theme
      - wordpress_data:/var/www/html
    depends_on:
      mysql:
        condition: service_healthy
    networks:
      - ${PROJECT_NAME}-network

  mysql:
    image: mysql:5.7
    container_name: ${PROJECT_NAME}-mysql
    environment:
      MYSQL_ROOT_PASSWORD: root123
      MYSQL_DATABASE: ${PROJECT_NAME}_db
      MYSQL_USER: wordpress
      MYSQL_PASSWORD: wordpress
    volumes:
      - mysql_data:/var/lib/mysql
    networks:
      - ${PROJECT_NAME}-network
    healthcheck:
      test: ["CMD", "mysqladmin", "ping", "-h", "localhost"]
      timeout: 20s
      retries: 10

volumes:
  wordpress_data:
  mysql_data:

networks:
  ${PROJECT_NAME}-network:
EOF

# 创建基础主题
cat > src/themes/${PROJECT_NAME}-theme/style.css << EOF
/*
Theme Name: ${PROJECT_NAME} Theme
Author: Development Team
Description: Custom WordPress theme for ${PROJECT_NAME}
Version: 1.0.0
*/
EOF

cat > src/themes/${PROJECT_NAME}-theme/index.php << 'EOF'
<?php get_header(); ?>
<main>
    <div class="container">
        <h1><?php bloginfo('name'); ?></h1>
        <?php if (have_posts()) : while (have_posts()) : the_post(); ?>
            <article>
                <h2><?php the_title(); ?></h2>
                <?php the_content(); ?>
            </article>
        <?php endwhile; endif; ?>
    </div>
</main>
<?php get_footer(); ?>
EOF

cat > src/themes/${PROJECT_NAME}-theme/functions.php << 'EOF'
<?php
// Theme setup
function theme_setup() {
    add_theme_support('post-thumbnails');
    add_theme_support('menus');
    add_theme_support('title-tag');
}
add_action('after_setup_theme', 'theme_setup');

// Load assets
function theme_assets() {
    wp_enqueue_style('theme-style', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'theme_assets');
EOF

# 启动Docker环境
echo "⏳ 启动Docker容器..."
docker-compose up -d

# 等待服务就绪
echo "⏳ 等待服务启动..."
sleep 30

# 初始化WordPress
echo "📦 初始化WordPress..."
docker exec ${PROJECT_NAME}-wordpress wp core install \
  --url="http://localhost:8080" \
  --title="${PROJECT_NAME} Website" \
  --admin_user="admin" \
  --admin_password="$ADMIN_PASSWORD" \
  --admin_email="admin@${PROJECT_NAME}.com" \
  --allow-root

# 激活主题
docker exec ${PROJECT_NAME}-wordpress wp theme activate ${PROJECT_NAME}-theme --allow-root

# 安装常用插件
echo "📦 安装插件..."
docker exec ${PROJECT_NAME}-wordpress wp plugin install contact-form-7 yoast-seo --activate --allow-root

# 创建基础页面
docker exec ${PROJECT_NAME}-wordpress wp post create --post_type=page --post_title="首页" --post_status=publish --allow-root
docker exec ${PROJECT_NAME}-wordpress wp post create --post_type=page --post_title="关于我们" --post_status=publish --allow-root
docker exec ${PROJECT_NAME}-wordpress wp post create --post_type=page --post_title="联系我们" --post_status=publish --allow-root

# 输出访问信息
echo "
✅ WordPress项目创建成功！

项目名称: $PROJECT_NAME
访问地址: http://localhost:8080
管理后台: http://localhost:8080/wp-admin
管理员账号: admin
管理员密码: $ADMIN_PASSWORD

常用命令:
- 进入容器: docker exec -it ${PROJECT_NAME}-wordpress bash
- 执行WP-CLI: docker exec ${PROJECT_NAME}-wordpress wp [命令] --allow-root
- 查看日志: docker logs ${PROJECT_NAME}-wordpress
- 停止服务: docker-compose down
- 重启服务: docker-compose restart

祝开发愉快！🎉
"
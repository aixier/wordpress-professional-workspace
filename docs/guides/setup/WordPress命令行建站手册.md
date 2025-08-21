# WordPress 命令行建站完整操作手册

## 📋 概述
本手册提供使用 Docker 和命令行工具快速搭建 WordPress 网站的完整步骤，适用于开发环境和生产环境部署。

## 🎯 前置要求
- Docker 已安装并运行
- 基本的命令行操作知识
- 网络连接正常

---

## 🚀 第一步：项目初始化

### 1.1 创建项目目录
```bash
# 创建项目根目录
mkdir my-wordpress-site
cd my-wordpress-site

# 创建标准目录结构
mkdir -p {themes,plugins,backups,uploads,mysql-data}
```

### 1.2 设置项目变量
```bash
# 设置项目名称（请修改为您的项目名称）
PROJECT_NAME="my-wordpress"
DB_PASSWORD="secure_password_123"
WP_ADMIN_USER="admin"
WP_ADMIN_PASS="admin_password_123"
WP_ADMIN_EMAIL="admin@yoursite.com"
```

---

## 🐳 第二步：Docker 环境搭建

### 2.1 创建 Docker 网络
```bash
# 创建专用网络
docker network create ${PROJECT_NAME}_network
```

### 2.2 启动 MySQL 数据库
```bash
# 启动 MySQL 5.7 容器
docker run -d \
  --name ${PROJECT_NAME}_mysql \
  --network ${PROJECT_NAME}_network \
  -e MYSQL_ROOT_PASSWORD=${DB_PASSWORD} \
  -e MYSQL_DATABASE=wordpress \
  -e MYSQL_USER=wordpress \
  -e MYSQL_PASSWORD=wordpress \
  -v $(pwd)/mysql-data:/var/lib/mysql \
  -p 3306:3306 \
  mysql:5.7

# 等待 MySQL 启动
echo "⏳ 等待 MySQL 启动..."
sleep 15
```

### 2.3 启动 WordPress 容器
```bash
# 启动 WordPress 容器
docker run -d \
  --name ${PROJECT_NAME}_wp \
  --network ${PROJECT_NAME}_network \
  -e WORDPRESS_DB_HOST=${PROJECT_NAME}_mysql \
  -e WORDPRESS_DB_USER=wordpress \
  -e WORDPRESS_DB_PASSWORD=wordpress \
  -e WORDPRESS_DB_NAME=wordpress \
  -e WORDPRESS_DEBUG=1 \
  -v $(pwd)/themes:/var/www/html/wp-content/themes \
  -v $(pwd)/plugins:/var/www/html/wp-content/plugins \
  -v $(pwd)/uploads:/var/www/html/wp-content/uploads \
  -p 8080:80 \
  wordpress:latest

# 等待 WordPress 启动
echo "⏳ 等待 WordPress 启动..."
sleep 20
```

### 2.4 启动 phpMyAdmin（可选）
```bash
# 启动 phpMyAdmin 管理界面
docker run -d \
  --name ${PROJECT_NAME}_pma \
  --network ${PROJECT_NAME}_network \
  -e PMA_HOST=${PROJECT_NAME}_mysql \
  -e PMA_USER=wordpress \
  -e PMA_PASSWORD=wordpress \
  -p 8081:80 \
  phpmyadmin:latest
```

---

## ✅ 第三步：验证安装

### 3.1 检查容器状态
```bash
# 检查所有容器运行状态
docker ps --filter "name=${PROJECT_NAME}" --format "table {{.Names}}\t{{.Status}}\t{{.Ports}}"

# 检查容器日志（如有问题）
docker logs ${PROJECT_NAME}_wp
docker logs ${PROJECT_NAME}_mysql
```

### 3.2 测试网站连接
```bash
# 测试 WordPress 访问
curl -I http://localhost:8080/

# 测试数据库连接
docker exec ${PROJECT_NAME}_mysql mysql -uwordpress -pwordpress wordpress -e "SELECT 1 as test;"
```

### 3.3 访问网站
- **WordPress 网站**: http://localhost:8080/
- **phpMyAdmin**: http://localhost:8081/
- **数据库连接信息**:
  - 主机: localhost:3306
  - 用户名: wordpress
  - 密码: wordpress
  - 数据库: wordpress

---

## 🔧 第四步：WordPress 初始配置

### 4.1 完成安装向导
```bash
# 通过浏览器访问 http://localhost:8080/ 完成安装
# 或使用命令行安装
docker exec ${PROJECT_NAME}_wp wp core install \
  --url="http://localhost:8080" \
  --title="我的WordPress网站" \
  --admin_user="${WP_ADMIN_USER}" \
  --admin_password="${WP_ADMIN_PASS}" \
  --admin_email="${WP_ADMIN_EMAIL}" \
  --allow-root
```

### 4.2 基础设置
```bash
# 设置时区
docker exec ${PROJECT_NAME}_wp wp option update timezone_string 'Asia/Shanghai' --allow-root

# 设置日期格式
docker exec ${PROJECT_NAME}_wp wp option update date_format 'Y-m-d' --allow-root

# 设置时间格式
docker exec ${PROJECT_NAME}_wp wp option update time_format 'H:i' --allow-root

# 设置固定链接结构
docker exec ${PROJECT_NAME}_wp wp option update permalink_structure '/%postname%/' --allow-root
```

---

## 🎨 第五步：主题和插件管理

### 5.1 主题操作
```bash
# 查看已安装主题
docker exec ${PROJECT_NAME}_wp wp theme list --allow-root

# 安装新主题
docker exec ${PROJECT_NAME}_wp wp theme install twentytwentyfour --allow-root

# 激活主题
docker exec ${PROJECT_NAME}_wp wp theme activate twentytwentyfour --allow-root

# 删除不需要的主题
docker exec ${PROJECT_NAME}_wp wp theme delete twentytwentyone --allow-root
```

### 5.2 插件操作
```bash
# 查看已安装插件
docker exec ${PROJECT_NAME}_wp wp plugin list --allow-root

# 安装常用插件
docker exec ${PROJECT_NAME}_wp wp plugin install yoast-seo --activate --allow-root
docker exec ${PROJECT_NAME}_wp wp plugin install contact-form-7 --activate --allow-root
docker exec ${PROJECT_NAME}_wp wp plugin install akismet --activate --allow-root

# 更新所有插件
docker exec ${PROJECT_NAME}_wp wp plugin update --all --allow-root
```

### 5.3 创建自定义主题
```bash
# 创建自定义主题目录
mkdir -p themes/my-custom-theme

# 创建基础主题文件
cat > themes/my-custom-theme/style.css << 'EOF'
/*
Theme Name: 我的自定义主题
Description: 这是一个自定义WordPress主题
Author: 您的名字
Version: 1.0.0
*/

body {
    font-family: 'Microsoft YaHei', Arial, sans-serif;
    line-height: 1.6;
    color: #333;
}
EOF

cat > themes/my-custom-theme/index.php << 'EOF'
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title('|', true, 'right'); bloginfo('name'); ?></title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    
    <header>
        <h1><?php bloginfo('name'); ?></h1>
        <p><?php bloginfo('description'); ?></p>
    </header>
    
    <main>
        <?php if (have_posts()) : ?>
            <?php while (have_posts()) : the_post(); ?>
                <article>
                    <h2><?php the_title(); ?></h2>
                    <div><?php the_content(); ?></div>
                </article>
            <?php endwhile; ?>
        <?php endif; ?>
    </main>
    
    <?php wp_footer(); ?>
</body>
</html>
EOF

# 激活自定义主题
docker exec ${PROJECT_NAME}_wp wp theme activate my-custom-theme --allow-root
```

---

## 📝 第六步：内容管理

### 6.1 创建页面和文章
```bash
# 创建首页
docker exec ${PROJECT_NAME}_wp wp post create \
  --post_type=page \
  --post_title="首页" \
  --post_content="欢迎来到我的网站！" \
  --post_status=publish \
  --allow-root

# 创建关于页面
docker exec ${PROJECT_NAME}_wp wp post create \
  --post_type=page \
  --post_title="关于我们" \
  --post_content="这里是关于我们的详细信息。" \
  --post_status=publish \
  --allow-root

# 创建示例文章
docker exec ${PROJECT_NAME}_wp wp post create \
  --post_title="第一篇文章" \
  --post_content="这是我的第一篇博客文章。" \
  --post_status=publish \
  --allow-root
```

### 6.2 菜单管理
```bash
# 创建主导航菜单
docker exec ${PROJECT_NAME}_wp wp menu create "主导航" --allow-root

# 添加页面到菜单
docker exec ${PROJECT_NAME}_wp wp menu item add-post main-menu 2 --allow-root
docker exec ${PROJECT_NAME}_wp wp menu item add-post main-menu 3 --allow-root

# 设置菜单位置
docker exec ${PROJECT_NAME}_wp wp menu location assign main-menu primary --allow-root
```

---

## 🔒 第七步：安全和优化

### 7.1 安全设置
```bash
# 更新 WordPress 核心
docker exec ${PROJECT_NAME}_wp wp core update --allow-root

# 修改默认用户名（如果使用admin）
docker exec ${PROJECT_NAME}_wp wp user create newadmin newadmin@yoursite.com \
  --role=administrator \
  --user_pass=new_secure_password \
  --allow-root

# 删除默认admin用户（可选）
# docker exec ${PROJECT_NAME}_wp wp user delete admin --reassign=2 --allow-root

# 设置文件权限
docker exec ${PROJECT_NAME}_wp chown -R www-data:www-data /var/www/html
docker exec ${PROJECT_NAME}_wp find /var/www/html -type d -exec chmod 755 {} \;
docker exec ${PROJECT_NAME}_wp find /var/www/html -type f -exec chmod 644 {} \;
```

### 7.2 性能优化
```bash
# 安装缓存插件
docker exec ${PROJECT_NAME}_wp wp plugin install w3-total-cache --activate --allow-root

# 优化数据库
docker exec ${PROJECT_NAME}_wp wp db optimize --allow-root

# 清理垃圾内容
docker exec ${PROJECT_NAME}_wp wp post delete $(docker exec ${PROJECT_NAME}_wp wp post list --post_status=trash --format=ids --allow-root) --allow-root
```

---

## 💾 第八步：备份和维护

### 8.1 创建备份脚本
```bash
# 创建备份脚本
cat > backup.sh << 'EOF'
#!/bin/bash
PROJECT_NAME="my-wordpress"
BACKUP_DATE=$(date +%Y%m%d_%H%M%S)
BACKUP_DIR="backups/${BACKUP_DATE}"

# 创建备份目录
mkdir -p ${BACKUP_DIR}

# 备份数据库
docker exec ${PROJECT_NAME}_mysql mysqldump -uwordpress -pwordpress wordpress > ${BACKUP_DIR}/database.sql

# 备份文件
tar -czf ${BACKUP_DIR}/files.tar.gz themes plugins uploads

echo "✅ 备份完成: ${BACKUP_DIR}"
EOF

# 设置脚本权限
chmod +x backup.sh

# 执行备份
./backup.sh
```

### 8.2 定期维护命令
```bash
# 检查网站状态
wp_status() {
    echo "=== WordPress 状态检查 ==="
    docker exec ${PROJECT_NAME}_wp wp core version --allow-root
    docker exec ${PROJECT_NAME}_wp wp plugin list --allow-root
    docker exec ${PROJECT_NAME}_wp wp theme list --allow-root
    echo "=== 数据库状态 ==="
    docker exec ${PROJECT_NAME}_mysql mysql -uwordpress -pwordpress wordpress -e "SELECT COUNT(*) as total_posts FROM wp_posts WHERE post_status='publish';"
}

# 更新所有组件
wp_update() {
    echo "🔄 更新 WordPress..."
    docker exec ${PROJECT_NAME}_wp wp core update --allow-root
    docker exec ${PROJECT_NAME}_wp wp plugin update --all --allow-root
    docker exec ${PROJECT_NAME}_wp wp theme update --all --allow-root
    echo "✅ 更新完成"
}
```

---

## 🛠️ 故障排除

### 常见问题解决方案

#### 问题1：端口被占用
```bash
# 检查端口占用
lsof -i :8080

# 停止占用端口的容器
docker stop $(docker ps -q --filter "publish=8080")

# 使用不同端口启动
docker run -d --name ${PROJECT_NAME}_wp -p 9080:80 [其他参数...]
```

#### 问题2：MySQL 连接失败
```bash
# 检查 MySQL 日志
docker logs ${PROJECT_NAME}_mysql

# 重启 MySQL 容器
docker restart ${PROJECT_NAME}_mysql

# 验证数据库连接
docker exec ${PROJECT_NAME}_mysql mysql -uroot -p${DB_PASSWORD} -e "SHOW DATABASES;"
```

#### 问题3：WordPress 白屏
```bash
# 启用调试模式
docker exec ${PROJECT_NAME}_wp wp config set WP_DEBUG true --allow-root
docker exec ${PROJECT_NAME}_wp wp config set WP_DEBUG_LOG true --allow-root

# 查看错误日志
docker exec ${PROJECT_NAME}_wp tail -f /var/www/html/wp-content/debug.log
```

---

## 🚀 生产环境部署

### 安全加固
```bash
# 禁用文件编辑
docker exec ${PROJECT_NAME}_wp wp config set DISALLOW_FILE_EDIT true --allow-root

# 限制登录尝试
docker exec ${PROJECT_NAME}_wp wp plugin install limit-login-attempts-reloaded --activate --allow-root

# SSL 设置（如果有证书）
docker exec ${PROJECT_NAME}_wp wp option update home "https://yourdomain.com" --allow-root
docker exec ${PROJECT_NAME}_wp wp option update siteurl "https://yourdomain.com" --allow-root
```

### 性能监控
```bash
# 安装性能监控插件
docker exec ${PROJECT_NAME}_wp wp plugin install query-monitor --activate --allow-root

# 设置对象缓存
docker exec ${PROJECT_NAME}_wp wp plugin install redis-cache --activate --allow-root
```

---

## 📋 快速参考命令

### 容器管理
```bash
# 启动所有容器
docker start ${PROJECT_NAME}_mysql ${PROJECT_NAME}_wp ${PROJECT_NAME}_pma

# 停止所有容器
docker stop ${PROJECT_NAME}_mysql ${PROJECT_NAME}_wp ${PROJECT_NAME}_pma

# 重启所有容器
docker restart ${PROJECT_NAME}_mysql ${PROJECT_NAME}_wp ${PROJECT_NAME}_pma

# 删除所有容器（慎用）
docker rm -f ${PROJECT_NAME}_mysql ${PROJECT_NAME}_wp ${PROJECT_NAME}_pma
docker network rm ${PROJECT_NAME}_network
```

### WordPress 常用命令
```bash
# 进入 WordPress 容器
docker exec -it ${PROJECT_NAME}_wp bash

# 运行 WP-CLI 命令
docker exec ${PROJECT_NAME}_wp wp [命令] --allow-root

# 查看网站信息
docker exec ${PROJECT_NAME}_wp wp option list --allow-root
```

---

## 🎯 总结

通过以上步骤，您已经成功：

1. ✅ 使用 Docker 搭建了完整的 WordPress 开发环境
2. ✅ 配置了 MySQL 数据库和 phpMyAdmin 管理界面
3. ✅ 完成了 WordPress 的基础配置和优化
4. ✅ 学会了主题、插件和内容的管理方法
5. ✅ 掌握了备份、维护和故障排除技巧

现在您可以开始创建自己的 WordPress 网站了！

---

## 📞 技术支持

如遇到问题，请检查：
1. Docker 是否正常运行
2. 端口是否被其他服务占用
3. 网络连接是否正常
4. 容器日志中的错误信息

更多帮助请参考项目文档或提交Issue。
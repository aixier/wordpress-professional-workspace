# 🚀 WordPress 标准化部署指南

基于 `coopotfan/wordpress-dev` 标准镜像的专业部署方案，实现一键部署到任何环境。

## 📋 核心优势

- **标准化镜像**: 统一的 `coopotfan/wordpress-dev:latest` 基础镜像
- **开箱即用**: 客户收到完全配置好的WordPress站点
- **CLI驱动**: 完全通过WP-CLI实现自动化配置
- **零配置交付**: 无需客户进行任何手动设置

## 🎯 快速部署方式

### 方式1: 一键部署脚本 (推荐)

```bash
# 客户项目一键部署
./deploy-production.sh \
  "客户公司网站" \
  "admin" \
  "secure_password_123" \
  "admin@client.com" \
  "https://client.com" \
  "zh_CN"

# 结果: 完全配置好的WordPress站点，客户可立即使用
```

### 方式2: Docker 直接部署

```bash
# 基础版本 - 快速启动
docker run -d -p 80:80 \
  -e WORDPRESS_AUTO_SETUP=true \
  -e WORDPRESS_TITLE="客户网站" \
  -e WORDPRESS_ADMIN_USER=admin \
  -e WORDPRESS_ADMIN_PASSWORD=secure123 \
  -e WORDPRESS_ADMIN_EMAIL=admin@client.com \
  -e WORDPRESS_URL=https://client.com \
  -e WORDPRESS_LOCALE=zh_CN \
  coopotfan/wordpress-dev:latest

# 完整版本 - 包含插件和定制
docker run -d -p 80:80 \
  --name client-production \
  -e WORDPRESS_AUTO_SETUP=true \
  -e WORDPRESS_TITLE="客户公司专业网站" \
  -e WORDPRESS_ADMIN_USER=admin \
  -e WORDPRESS_ADMIN_PASSWORD=client_secure_2024 \
  -e WORDPRESS_ADMIN_EMAIL=admin@client.com \
  -e WORDPRESS_URL=https://client.com \
  -e WORDPRESS_LOCALE=zh_CN \
  -e WORDPRESS_THEME=client-custom-theme \
  -e WORDPRESS_PLUGINS="contact-form-7,yoast-seo,wordfence" \
  -v /data/client-content:/var/www/html/wp-content \
  coopotfan/wordpress-dev:latest
```

### 方式3: Docker Compose 部署

```yaml
# docker-compose.client.yml
version: '3.8'

services:
  wordpress:
    image: coopotfan/wordpress-dev:latest
    container_name: client-wordpress
    restart: unless-stopped
    ports:
      - "80:80"
      - "443:443"
    environment:
      # 自动设置
      WORDPRESS_AUTO_SETUP: "true"
      
      # 客户信息
      WORDPRESS_TITLE: "客户公司网站"
      WORDPRESS_ADMIN_USER: "admin"
      WORDPRESS_ADMIN_PASSWORD: "client_secure_password"
      WORDPRESS_ADMIN_EMAIL: "admin@client.com"
      WORDPRESS_URL: "https://client.com"
      WORDPRESS_LOCALE: "zh_CN"
      
      # 功能配置
      WORDPRESS_THEME: "client-theme"
      WORDPRESS_PLUGINS: "contact-form-7,yoast-seo,woocommerce"
      
      # 数据库配置
      WORDPRESS_DB_HOST: mysql:3306
      WORDPRESS_DB_NAME: client_db
      WORDPRESS_DB_USER: wp_user
      WORDPRESS_DB_PASSWORD: secure_db_password
      
    volumes:
      - client_content:/var/www/html/wp-content
      - client_logs:/var/log/wordpress
      - ./client-theme:/var/www/html/wp-content/themes/client-theme
      
    depends_on:
      mysql:
        condition: service_healthy
    networks:
      - client-network

  mysql:
    image: mysql:8.0
    container_name: client-mysql
    restart: unless-stopped
    environment:
      MYSQL_ROOT_PASSWORD: root_secure_password
      MYSQL_DATABASE: client_db
      MYSQL_USER: wp_user
      MYSQL_PASSWORD: secure_db_password
    volumes:
      - client_mysql_data:/var/lib/mysql
    networks:
      - client-network
    healthcheck:
      test: ["CMD", "mysqladmin", "ping", "-h", "localhost"]
      timeout: 20s
      retries: 10

volumes:
  client_content:
  client_mysql_data:
  client_logs:

networks:
  client-network:
    driver: bridge

# 启动: docker-compose -f docker-compose.client.yml up -d
```

## 🌐 云平台部署

### AWS 部署

```bash
# AWS ECS/Fargate
aws ecs create-service \
  --service-name client-wordpress \
  --task-definition client-wordpress-task:1 \
  --desired-count 1 \
  --launch-type FARGATE \
  --network-configuration "awsvpcConfiguration={subnets=[subnet-xxx],securityGroups=[sg-xxx],assignPublicIp=ENABLED}"

# AWS EC2
docker run -d -p 80:80 \
  -e WORDPRESS_AUTO_SETUP=true \
  -e WORDPRESS_TITLE="客户网站" \
  -e WORDPRESS_URL=https://client.amazonaws.com \
  coopotfan/wordpress-dev:latest
```

### Google Cloud 部署

```bash
# Google Cloud Run
gcloud run deploy client-wordpress \
  --image coopotfan/wordpress-dev:latest \
  --platform managed \
  --port 80 \
  --set-env-vars WORDPRESS_AUTO_SETUP=true,WORDPRESS_TITLE="客户网站"

# Google Compute Engine
docker run -d -p 80:80 \
  -e WORDPRESS_AUTO_SETUP=true \
  -e WORDPRESS_URL=https://client.googleapis.com \
  coopotfan/wordpress-dev:latest
```

### Azure 部署

```bash
# Azure Container Instances
az container create \
  --resource-group client-rg \
  --name client-wordpress \
  --image coopotfan/wordpress-dev:latest \
  --ports 80 \
  --environment-variables WORDPRESS_AUTO_SETUP=true WORDPRESS_TITLE="客户网站"
```

## 🔧 部署后配置

### 验证部署状态

```bash
# 检查容器状态
docker ps | grep client

# 检查WordPress状态
curl -I https://client.com

# 验证CLI功能
docker exec client-wordpress wp cli info --allow-root

# 检查管理员用户
docker exec client-wordpress wp user list --allow-root

# 验证主题和插件
docker exec client-wordpress wp theme list --allow-root
docker exec client-wordpress wp plugin list --allow-root
```

### 安全加固

```bash
# 更新安全密钥
docker exec client-wordpress wp config shuffle-salts --allow-root

# 设置安全选项
docker exec client-wordpress wp config set WP_DEBUG false --allow-root
docker exec client-wordpress wp config set DISALLOW_FILE_EDIT true --allow-root
docker exec client-wordpress wp config set FORCE_SSL_ADMIN true --allow-root

# 优化性能
docker exec client-wordpress wp db optimize --allow-root
docker exec client-wordpress wp cache flush --allow-root
```

## 📊 环境配置对比

| 环境类型 | 部署方式 | 配置时间 | 维护复杂度 | 推荐场景 |
|---------|---------|---------|-----------|---------|
| 开发环境 | Docker直接运行 | 1分钟 | 低 | 本地开发测试 |
| 测试环境 | Docker Compose | 3分钟 | 中 | 功能验证 |
| 生产环境 | 一键部署脚本 | 5分钟 | 低 | 客户交付 |
| 云平台 | 容器服务 | 10分钟 | 中 | 大规模部署 |

## 🚀 客户交付清单

### 交付包内容
1. **完全配置的WordPress网站**
2. **管理员登录凭据**
3. **部署脚本和配置文件**
4. **运维监控命令**
5. **备份和恢复文档**

### 客户收到后即可:
- ✅ 直接访问网站 - 无需配置
- ✅ 登录后台管理 - 账号密码已设置
- ✅ 开始发布内容 - 所有功能就绪
- ✅ 使用所有插件 - 已安装激活
- ✅ 进行SEO优化 - 工具已配置

### 交付标准
```bash
# 客户验收清单
echo "网站访问: ✅ $(curl -s -o /dev/null -w "%{http_code}" https://client.com)"
echo "后台登录: ✅ 管理员账号可正常登录"
echo "主题激活: ✅ $(docker exec client-wordpress wp theme status --allow-root | grep Active)"
echo "插件功能: ✅ $(docker exec client-wordpress wp plugin list --status=active --allow-root | wc -l) 个插件已激活"
echo "内容创建: ✅ 示例页面和文章已创建"
echo "菜单配置: ✅ 导航菜单已设置"
echo "SEO配置: ✅ 基础SEO设置已完成"
```

## 🔄 部署后运维

### 日常监控
```bash
# 站点健康检查
docker exec client-wordpress wp doctor check --allow-root

# 性能监控
docker exec client-wordpress wp eval 'echo "Memory: " . size_format(memory_get_usage());' --allow-root

# 更新检查
docker exec client-wordpress wp core check-update --allow-root
docker exec client-wordpress wp plugin list --update=available --allow-root
```

### 备份策略
```bash
# 自动备份脚本
#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)

# 备份数据库
docker exec client-wordpress wp db export /backups/db_$DATE.sql --allow-root

# 备份文件
docker exec client-wordpress tar -czf /backups/content_$DATE.tar.gz wp-content/

echo "备份完成: $DATE"
```

---

**这个部署方案确保客户收到的是完全配置好的WordPress网站，真正实现"开箱即用"的交付标准。**
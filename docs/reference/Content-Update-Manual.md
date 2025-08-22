# WordPress 客户站点内容管理手册

## 📋 概述

本手册适用于基于 `coopotfan/wordpress-dev` 镜像交付的WordPress站点的内容管理。提供完整的内容更新、页面管理和日常维护流程。

## 🎯 内容管理模式

### 核心理念
- **CLI优先管理**: 通过WP-CLI实现高效内容管理
- **版本化更新**: 每次更新都有完整的版本记录
- **安全优先**: 所有操作都有备份和回滚保障
- **用户友好**: 提供后台管理和CLI两种方式

---

## 🔧 Phase 1: 内容管理环境

### 1.1 连接客户站点

```bash
#!/bin/bash
# connect-client-site.sh - 连接客户站点进行内容管理

CLIENT_NAME="client-site"
SITE_URL="https://client.com"

echo "=== 连接 $CLIENT_NAME 站点 ==="

# 检查容器状态
echo "📊 检查容器状态..."
CONTAINER_STATUS=$(docker inspect --format='{{.State.Status}}' $CLIENT_NAME 2>/dev/null)
if [ "$CONTAINER_STATUS" = "running" ]; then
    echo "✅ 容器运行正常"
else
    echo "⚠️ 容器未运行，正在启动..."
    docker start $CLIENT_NAME
    sleep 10
fi

# 验证WordPress状态
echo "📱 验证WordPress状态..."
docker exec $CLIENT_NAME wp core verify-checksums --allow-root
docker exec $CLIENT_NAME wp db check --allow-root

# 检查网站访问
echo "🌐 检查网站访问..."
HTTP_STATUS=$(curl -s -o /dev/null -w "%{http_code}" $SITE_URL)
if [ "$HTTP_STATUS" = "200" ]; then
    echo "✅ 网站访问正常"
else
    echo "❌ 网站访问异常 - HTTP: $HTTP_STATUS"
fi

echo "🔑 管理员登录信息:"
docker exec $CLIENT_NAME wp user list --role=administrator --fields=user_login,user_email --allow-root

echo "✅ 站点连接完成"
```

### 1.2 创建内容更新备份

```bash
#!/bin/bash
# create-content-backup.sh - 创建内容更新前备份

CLIENT_NAME="client-site"
BACKUP_REASON="${1:-定期内容备份}"

echo "=== 创建 $CLIENT_NAME 内容备份 ==="

# 创建备份目录
BACKUP_DIR="backups/content-$(date +%Y%m%d_%H%M%S)"
mkdir -p $BACKUP_DIR

echo "📦 备份目录: $BACKUP_DIR"

# 备份数据库
echo "🗄️ 备份数据库..."
docker exec $CLIENT_NAME wp db export /tmp/content-backup.sql --allow-root
docker cp $CLIENT_NAME:/tmp/content-backup.sql $BACKUP_DIR/
docker exec $CLIENT_NAME rm /tmp/content-backup.sql

# 备份媒体文件
echo "🖼️ 备份媒体文件..."
docker exec $CLIENT_NAME tar -czf /tmp/uploads-backup.tar.gz wp-content/uploads/
docker cp $CLIENT_NAME:/tmp/uploads-backup.tar.gz $BACKUP_DIR/
docker exec $CLIENT_NAME rm /tmp/uploads-backup.tar.gz

# 备份主题文件
echo "🎨 备份主题文件..."
docker exec $CLIENT_NAME tar -czf /tmp/theme-backup.tar.gz wp-content/themes/
docker cp $CLIENT_NAME:/tmp/theme-backup.tar.gz $BACKUP_DIR/
docker exec $CLIENT_NAME rm /tmp/theme-backup.tar.gz

# 创建备份记录
cat > $BACKUP_DIR/backup-info.txt << EOF
备份时间: $(date)
备份原因: $BACKUP_REASON
站点名称: $CLIENT_NAME
WordPress版本: $(docker exec $CLIENT_NAME wp core version --allow-root)
活跃插件: $(docker exec $CLIENT_NAME wp plugin list --status=active --field=name --allow-root | tr '\n' ', ')
EOF

echo "✅ 内容备份完成: $BACKUP_DIR"
```

---

## 📝 Phase 2: 内容创建和编辑

### 2.1 文章管理 (CLI方式)

```bash
#!/bin/bash
# article-management.sh - 文章管理操作

CLIENT_NAME="client-site"

echo "=== $CLIENT_NAME 文章管理 ==="

# 创建新文章
create_article() {
    local title="$1"
    local content="$2"
    local category="$3"
    
    echo "📝 创建新文章: $title"
    
    POST_ID=$(docker exec $CLIENT_NAME wp post create \
        --post_title="$title" \
        --post_content="$content" \
        --post_status=publish \
        --post_category="$category" \
        --porcelain \
        --allow-root)
    
    echo "✅ 文章创建成功 - ID: $POST_ID"
    echo "🔗 文章链接: $(docker exec $CLIENT_NAME wp post url $POST_ID --allow-root)"
}

# 更新文章
update_article() {
    local post_id="$1"
    local title="$2"
    local content="$3"
    
    echo "📝 更新文章 ID: $post_id"
    
    docker exec $CLIENT_NAME wp post update $post_id \
        --post_title="$title" \
        --post_content="$content" \
        --allow-root
    
    echo "✅ 文章更新成功"
}

# 列出所有文章
list_articles() {
    echo "📋 所有文章列表:"
    docker exec $CLIENT_NAME wp post list \
        --field=ID,post_title,post_status,post_date \
        --allow-root
}

# 删除文章
delete_article() {
    local post_id="$1"
    
    echo "🗑️ 删除文章 ID: $post_id"
    docker exec $CLIENT_NAME wp post delete $post_id --force --allow-root
    echo "✅ 文章删除成功"
}

# 示例使用
create_article "公司最新动态" "<h2>重要公告</h2><p>我们很高兴地宣布...</p>" "新闻"
list_articles
```

### 2.2 页面管理 (CLI方式)

```bash
#!/bin/bash
# page-management.sh - 页面管理操作

CLIENT_NAME="client-site"

echo "=== $CLIENT_NAME 页面管理 ==="

# 创建新页面
create_page() {
    local title="$1"
    local content="$2"
    local template="$3"
    
    echo "📄 创建新页面: $title"
    
    PAGE_ID=$(docker exec $CLIENT_NAME wp post create \
        --post_type=page \
        --post_title="$title" \
        --post_content="$content" \
        --post_status=publish \
        --page_template="$template" \
        --porcelain \
        --allow-root)
    
    echo "✅ 页面创建成功 - ID: $PAGE_ID"
    echo "🔗 页面链接: $(docker exec $CLIENT_NAME wp post url $PAGE_ID --allow-root)"
}

# 更新页面内容
update_page() {
    local page_id="$1"
    local content="$2"
    
    echo "📄 更新页面 ID: $page_id"
    
    docker exec $CLIENT_NAME wp post update $page_id \
        --post_content="$content" \
        --allow-root
    
    echo "✅ 页面更新成功"
}

# 设置首页
set_homepage() {
    local page_id="$1"
    
    echo "🏠 设置首页为页面 ID: $page_id"
    
    docker exec $CLIENT_NAME wp option update show_on_front page --allow-root
    docker exec $CLIENT_NAME wp option update page_on_front $page_id --allow-root
    
    echo "✅ 首页设置成功"
}

# 列出所有页面
list_pages() {
    echo "📋 所有页面列表:"
    docker exec $CLIENT_NAME wp post list \
        --post_type=page \
        --field=ID,post_title,post_status \
        --allow-root
}

# 示例使用
create_page "关于我们" "<h1>关于我们</h1><p>公司介绍内容...</p>" "page-about.php"
list_pages
```

### 2.3 媒体管理 (CLI方式)

```bash
#!/bin/bash
# media-management.sh - 媒体文件管理

CLIENT_NAME="client-site"

echo "=== $CLIENT_NAME 媒体管理 ==="

# 上传媒体文件
upload_media() {
    local file_path="$1"
    local title="$2"
    local description="$3"
    
    echo "🖼️ 上传媒体文件: $(basename $file_path)"
    
    # 复制文件到容器
    docker cp "$file_path" $CLIENT_NAME:/tmp/upload-file
    
    # 导入媒体文件
    MEDIA_ID=$(docker exec $CLIENT_NAME wp media import /tmp/upload-file \
        --title="$title" \
        --caption="$description" \
        --porcelain \
        --allow-root)
    
    # 清理临时文件
    docker exec $CLIENT_NAME rm /tmp/upload-file
    
    echo "✅ 媒体上传成功 - ID: $MEDIA_ID"
    echo "🔗 媒体链接: $(docker exec $CLIENT_NAME wp post url $MEDIA_ID --allow-root)"
}

# 列出媒体文件
list_media() {
    echo "📋 媒体文件列表:"
    docker exec $CLIENT_NAME wp post list \
        --post_type=attachment \
        --field=ID,post_title,post_mime_type \
        --allow-root
}

# 删除媒体文件
delete_media() {
    local media_id="$1"
    
    echo "🗑️ 删除媒体文件 ID: $media_id"
    docker exec $CLIENT_NAME wp post delete $media_id --force --allow-root
    echo "✅ 媒体文件删除成功"
}

# 优化图片
optimize_images() {
    echo "🔧 优化图片设置..."
    
    # 设置图片尺寸
    docker exec $CLIENT_NAME wp option update thumbnail_size_w 150 --allow-root
    docker exec $CLIENT_NAME wp option update thumbnail_size_h 150 --allow-root
    docker exec $CLIENT_NAME wp option update medium_size_w 300 --allow-root
    docker exec $CLIENT_NAME wp option update medium_size_h 300 --allow-root
    docker exec $CLIENT_NAME wp option update large_size_w 1024 --allow-root
    docker exec $CLIENT_NAME wp option update large_size_h 1024 --allow-root
    
    echo "✅ 图片设置优化完成"
}

# 示例使用
# upload_media "./logo.png" "公司Logo" "公司官方标志"
list_media
optimize_images
```

---

## 🎨 Phase 3: 主题和样式管理

### 3.1 主题定制

```bash
#!/bin/bash
# theme-customization.sh - 主题定制操作

CLIENT_NAME="client-site"

echo "=== $CLIENT_NAME 主题定制 ==="

# 更新站点基本信息
update_site_info() {
    local site_title="$1"
    local site_description="$2"
    
    echo "🏠 更新站点信息..."
    
    docker exec $CLIENT_NAME wp option update blogname "$site_title" --allow-root
    docker exec $CLIENT_NAME wp option update blogdescription "$site_description" --allow-root
    
    echo "✅ 站点信息更新完成"
}

# 更新站点Logo
update_site_logo() {
    local logo_path="$1"
    
    echo "🎨 更新站点Logo..."
    
    # 上传Logo文件
    docker cp "$logo_path" $CLIENT_NAME:/tmp/new-logo
    LOGO_ID=$(docker exec $CLIENT_NAME wp media import /tmp/new-logo --porcelain --allow-root)
    docker exec $CLIENT_NAME rm /tmp/new-logo
    
    # 设置为站点Logo
    docker exec $CLIENT_NAME wp option update site_logo $LOGO_ID --allow-root
    
    echo "✅ Logo更新完成 - Media ID: $LOGO_ID"
}

# 自定义CSS
add_custom_css() {
    local css_content="$1"
    
    echo "🎨 添加自定义CSS..."
    
    # 创建自定义CSS文件
    echo "$css_content" | docker exec -i $CLIENT_NAME tee -a /var/www/html/wp-content/themes/active-theme/custom.css
    
    echo "✅ 自定义CSS添加完成"
}

# 菜单管理
manage_menu() {
    local menu_name="$1"
    local location="$2"
    
    echo "🧭 管理菜单: $menu_name"
    
    # 创建菜单
    MENU_ID=$(docker exec $CLIENT_NAME wp menu create "$menu_name" --porcelain --allow-root)
    
    # 添加页面到菜单
    docker exec $CLIENT_NAME wp menu item add-post $MENU_ID $(docker exec $CLIENT_NAME wp post list --post_type=page --field=ID --posts_per_page=5 --allow-root) --allow-root
    
    # 分配菜单位置
    docker exec $CLIENT_NAME wp menu location assign $MENU_ID $location --allow-root
    
    echo "✅ 菜单创建完成 - ID: $MENU_ID"
}

# 示例使用
update_site_info "客户公司官网" "专业的行业解决方案提供商"
# update_site_logo "./company-logo.png"
manage_menu "主导航" "primary"
```

### 3.2 样式更新

```bash
#!/bin/bash
# style-update.sh - 样式更新操作

CLIENT_NAME="client-site"

echo "=== $CLIENT_NAME 样式更新 ==="

# 备份当前样式
backup_styles() {
    echo "📦 备份当前样式文件..."
    
    STYLE_BACKUP_DIR="backups/styles-$(date +%Y%m%d_%H%M%S)"
    mkdir -p $STYLE_BACKUP_DIR
    
    # 备份主题样式文件
    docker exec $CLIENT_NAME find /var/www/html/wp-content/themes -name "*.css" -exec cp {} /tmp/ \;
    docker cp $CLIENT_NAME:/tmp/ $STYLE_BACKUP_DIR/
    
    echo "✅ 样式备份完成: $STYLE_BACKUP_DIR"
}

# 更新CSS变量
update_css_variables() {
    local primary_color="$1"
    local secondary_color="$2"
    local font_family="$3"
    
    echo "🎨 更新CSS变量..."
    
    # 创建CSS变量文件
    cat > /tmp/custom-variables.css << EOF
:root {
    --primary-color: $primary_color;
    --secondary-color: $secondary_color;
    --font-family: $font_family;
}
EOF
    
    # 复制到容器
    docker cp /tmp/custom-variables.css $CLIENT_NAME:/var/www/html/wp-content/themes/active-theme/
    rm /tmp/custom-variables.css
    
    echo "✅ CSS变量更新完成"
}

# 响应式样式调整
update_responsive_styles() {
    echo "📱 更新响应式样式..."
    
    cat > /tmp/responsive.css << EOF
@media (max-width: 768px) {
    .container {
        padding: 10px;
    }
    
    .navbar {
        flex-direction: column;
    }
}

@media (max-width: 480px) {
    .hero-title {
        font-size: 1.5rem;
    }
    
    .button {
        width: 100%;
    }
}
EOF
    
    docker cp /tmp/responsive.css $CLIENT_NAME:/var/www/html/wp-content/themes/active-theme/
    rm /tmp/responsive.css
    
    echo "✅ 响应式样式更新完成"
}

# 验证样式更新
verify_styles() {
    echo "✅ 验证样式更新..."
    
    # 检查CSS文件
    docker exec $CLIENT_NAME ls -la /var/www/html/wp-content/themes/active-theme/*.css
    
    # 测试网站访问
    HTTP_STATUS=$(curl -s -o /dev/null -w "%{http_code}" https://client.com/)
    echo "网站状态: $HTTP_STATUS"
    
    # 检查CSS加载
    curl -I https://client.com/wp-content/themes/active-theme/style.css
}

# 示例使用
backup_styles
update_css_variables "#007cba" "#005a87" "'Helvetica Neue', sans-serif"
update_responsive_styles
verify_styles
```

---

## 🔧 Phase 4: 用户和权限管理

### 4.1 用户管理

```bash
#!/bin/bash
# user-management.sh - 用户管理操作

CLIENT_NAME="client-site"

echo "=== $CLIENT_NAME 用户管理 ==="

# 创建新用户
create_user() {
    local username="$1"
    local email="$2"
    local role="$3"
    local password="$4"
    
    echo "👤 创建新用户: $username"
    
    USER_ID=$(docker exec $CLIENT_NAME wp user create $username $email \
        --role=$role \
        --user_pass=$password \
        --porcelain \
        --allow-root)
    
    echo "✅ 用户创建成功 - ID: $USER_ID"
}

# 更新用户信息
update_user() {
    local user_id="$1"
    local field="$2"
    local value="$3"
    
    echo "👤 更新用户 ID: $user_id"
    
    docker exec $CLIENT_NAME wp user update $user_id --$field="$value" --allow-root
    
    echo "✅ 用户信息更新完成"
}

# 列出所有用户
list_users() {
    echo "📋 用户列表:"
    docker exec $CLIENT_NAME wp user list \
        --fields=ID,user_login,user_email,roles \
        --allow-root
}

# 删除用户
delete_user() {
    local user_id="$1"
    local reassign_to="$2"
    
    echo "🗑️ 删除用户 ID: $user_id"
    
    if [ -n "$reassign_to" ]; then
        docker exec $CLIENT_NAME wp user delete $user_id --reassign=$reassign_to --allow-root
    else
        docker exec $CLIENT_NAME wp user delete $user_id --allow-root
    fi
    
    echo "✅ 用户删除成功"
}

# 重置用户密码
reset_password() {
    local username="$1"
    local new_password="$2"
    
    echo "🔑 重置用户密码: $username"
    
    docker exec $CLIENT_NAME wp user update $username --user_pass=$new_password --allow-root
    
    echo "✅ 密码重置完成"
}

# 示例使用
list_users
# create_user "editor01" "editor@client.com" "editor" "secure_password_123"
```

### 4.2 权限管理

```bash
#!/bin/bash
# permission-management.sh - 权限管理操作

CLIENT_NAME="client-site"

echo "=== $CLIENT_NAME 权限管理 ==="

# 检查用户权限
check_permissions() {
    local username="$1"
    
    echo "🔍 检查用户权限: $username"
    
    docker exec $CLIENT_NAME wp user get $username --fields=roles,allcaps --allow-root
}

# 分配用户角色
assign_role() {
    local user_id="$1"
    local role="$2"
    
    echo "🎭 分配角色: $role 给用户 ID: $user_id"
    
    docker exec $CLIENT_NAME wp user set-role $user_id $role --allow-root
    
    echo "✅ 角色分配完成"
}

# 列出所有角色
list_roles() {
    echo "📋 系统角色列表:"
    docker exec $CLIENT_NAME wp role list --allow-root
}

# 创建自定义角色
create_custom_role() {
    local role_name="$1"
    local display_name="$2"
    local capabilities="$3"
    
    echo "🎭 创建自定义角色: $role_name"
    
    docker exec $CLIENT_NAME wp role create $role_name "$display_name" --allow-root
    
    # 添加权限
    if [ -n "$capabilities" ]; then
        IFS=',' read -ra CAPS <<< "$capabilities"
        for cap in "${CAPS[@]}"; do
            docker exec $CLIENT_NAME wp cap add $role_name $cap --allow-root
        done
    fi
    
    echo "✅ 自定义角色创建完成"
}

# 示例使用
list_roles
check_permissions "admin"
# create_custom_role "content_manager" "内容管理员" "edit_posts,edit_pages,upload_files"
```

---

## 📊 Phase 5: 内容分析和报告

### 5.1 内容统计

```bash
#!/bin/bash
# content-analytics.sh - 内容分析统计

CLIENT_NAME="client-site"

echo "=== $CLIENT_NAME 内容分析 ==="

# 生成内容报告
generate_content_report() {
    local report_file="reports/content-report-$(date +%Y%m%d).html"
    
    echo "📊 生成内容报告..."
    
    cat > $report_file << EOF
<!DOCTYPE html>
<html>
<head>
    <title>内容分析报告 - $(date +%Y年%m月%d日)</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .section { margin: 20px 0; padding: 15px; border: 1px solid #ddd; border-radius: 5px; }
        .number { font-size: 2em; color: #007cba; font-weight: bold; }
    </style>
</head>
<body>
    <h1>$CLIENT_NAME 内容分析报告</h1>
    <p>报告生成时间: $(date)</p>
    
    <div class="section">
        <h2>📝 文章统计</h2>
        <p>发布文章数: <span class="number">$(docker exec $CLIENT_NAME wp post list --post_status=publish --field=ID --allow-root | wc -l)</span></p>
        <p>草稿文章数: <span class="number">$(docker exec $CLIENT_NAME wp post list --post_status=draft --field=ID --allow-root | wc -l)</span></p>
        <p>待审核文章: <span class="number">$(docker exec $CLIENT_NAME wp post list --post_status=pending --field=ID --allow-root | wc -l)</span></p>
    </div>
    
    <div class="section">
        <h2>📄 页面统计</h2>
        <p>发布页面数: <span class="number">$(docker exec $CLIENT_NAME wp post list --post_type=page --post_status=publish --field=ID --allow-root | wc -l)</span></p>
        <p>草稿页面数: <span class="number">$(docker exec $CLIENT_NAME wp post list --post_type=page --post_status=draft --field=ID --allow-root | wc -l)</span></p>
    </div>
    
    <div class="section">
        <h2>🖼️ 媒体统计</h2>
        <p>媒体文件数: <span class="number">$(docker exec $CLIENT_NAME wp post list --post_type=attachment --field=ID --allow-root | wc -l)</span></p>
        <p>图片文件数: <span class="number">$(docker exec $CLIENT_NAME wp post list --post_type=attachment --post_mime_type=image --field=ID --allow-root | wc -l)</span></p>
    </div>
    
    <div class="section">
        <h2>👥 用户统计</h2>
        <p>总用户数: <span class="number">$(docker exec $CLIENT_NAME wp user list --field=ID --allow-root | wc -l)</span></p>
        <p>管理员数: <span class="number">$(docker exec $CLIENT_NAME wp user list --role=administrator --field=ID --allow-root | wc -l)</span></p>
        <p>编辑者数: <span class="number">$(docker exec $CLIENT_NAME wp user list --role=editor --field=ID --allow-root | wc -l)</span></p>
    </div>
    
    <div class="section">
        <h2>💬 评论统计</h2>
        <p>已发布评论: <span class="number">$(docker exec $CLIENT_NAME wp comment list --status=approve --field=ID --allow-root | wc -l)</span></p>
        <p>待审核评论: <span class="number">$(docker exec $CLIENT_NAME wp comment list --status=hold --field=ID --allow-root | wc -l)</span></p>
        <p>垃圾评论: <span class="number">$(docker exec $CLIENT_NAME wp comment list --status=spam --field=ID --allow-root | wc -l)</span></p>
    </div>
</body>
</html>
EOF
    
    echo "✅ 内容报告生成完成: $report_file"
}

# 分析内容趋势
analyze_content_trends() {
    echo "📈 分析内容发布趋势..."
    
    echo "最近30天发布的文章:"
    docker exec $CLIENT_NAME wp post list \
        --post_status=publish \
        --after="30 days ago" \
        --field=post_title,post_date \
        --allow-root
    
    echo "最受欢迎的分类:"
    docker exec $CLIENT_NAME wp term list category \
        --field=name,count \
        --orderby=count \
        --order=desc \
        --allow-root
}

# 内容质量检查
check_content_quality() {
    echo "🔍 检查内容质量..."
    
    # 检查空内容
    echo "空内容文章数:"
    docker exec $CLIENT_NAME wp post list \
        --post_status=publish \
        --field=ID \
        --allow-root | while read post_id; do
        content_length=$(docker exec $CLIENT_NAME wp post get $post_id --field=post_content --allow-root | wc -c)
        if [ $content_length -lt 100 ]; then
            echo "文章 ID $post_id 内容过短 ($content_length 字符)"
        fi
    done
    
    # 检查缺少特色图片的文章
    echo "缺少特色图片的文章:"
    docker exec $CLIENT_NAME wp post list \
        --post_status=publish \
        --meta_key=_thumbnail_id \
        --meta_compare=NOT EXISTS \
        --field=ID,post_title \
        --allow-root
}

# 示例使用
generate_content_report
analyze_content_trends
check_content_quality
```

---

## 📋 内容管理检查清单

### 日常内容管理
- [ ] 检查新评论和回复
- [ ] 更新重要页面内容
- [ ] 发布新文章或动态
- [ ] 检查并修复失效链接
- [ ] 优化图片文件大小

### 周度内容维护
- [ ] 审核用户提交的内容
- [ ] 更新菜单和导航结构
- [ ] 检查SEO设置和meta信息
- [ ] 备份重要内容变更
- [ ] 分析内容性能数据

### 月度内容审查
- [ ] 生成内容分析报告
- [ ] 清理过期或无用内容
- [ ] 优化网站内容结构
- [ ] 更新公司信息和联系方式
- [ ] 制定下月内容计划

---

## 🎯 内容管理最佳实践

### 1. 内容质量标准
- 确保所有内容都有明确的目标受众
- 保持品牌声音和风格的一致性
- 定期更新过时信息
- 使用高质量的图片和媒体

### 2. SEO友好内容
- 每个页面都有独特的标题和描述
- 使用合适的标题层级结构
- 添加alt标签给所有图片
- 内部链接结构合理

### 3. 用户体验优化
- 保持网站导航简洁明了
- 确保所有页面加载速度快
- 提供清晰的联系方式
- 定期测试表单和功能

### 4. 安全和备份
- 定期备份所有内容更改
- 使用强密码和双因素认证
- 限制用户权限到最低需要
- 监控异常活动和登录

---

**通过这套完整的内容管理手册，确保客户WordPress站点的内容始终保持新鲜、准确和用户友好。**
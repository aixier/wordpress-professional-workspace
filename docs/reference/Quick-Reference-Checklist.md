# WordPress迁移快速参考检查表

## 🚀 快速启动模板

### 项目初始化 (5分钟)
```bash
# 1. 创建项目目录
mkdir /path/to/[client-name]-wordpress-migration
cd /path/to/[client-name]-wordpress-migration

# 2. 创建标准目录结构
mkdir -p {original-site,themes,backups,documentation,assets}

# 3. 分析原网站
find /path/to/original-site -name "*.html" > analysis/html-files.txt
find /path/to/original-site -name "*.css" > analysis/css-files.txt

# 4. 启动Docker环境
docker network create [client-name]_network
```

### Docker环境快速部署 (3分钟)
```bash
# MySQL容器
docker run -d --name [client-name]_mysql --network [client-name]_network \
  -e MYSQL_ROOT_PASSWORD=secure_password -e MYSQL_DATABASE=wordpress \
  -e MYSQL_USER=wordpress -e MYSQL_PASSWORD=wordpress mysql:5.7

# WordPress容器
docker run -d --name [client-name]_wp --network [client-name]_network \
  -p 8080:80 -e WORDPRESS_DB_HOST=[client-name]_mysql \
  -e WORDPRESS_DB_USER=wordpress -e WORDPRESS_DB_PASSWORD=wordpress \
  -e WORDPRESS_DB_NAME=wordpress wordpress

# 验证环境
sleep 30 && curl -I http://localhost:8080/
```

---

## ✅ 迁移检查清单

### Phase 1: 准备阶段 (20分钟)
- [ ] 原网站文件完整复制到项目目录
- [ ] 分析主要HTML文件结构
- [ ] 识别CSS文件和依赖关系
- [ ] 列出所有媒体文件(图片、视频)
- [ ] 识别JavaScript功能和第三方库
- [ ] 确定品牌颜色、字体和设计系统
- [ ] Docker环境启动并验证

### Phase 2: 基础主题创建 (15分钟)
- [ ] 创建主题目录结构
- [ ] 编写基础style.css头部信息
- [ ] 创建最小可行index.php
- [ ] 编写基础functions.php
- [ ] 复制主题到WordPress容器
- [ ] 激活主题并验证加载

### Phase 3: 内容迁移 (30-60分钟)
- [ ] 复制原网站完整HTML结构到index.php
- [ ] 添加WordPress头部和尾部调用
- [ ] 复制所有CSS样式
- [ ] 迁移JavaScript功能
- [ ] 上传所有媒体文件
- [ ] 更新资源路径引用
- [ ] 测试所有链接和功能

### Phase 4: 质量验证 (20分钟)
- [ ] 页面加载正常(HTTP 200)
- [ ] 样式完全一致
- [ ] JavaScript功能正常
- [ ] 移动端响应式测试
- [ ] 图片和媒体显示正常
- [ ] 导航功能测试
- [ ] 表单功能测试(如有)

### Phase 5: 最终确认 (10分钟)
- [ ] 与原网站并排对比验证
- [ ] 性能测试(加载时间)
- [ ] 跨浏览器兼容性检查
- [ ] 创建项目文档
- [ ] 完整备份
- [ ] 交付确认

---

## 🔧 常用命令速查

### Docker操作
```bash
# 查看容器状态
docker ps --filter "name=[client-name]"

# 重启所有容器
docker restart [client-name]_mysql [client-name]_wp

# 复制文件到容器
docker cp local-file.php [client-name]_wp:/var/www/html/wp-content/themes/[client-name]-theme/

# 从容器复制文件
docker cp [client-name]_wp:/var/www/html/wp-content/themes/[client-name]-theme/index.php ./backup-index.php

# 进入容器
docker exec -it [client-name]_wp bash
```

### 快速测试命令
```bash
# 测试页面响应
curl -I http://localhost:8080/

# 检查特定内容
curl -s http://localhost:8080/ | grep "关键词"

# 测试CSS文件
curl -I http://localhost:8080/wp-content/themes/[client-name]-theme/style.css

# 测试加载时间
time curl -s http://localhost:8080/ > /dev/null
```

### 备份操作
```bash
# 快速备份
mkdir backup-$(date +%Y%m%d_%H%M%S)
docker cp [client-name]_wp:/var/www/html/wp-content/themes/[client-name]-theme backup-$(date +%Y%m%d_%H%M%S)/
docker exec [client-name]_mysql mysqldump -uwordpress -pwordpress wordpress > backup-$(date +%Y%m%d_%H%M%S)/db.sql
```

---

## 🎨 主题文件模板

### 最小index.php模板
```php
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title('|', true, 'right'); bloginfo('name'); ?></title>
    
    <!-- 外部资源 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <?php wp_head(); ?>
    
    <!-- 内联样式 -->
    <style>
        /* 原网站CSS内容 */
    </style>
</head>
<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    
    <!-- 原网站HTML内容 -->
    
    <?php wp_footer(); ?>
</body>
</html>
```

### 基础functions.php
```php
<?php
if (!defined('ABSPATH')) exit;

function client_theme_setup() {
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
}
add_action('after_setup_theme', 'client_theme_setup');

function client_dequeue_wp_styles() {
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('classic-theme-styles');
}
add_action('wp_enqueue_scripts', 'client_dequeue_wp_styles', 100);
?>
```

### style.css头部
```css
/*
Theme Name: [客户名称] Theme
Description: Custom WordPress theme for [客户名称]
Author: [开发团队]
Version: 1.0.0
Text Domain: [client-name]
*/
```

---

## ⚠️ 常见错误避免

### 错误1: 主题无法激活
**原因**: 缺少必需文件或PHP语法错误
**解决**: 确保style.css和index.php存在且语法正确

### 错误2: 样式不显示
**原因**: CSS路径错误或WordPress默认样式冲突
**解决**: 检查文件路径，添加wp_dequeue_style移除默认样式

### 错误3: 页面显示空白
**原因**: PHP错误或主题文件权限问题
**解决**: 检查Docker logs，验证文件权限

### 错误4: 数据库连接失败
**原因**: 容器网络问题或凭据错误
**解决**: 验证容器网络连接，确认数据库凭据

### 错误5: 图片无法显示
**原因**: 文件路径错误或文件未上传
**解决**: 检查媒体文件路径，确认文件已正确复制

---

## 📊 质量标准

### 视觉一致性 (95%+)
- 布局结构完全一致
- 颜色系统100%准确
- 字体样式完全匹配
- 间距和尺寸准确

### 功能完整性 (100%)
- 所有链接正常工作
- JavaScript功能正常
- 表单提交正常
- 导航菜单正常

### 性能标准
- 页面加载时间 ≤ 原网站的120%
- 所有资源正常加载
- 无404错误
- 移动端正常显示

### 技术规范
- HTML语法正确
- CSS样式有效
- JavaScript无错误
- WordPress标准兼容

---

## 🕐 时间估算

### 简单网站 (单页面，基础样式)
- 准备阶段: 15分钟
- 环境搭建: 10分钟
- 内容迁移: 30分钟
- 测试验证: 15分钟
- **总计: 70分钟**

### 中等复杂网站 (多页面，中等交互)
- 准备阶段: 30分钟
- 环境搭建: 15分钟
- 内容迁移: 90分钟
- 测试验证: 30分钟
- **总计: 165分钟**

### 复杂网站 (多页面，复杂功能)
- 准备阶段: 60分钟
- 环境搭建: 20分钟
- 内容迁移: 180分钟
- 测试验证: 60分钟
- **总计: 320分钟**

---

## 📞 应急联系指南

### 迁移失败应急流程
1. **立即停止操作**
2. **记录错误信息**
3. **回滚到备份状态**
4. **分析问题根因**
5. **制定解决方案**
6. **重新执行迁移**

### 快速恢复命令
```bash
# 恢复最新备份
LATEST_BACKUP=$(ls -1t backups/ | head -1)
docker cp backups/$LATEST_BACKUP/[client-name]-theme/. [client-name]_wp:/var/www/html/wp-content/themes/[client-name]-theme/

# 重启服务
docker restart [client-name]_wp

# 验证恢复
curl -I http://localhost:8080/
```

---

这个快速参考检查表提供了迁移过程中的所有关键步骤和常用命令，确保每次迁移都能高效、准确地完成。
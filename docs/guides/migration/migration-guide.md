# WordPress网站迁移标准作业流程 (SOP)

## 📋 概述
本手册提供从静态HTML网站迁移到WordPress的完整标准化流程，确保迁移过程高效、准确且避免常见错误。

## 🎯 迁移目标
- 保持原网站的所有内容、样式、布局和功能
- 确保响应式设计和用户体验不变
- 建立可维护的WordPress主题结构
- 实现无损迁移和快速部署

---

## 📁 Phase 1: 前期准备与分析

### 1.1 项目环境设置
```bash
# 创建项目目录
mkdir /path/to/client-website-migration
cd /path/to/client-website-migration

# 创建标准目录结构
mkdir -p {original-site,themes,backups,documentation,assets}
```

### 1.2 原网站分析清单
**✅ 必须完成的分析项目：**

1. **文件结构分析**
   ```bash
   # 列出所有文件和目录
   find /path/to/original-site -type f -name "*.html" > html-files.txt
   find /path/to/original-site -type f -name "*.css" > css-files.txt
   find /path/to/original-site -type f -name "*.js" > js-files.txt
   find /path/to/original-site -type f \( -name "*.jpg" -o -name "*.png" -o -name "*.svg" -o -name "*.mp4" \) > media-files.txt
   ```

2. **关键内容识别**
   - [ ] 主页面内容 (`index.html` 或主要HTML文件)
   - [ ] 导航结构和菜单
   - [ ] 品牌元素 (logo, 配色方案, 字体)
   - [ ] 核心功能和交互元素
   - [ ] 媒体文件位置和使用情况

3. **技术栈分析**
   - [ ] CSS框架 (Bootstrap, Tailwind等)
   - [ ] JavaScript库 (jQuery, React等)
   - [ ] 字体系统 (Google Fonts, 自定义字体)
   - [ ] 图标库 (Font Awesome, Bootstrap Icons等)
   - [ ] 第三方服务集成

4. **设计系统提取**
   ```bash
   # 提取CSS变量和颜色系统
   grep -r ":root\|--.*:" /path/to/original-site/ > design-system.txt
   grep -r "color:\|background:" /path/to/original-site/ | head -50 > color-palette.txt
   ```

### 1.3 创建项目文档
```markdown
# 项目迁移记录
- 客户名称: [客户名称]
- 原网站路径: [路径]
- 迁移开始时间: [时间]
- 预计完成时间: [时间]
- 主要页面数量: [数量]
- 特殊功能需求: [列表]
```

---

## 🐳 Phase 2: Docker环境搭建

### 2.1 创建Docker网络
```bash
# 创建专用网络
docker network create [client-name]_network
```

### 2.2 启动MySQL数据库
```bash
# 启动MySQL容器
docker run -d --name [client-name]_mysql \
  --network [client-name]_network \
  -e MYSQL_ROOT_PASSWORD=secure_password \
  -e MYSQL_DATABASE=wordpress \
  -e MYSQL_USER=wordpress \
  -e MYSQL_PASSWORD=wordpress \
  -v $(pwd)/mysql-data:/var/lib/mysql \
  mysql:5.7
```

### 2.3 启动WordPress容器
```bash
# 启动WordPress容器
docker run -d --name [client-name]_wp \
  --network [client-name]_network \
  -p 8080:80 \
  -e WORDPRESS_DB_HOST=[client-name]_mysql \
  -e WORDPRESS_DB_USER=wordpress \
  -e WORDPRESS_DB_PASSWORD=wordpress \
  -e WORDPRESS_DB_NAME=wordpress \
  -e WORDPRESS_DEBUG=1 \
  wordpress
```

### 2.4 启动phpMyAdmin (可选)
```bash
# 启动phpMyAdmin
docker run -d --name [client-name]_pma \
  --network [client-name]_network \
  -p 8081:80 \
  -e PMA_HOST=[client-name]_mysql \
  -e PMA_USER=wordpress \
  -e PMA_PASSWORD=wordpress \
  phpmyadmin
```

### 2.5 验证环境
```bash
# 等待容器启动
sleep 30

# 测试WordPress连接
curl -I http://localhost:8080/

# 检查容器状态
docker ps --filter "name=[client-name]" --format "table {{.Names}}\t{{.Status}}\t{{.Ports}}"
```

---

## 🎨 Phase 3: WordPress主题创建

### 3.1 创建主题基础结构
```bash
# 创建主题目录
mkdir -p themes/[client-name]-theme/{assets/{css,js,images,fonts},inc,template-parts}

# 创建必需文件
touch themes/[client-name]-theme/{style.css,index.php,functions.php,header.php,footer.php}
```

### 3.2 style.css (主题头部信息)
```css
/*
Theme Name: [客户名称] Theme
Description: Custom WordPress theme for [客户名称]
Author: [开发团队名称]
Version: 1.0.0
Text Domain: [client-name]
*/

/* 这里将包含所有原网站的CSS样式 */
```

### 3.3 创建最小可行主题
**index.php (最小版本)**
```php
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php bloginfo('name'); ?> - Test Page</title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    
    <div style="max-width: 800px; margin: 50px auto; padding: 40px; text-align: center; font-family: Arial, sans-serif;">
        <h1>🎉 [客户名称] WordPress主题测试成功！</h1>
        <p>主题基础结构已创建，准备开始内容迁移。</p>
        <p><strong>WordPress版本：</strong><?php echo get_bloginfo('version'); ?></p>
        <p><strong>主题名称：</strong><?php echo wp_get_theme()->get('Name'); ?></p>
    </div>
    
    <?php wp_footer(); ?>
</body>
</html>
```

### 3.4 基础functions.php
```php
<?php
/**
 * [客户名称] Theme Functions
 */

// 防止直接访问
if (!defined('ABSPATH')) {
    exit;
}

// 主题设置
function client_theme_setup() {
    // 添加主题支持
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    add_theme_support('custom-logo');
    
    // 注册菜单
    register_nav_menus(array(
        'primary' => __('主导航', '[client-name]'),
        'footer' => __('页脚导航', '[client-name]'),
    ));
}
add_action('after_setup_theme', 'client_theme_setup');

// 移除WordPress默认样式
function client_dequeue_wp_styles() {
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('classic-theme-styles');
}
add_action('wp_enqueue_scripts', 'client_dequeue_wp_styles', 100);
?>
```

### 3.5 测试基础主题
```bash
# 复制主题到容器
docker cp themes/[client-name]-theme/. [client-name]_wp:/var/www/html/wp-content/themes/[client-name]-theme/

# 通过数据库激活主题
docker exec [client-name]_mysql mysql -uwordpress -pwordpress wordpress -e "UPDATE wp_options SET option_value='[client-name]-theme' WHERE option_name='template'"

# 测试主题加载
curl -s http://localhost:8080/ | grep -i "主题测试成功"
```

---

## 🔄 Phase 4: 内容迁移实施

### 4.1 HTML内容分析与提取
```bash
# 读取原始HTML文件
# 提取<head>部分的重要信息
grep -A 50 "<head>" /path/to/original/index.html > head-content.txt

# 提取主要内容区域
grep -A 100 "<body>\|<main>\|class.*hero\|class.*content" /path/to/original/index.html > body-content.txt
```

### 4.2 CSS样式迁移
**步骤：**
1. **完整复制原始CSS**
   ```bash
   # 复制所有CSS文件到主题目录
   cp /path/to/original-site/*.css themes/[client-name]-theme/assets/css/
   ```

2. **整合到WordPress主题**
   ```php
   // 在functions.php中添加样式加载
   function client_enqueue_styles() {
       wp_enqueue_style('[client-name]-main', get_template_directory_uri() . '/assets/css/main.css', array(), '1.0.0');
   }
   add_action('wp_enqueue_scripts', 'client_enqueue_styles');
   ```

### 4.3 JavaScript功能迁移
```php
// 在functions.php中添加脚本加载
function client_enqueue_scripts() {
    wp_enqueue_script('[client-name]-main', get_template_directory_uri() . '/assets/js/main.js', array(), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'client_enqueue_scripts');
```

### 4.4 创建完整index.php
**模板结构：**
```php
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title('|', true, 'right'); bloginfo('name'); ?></title>
    
    <!-- 原始网站的外部资源 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- 其他外部资源... -->
    
    <?php wp_head(); ?>
    
    <!-- 原始网站的内联样式 -->
    <style>
        /* 复制原始网站的完整CSS */
    </style>
</head>
<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    
    <!-- 导航区域 -->
    <nav>
        <!-- 复制原始导航结构，添加WordPress菜单集成 -->
    </nav>
    
    <!-- 主内容区域 -->
    <main>
        <!-- 复制原始网站的完整HTML结构 -->
    </main>
    
    <!-- 页脚区域 -->
    <footer>
        <!-- 复制原始页脚结构 -->
    </footer>
    
    <?php wp_footer(); ?>
</body>
</html>
```

### 4.5 媒体文件迁移
```bash
# 复制图片和媒体文件
docker cp /path/to/original-site/images/. [client-name]_wp:/var/www/html/wp-content/themes/[client-name]-theme/assets/images/
docker cp /path/to/original-site/*.mp4 [client-name]_wp:/var/www/html/wp-content/themes/[client-name]-theme/assets/
```

---

## ✅ Phase 5: 质量检查与验证

### 5.1 功能测试清单
- [ ] 页面加载正常 (HTTP 200状态)
- [ ] 所有CSS样式正确应用
- [ ] JavaScript功能正常工作
- [ ] 导航链接功能正常
- [ ] 响应式设计在移动设备上正常
- [ ] 图片和媒体文件正确显示
- [ ] 字体加载正确
- [ ] 配色方案与原网站一致

### 5.2 对比测试
```bash
# 截图对比 (需要安装screenshot工具)
# 原网站截图
# 新WordPress网站截图
# 并排对比验证

# 内容一致性检查
curl -s http://localhost:8080/ | grep -o "<title>.*</title>" 
curl -s http://localhost:8080/ | grep -E "(主要标题|核心内容)" | head -5
```

### 5.3 性能测试
```bash
# 页面加载时间测试
time curl -s http://localhost:8080/ > /dev/null

# 资源加载检查
curl -I http://localhost:8080/wp-content/themes/[client-name]-theme/assets/css/main.css
```

---

## 📚 Phase 6: 文档化与交付

### 6.1 创建项目交付文档
```markdown
# [客户名称] WordPress迁移完成报告

## 迁移摘要
- 迁移时间: [日期]
- 原网站: [路径]
- WordPress地址: http://localhost:8080/
- 主题名称: [客户名称] Theme

## 迁移内容
- ✅ 完整页面结构
- ✅ 所有CSS样式
- ✅ JavaScript功能
- ✅ 媒体文件
- ✅ 响应式设计

## 技术规格
- WordPress版本: [版本]
- PHP版本: [版本]
- MySQL版本: [版本]
- 主题文件位置: /wp-content/themes/[client-name]-theme/

## 后续维护要点
[维护说明]
```

### 6.2 备份与版本控制
```bash
# 创建主题备份
tar -czf [client-name]-theme-backup-$(date +%Y%m%d).tar.gz themes/[client-name]-theme/

# 导出数据库
docker exec [client-name]_mysql mysqldump -uwordpress -pwordpress wordpress > wordpress-backup-$(date +%Y%m%d).sql
```

---

## 🔧 故障排除指南

### 常见问题解决方案

**问题1: 页面显示空白**
```bash
# 检查主题文件权限
docker exec [client-name]_wp ls -la /var/www/html/wp-content/themes/

# 检查PHP错误
docker logs [client-name]_wp | tail -20
```

**问题2: CSS样式不生效**
```bash
# 验证CSS文件路径
curl -I http://localhost:8080/wp-content/themes/[client-name]-theme/assets/css/main.css

# 检查functions.php中的样式加载
docker exec [client-name]_wp grep -n "wp_enqueue_style" /var/www/html/wp-content/themes/[client-name]-theme/functions.php
```

**问题3: 数据库连接问题**
```bash
# 检查容器网络连接
docker network inspect [client-name]_network

# 验证数据库凭据
docker exec [client-name]_mysql mysql -uwordpress -pwordpress wordpress -e "SELECT 1"
```

---

## 📋 检查清单总结

### 迁移前检查
- [ ] 原网站完整分析完成
- [ ] Docker环境正常运行
- [ ] 备份策略制定完成
- [ ] 时间计划确认

### 迁移中检查
- [ ] 主题基础结构创建
- [ ] 最小可行版本测试通过
- [ ] 内容逐步迁移验证
- [ ] 样式和功能完整性检查

### 迁移后检查
- [ ] 所有页面功能正常
- [ ] 跨浏览器兼容性测试
- [ ] 移动端响应式测试
- [ ] 性能优化完成
- [ ] 文档交付完整

---

## 🎯 成功标准
1. **视觉一致性**: 新WordPress网站与原网站视觉效果100%一致
2. **功能完整性**: 所有原有功能在WordPress中正常工作
3. **性能标准**: 页面加载时间不超过原网站的120%
4. **响应式设计**: 在所有设备上显示正常
5. **SEO友好**: 保持原网站的SEO结构和元数据

此SOP确保每次迁移都能达到一致的高质量标准，避免常见错误，提高工作效率。
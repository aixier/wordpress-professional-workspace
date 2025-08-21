# WordPress网站内容更新手册

## 📋 概述
本手册提供WordPress网站迁移完成后的内容管理、更新和维护的标准化流程。适用于已完成迁移的WordPress网站的日常内容管理。

---

## 🎯 内容更新策略

### 更新类型分类
1. **紧急更新**: 错误修复、安全补丁
2. **常规更新**: 文字内容、图片替换
3. **功能更新**: 新页面、新功能模块
4. **设计更新**: 样式调整、布局优化

---

## 🔧 Phase 1: 开发环境准备

### 1.1 连接到现有WordPress环境
```bash
# 检查现有容器状态
docker ps --filter "name=[client-name]" --format "table {{.Names}}\t{{.Status}}\t{{.Ports}}"

# 如果容器未运行，重新启动
docker start [client-name]_mysql [client-name]_wp [client-name]_pma

# 验证网站访问
curl -I http://localhost:8080/
```

### 1.2 备份当前状态
```bash
# 创建备份目录
mkdir -p backups/$(date +%Y%m%d_%H%M%S)

# 备份主题文件
docker cp [client-name]_wp:/var/www/html/wp-content/themes/[client-name]-theme backups/$(date +%Y%m%d_%H%M%S)/

# 备份数据库
docker exec [client-name]_mysql mysqldump -uwordpress -pwordpress wordpress > backups/$(date +%Y%m%d_%H%M%S)/wordpress-backup.sql

# 创建备份日志
echo "备份时间: $(date)" > backups/$(date +%Y%m%d_%H%M%S)/backup-log.txt
echo "备份原因: [更新原因]" >> backups/$(date +%Y%m%d_%H%M%S)/backup-log.txt
```

---

## 📝 Phase 2: 内容更新操作

### 2.1 文字内容更新

**方法1: 直接编辑主题文件**
```bash
# 从容器复制文件到本地
docker cp [client-name]_wp:/var/www/html/wp-content/themes/[client-name]-theme/index.php ./temp-index.php

# 编辑文件 (使用文本编辑器)
# 修改完成后复制回容器
docker cp ./temp-index.php [client-name]_wp:/var/www/html/wp-content/themes/[client-name]-theme/index.php

# 验证更改
curl -s http://localhost:8080/ | grep "新内容关键词"
```

**方法2: 使用WordPress后台**
```bash
# 访问WordPress后台
# http://localhost:8080/wp-admin/

# 创建管理员账户 (如果还未创建)
docker exec [client-name]_wp wp --allow-root user create admin admin@example.com --role=administrator --user_pass=admin_password
```

### 2.2 图片和媒体更新

**更新步骤：**
```bash
# 1. 准备新的媒体文件
mkdir temp-media
# 将新的图片文件放到temp-media目录

# 2. 备份原始媒体文件
docker cp [client-name]_wp:/var/www/html/wp-content/themes/[client-name]-theme/assets/images/ ./backup-images/

# 3. 上传新媒体文件
docker cp temp-media/new-image.jpg [client-name]_wp:/var/www/html/wp-content/themes/[client-name]-theme/assets/images/

# 4. 更新HTML中的引用
# 编辑主题文件，更新图片路径
```

### 2.3 样式更新 (CSS修改)

**小幅样式调整：**
```bash
# 复制CSS文件到本地
docker cp [client-name]_wp:/var/www/html/wp-content/themes/[client-name]-theme/style.css ./temp-style.css

# 编辑CSS文件
# 例如：修改颜色、字体大小、间距等

# 复制回容器
docker cp ./temp-style.css [client-name]_wp:/var/www/html/wp-content/themes/[client-name]-theme/style.css

# 清除浏览器缓存并验证
curl -s http://localhost:8080/ | head -20
```

**重大样式更改：**
```bash
# 创建新的CSS文件版本
cp style.css style-v2.css

# 在functions.php中更新版本号
# wp_enqueue_style('[client-name]-main', get_template_directory_uri() . '/style.css', array(), '2.0.0');

# 测试更改
curl -I http://localhost:8080/wp-content/themes/[client-name]-theme/style.css
```

---

## 🏗️ Phase 3: 功能模块更新

### 3.1 添加新页面

**创建新页面模板：**
```php
<?php
/*
Template Name: 新页面模板
*/
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新页面标题</title>
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>
    
    <!-- 复制原网站的导航结构 -->
    <nav>
        <!-- 导航内容 -->
    </nav>
    
    <!-- 新页面内容 -->
    <main>
        <h1>新页面内容</h1>
        <!-- 页面具体内容 -->
    </main>
    
    <!-- 复制原网站的页脚结构 -->
    <footer>
        <!-- 页脚内容 -->
    </footer>
    
    <?php wp_footer(); ?>
</body>
</html>
```

```bash
# 上传新页面模板
docker cp page-new.php [client-name]_wp:/var/www/html/wp-content/themes/[client-name]-theme/

# 在WordPress后台创建新页面并指定模板
```

### 3.2 修改导航菜单

**更新导航链接：**
```bash
# 编辑主题文件中的导航部分
docker cp [client-name]_wp:/var/www/html/wp-content/themes/[client-name]-theme/index.php ./temp-index.php

# 修改导航HTML结构
# 例如：添加新的菜单项、更改链接地址

# 上传修改后的文件
docker cp ./temp-index.php [client-name]_wp:/var/www/html/wp-content/themes/[client-name]-theme/index.php
```

### 3.3 添加新功能组件

**示例：添加联系表单**
```php
// 在functions.php中添加
function client_contact_form_shortcode() {
    ob_start();
    ?>
    <form class="contact-form" method="post" action="">
        <div class="form-group">
            <label for="name">姓名</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div class="form-group">
            <label for="email">邮箱</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="message">消息</label>
            <textarea id="message" name="message" required></textarea>
        </div>
        <button type="submit">发送</button>
    </form>
    <?php
    return ob_get_clean();
}
add_shortcode('contact_form', 'client_contact_form_shortcode');
```

---

## 🧪 Phase 4: 测试与验证

### 4.1 更新后测试清单

**基础功能测试：**
- [ ] 主页加载正常
- [ ] 导航链接功能正常
- [ ] 新增内容显示正确
- [ ] 样式更改生效
- [ ] 移动端响应正常

**深度测试：**
```bash
# 页面加载时间测试
time curl -s http://localhost:8080/ > /dev/null

# 检查所有链接
curl -s http://localhost:8080/ | grep -o 'href="[^"]*"' | head -10

# 验证图片加载
curl -I http://localhost:8080/wp-content/themes/[client-name]-theme/assets/images/main-logo.jpg

# 检查CSS和JS资源
curl -I http://localhost:8080/wp-content/themes/[client-name]-theme/style.css
```

### 4.2 跨浏览器测试

**模拟不同User-Agent测试：**
```bash
# 模拟移动设备
curl -H "User-Agent: Mozilla/5.0 (iPhone; CPU iPhone OS 14_7_1 like Mac OS X)" -s http://localhost:8080/ | head -20

# 模拟平板设备
curl -H "User-Agent: Mozilla/5.0 (iPad; CPU OS 14_7_1 like Mac OS X)" -s http://localhost:8080/ | head -20
```

### 4.3 内容一致性验证

**内容检查脚本：**
```bash
#!/bin/bash
# content-check.sh

echo "=== 内容更新验证报告 ==="
echo "检查时间: $(date)"
echo ""

echo "1. 页面标题检查:"
curl -s http://localhost:8080/ | grep -o "<title>.*</title>"
echo ""

echo "2. 主要内容检查:"
curl -s http://localhost:8080/ | grep -E "(新增内容|更新内容)" | head -5
echo ""

echo "3. 样式文件检查:"
curl -I http://localhost:8080/wp-content/themes/[client-name]-theme/style.css | grep "HTTP\|Last-Modified"
echo ""

echo "4. 响应时间检查:"
time curl -s http://localhost:8080/ > /dev/null
echo "=== 检查完成 ==="
```

---

## 📊 Phase 5: 监控与维护

### 5.1 定期健康检查

**每日检查脚本：**
```bash
#!/bin/bash
# daily-health-check.sh

DATE=$(date +%Y%m%d)
LOG_FILE="health-check-$DATE.log"

echo "=== 日常健康检查 - $DATE ===" > $LOG_FILE

# 检查容器状态
echo "容器状态检查:" >> $LOG_FILE
docker ps --filter "name=[client-name]" --format "table {{.Names}}\t{{.Status}}" >> $LOG_FILE

# 检查网站响应
echo "网站响应检查:" >> $LOG_FILE
HTTP_STATUS=$(curl -s -o /dev/null -w "%{http_code}" http://localhost:8080/)
echo "HTTP状态码: $HTTP_STATUS" >> $LOG_FILE

# 检查数据库连接
echo "数据库连接检查:" >> $LOG_FILE
docker exec [client-name]_mysql mysql -uwordpress -pwordpress wordpress -e "SELECT 1" &>> $LOG_FILE

echo "检查完成时间: $(date)" >> $LOG_FILE
```

### 5.2 性能监控

**页面加载时间监控：**
```bash
#!/bin/bash
# performance-monitor.sh

for i in {1..5}; do
    echo "测试 $i:"
    time curl -s http://localhost:8080/ > /dev/null
    echo "---"
done
```

### 5.3 自动备份策略

**自动备份脚本：**
```bash
#!/bin/bash
# auto-backup.sh

BACKUP_DIR="backups/auto-$(date +%Y%m%d_%H%M%S)"
mkdir -p $BACKUP_DIR

# 备份主题文件
echo "备份主题文件..."
docker cp [client-name]_wp:/var/www/html/wp-content/themes/[client-name]-theme $BACKUP_DIR/

# 备份数据库
echo "备份数据库..."
docker exec [client-name]_mysql mysqldump -uwordpress -pwordpress wordpress > $BACKUP_DIR/wordpress-backup.sql

# 记录备份信息
echo "备份完成时间: $(date)" > $BACKUP_DIR/backup-info.txt
echo "备份类型: 自动备份" >> $BACKUP_DIR/backup-info.txt

# 删除7天前的备份
find backups/ -name "auto-*" -mtime +7 -exec rm -rf {} \;

echo "自动备份完成: $BACKUP_DIR"
```

---

## 🔧 故障排除与回滚

### 6.1 常见问题解决

**问题1: 更新后页面显示异常**
```bash
# 快速回滚到上一个备份
LATEST_BACKUP=$(ls -1t backups/ | head -1)
echo "回滚到备份: $LATEST_BACKUP"

# 恢复主题文件
docker cp backups/$LATEST_BACKUP/[client-name]-theme/. [client-name]_wp:/var/www/html/wp-content/themes/[client-name]-theme/

# 验证恢复
curl -s http://localhost:8080/ | head -10
```

**问题2: CSS样式丢失**
```bash
# 检查CSS文件是否存在
docker exec [client-name]_wp ls -la /var/www/html/wp-content/themes/[client-name]-theme/style.css

# 重新上传CSS文件
docker cp backups/$LATEST_BACKUP/[client-name]-theme/style.css [client-name]_wp:/var/www/html/wp-content/themes/[client-name]-theme/

# 强制刷新缓存
curl -H "Cache-Control: no-cache" http://localhost:8080/
```

**问题3: 数据库数据丢失**
```bash
# 停止WordPress容器
docker stop [client-name]_wp

# 恢复数据库
docker exec [client-name]_mysql mysql -uwordpress -pwordpress wordpress < backups/$LATEST_BACKUP/wordpress-backup.sql

# 重启WordPress容器
docker start [client-name]_wp
```

### 6.2 版本控制策略

**Git版本管理：**
```bash
# 初始化Git仓库
cd themes/[client-name]-theme
git init
git add .
git commit -m "初始主题版本"

# 创建开发分支
git checkout -b development

# 每次更新后提交
git add .
git commit -m "更新内容: [具体更新说明]"

# 合并到主分支
git checkout main
git merge development
git tag -a v1.1 -m "版本1.1 - [更新说明]"
```

---

## 📋 更新检查清单

### 更新前检查
- [ ] 创建完整备份
- [ ] 确认更新需求和范围
- [ ] 准备必要的新资源 (图片、文字等)
- [ ] 制定回滚计划

### 更新中检查
- [ ] 逐步实施更改
- [ ] 每个步骤后进行测试
- [ ] 记录更改内容
- [ ] 保持备份的时效性

### 更新后检查
- [ ] 完整功能测试
- [ ] 性能对比测试
- [ ] 多设备兼容性测试
- [ ] 更新文档记录
- [ ] 通知相关人员

---

## 📈 最佳实践

### 1. 更新频率建议
- **紧急修复**: 立即执行
- **内容更新**: 每周1-2次
- **功能升级**: 每月1次
- **大版本更新**: 每季度1次

### 2. 团队协作
- 使用统一的命名规范
- 建立更新申请流程
- 定期进行代码审查
- 维护详细的更改日志

### 3. 安全考虑
- 定期更新WordPress核心
- 监控安全漏洞
- 使用强密码策略
- 限制管理员访问权限

### 4. 性能优化
- 压缩图片文件
- 最小化CSS和JavaScript
- 使用浏览器缓存
- 定期清理数据库

通过遵循这个内容更新手册，可以确保WordPress网站的持续稳定运行和高效的内容管理。
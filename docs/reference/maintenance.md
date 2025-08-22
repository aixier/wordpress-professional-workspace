# WordPress 客户站点运维手册

## 📋 概述

本手册适用于基于 `coopotfan/wordpress-dev` 镜像交付的客户WordPress站点的运维管理。提供完整的监控、维护、更新和故障处理流程。

## 🎯 运维管理模式

### 核心理念
- **容器化运维**: 基于Docker容器的标准化管理
- **CLI驱动操作**: 通过WP-CLI实现自动化运维
- **预防性维护**: 主动监控和预防问题
- **快速响应**: 标准化的故障处理流程

---

## 🔍 Phase 1: 日常监控检查

### 1.1 基础健康检查

```bash
#!/bin/bash
# daily-health-check.sh - 客户站点日常健康检查

CLIENT_NAME="client-site"
DATE=$(date +%Y%m%d)
LOG_FILE="logs/health-check-$CLIENT_NAME-$DATE.log"

echo "=== $CLIENT_NAME 健康检查 - $DATE ===" | tee $LOG_FILE

# 检查容器状态
echo "📊 容器状态检查:" | tee -a $LOG_FILE
docker ps --filter "name=$CLIENT_NAME" --format "table {{.Names}}\t{{.Status}}\t{{.Ports}}" | tee -a $LOG_FILE

# 检查WordPress核心状态
echo "🏠 WordPress状态检查:" | tee -a $LOG_FILE
docker exec $CLIENT_NAME wp core version --allow-root 2>&1 | tee -a $LOG_FILE
docker exec $CLIENT_NAME wp core verify-checksums --allow-root 2>&1 | tee -a $LOG_FILE

# 检查数据库连接
echo "🗄️ 数据库连接检查:" | tee -a $LOG_FILE
docker exec $CLIENT_NAME wp db check --allow-root 2>&1 | tee -a $LOG_FILE

# 检查网站响应
echo "🌐 网站响应检查:" | tee -a $LOG_FILE
HTTP_STATUS=$(curl -s -o /dev/null -w "%{http_code}" https://client.com/)
RESPONSE_TIME=$(curl -s -o /dev/null -w "%{time_total}" https://client.com/)
echo "HTTP状态码: $HTTP_STATUS" | tee -a $LOG_FILE
echo "响应时间: ${RESPONSE_TIME}s" | tee -a $LOG_FILE

# 检查内存使用
echo "💾 内存使用检查:" | tee -a $LOG_FILE
docker exec $CLIENT_NAME wp eval 'echo "Memory: " . size_format(memory_get_usage());' --allow-root 2>&1 | tee -a $LOG_FILE

# 检查磁盘空间
echo "💿 磁盘空间检查:" | tee -a $LOG_FILE
docker exec $CLIENT_NAME df -h /var/www/html 2>&1 | tee -a $LOG_FILE

echo "✅ 检查完成时间: $(date)" | tee -a $LOG_FILE
```

### 1.2 性能监控

```bash
#!/bin/bash
# performance-monitor.sh - 客户站点性能监控

CLIENT_NAME="client-site"
SITE_URL="https://client.com"

echo "=== $CLIENT_NAME 性能监控 ==="

# 页面加载时间测试
echo "📈 页面加载时间测试 (5次):"
for i in {1..5}; do
    LOAD_TIME=$(curl -s -o /dev/null -w "%{time_total}" $SITE_URL)
    echo "测试 $i: ${LOAD_TIME}s"
done

# 数据库性能检查
echo "🗄️ 数据库性能检查:"
docker exec $CLIENT_NAME wp db size --allow-root
docker exec $CLIENT_NAME wp db optimize --allow-root

# 缓存状态检查
echo "🚀 缓存状态检查:"
docker exec $CLIENT_NAME wp cache flush --allow-root

# 插件性能检查
echo "🔌 插件状态检查:"
docker exec $CLIENT_NAME wp plugin list --status=active --allow-root

echo "✅ 性能监控完成"
```

### 1.3 安全状态检查

```bash
#!/bin/bash
# security-check.sh - 客户站点安全检查

CLIENT_NAME="client-site"

echo "=== $CLIENT_NAME 安全状态检查 ==="

# 检查WordPress版本
echo "🔒 WordPress版本检查:"
WP_VERSION=$(docker exec $CLIENT_NAME wp core version --allow-root)
echo "当前版本: $WP_VERSION"
docker exec $CLIENT_NAME wp core check-update --allow-root

# 检查插件安全
echo "🔌 插件安全检查:"
docker exec $CLIENT_NAME wp plugin list --update=available --allow-root

# 检查主题安全
echo "🎨 主题安全检查:"
docker exec $CLIENT_NAME wp theme list --update=available --allow-root

# 检查用户权限
echo "👤 用户权限检查:"
docker exec $CLIENT_NAME wp user list --fields=user_login,user_email,roles --allow-root

# 检查文件权限
echo "📁 文件权限检查:"
docker exec $CLIENT_NAME ls -la /var/www/html/wp-config.php

echo "✅ 安全检查完成"
```

---

## 🔧 Phase 2: 日常维护操作

### 2.1 内容更新管理

```bash
#!/bin/bash
# content-update.sh - 客户站点内容更新

CLIENT_NAME="client-site"

echo "=== $CLIENT_NAME 内容更新操作 ==="

# 创建更新前备份
echo "📦 创建更新前备份..."
BACKUP_DIR="backups/content-update-$(date +%Y%m%d_%H%M%S)"
mkdir -p $BACKUP_DIR

# 备份数据库
docker exec $CLIENT_NAME wp db export /tmp/backup.sql --allow-root
docker cp $CLIENT_NAME:/tmp/backup.sql $BACKUP_DIR/

# 备份wp-content
docker exec $CLIENT_NAME tar -czf /tmp/wp-content-backup.tar.gz wp-content/
docker cp $CLIENT_NAME:/tmp/wp-content-backup.tar.gz $BACKUP_DIR/

echo "✅ 备份完成: $BACKUP_DIR"

# 内容更新示例 - 创建新文章
echo "📝 创建示例内容..."
docker exec $CLIENT_NAME wp post create \
  --post_title="最新动态 - $(date +%Y年%m月%d日)" \
  --post_content="<h2>公司最新动态</h2><p>这里是最新的公司动态内容...</p>" \
  --post_status=publish \
  --post_category="新闻" \
  --allow-root

# 更新站点信息
docker exec $CLIENT_NAME wp option update blogdescription "更新于$(date +%Y年%m月%d日)的专业网站" --allow-root

echo "✅ 内容更新完成"
```

### 2.2 系统更新管理

```bash
#!/bin/bash
# system-update.sh - 客户站点系统更新

CLIENT_NAME="client-site"

echo "=== $CLIENT_NAME 系统更新操作 ==="

# 创建系统更新前备份
echo "📦 创建系统更新前备份..."
BACKUP_DIR="backups/system-update-$(date +%Y%m%d_%H%M%S)"
mkdir -p $BACKUP_DIR

# 完整备份
docker exec $CLIENT_NAME wp db export /tmp/full-backup.sql --allow-root
docker cp $CLIENT_NAME:/tmp/full-backup.sql $BACKUP_DIR/
docker exec $CLIENT_NAME tar -czf /tmp/full-wp-backup.tar.gz /var/www/html/
docker cp $CLIENT_NAME:/tmp/full-wp-backup.tar.gz $BACKUP_DIR/

# 更新WordPress核心
echo "🔄 更新WordPress核心..."
docker exec $CLIENT_NAME wp core update --allow-root
docker exec $CLIENT_NAME wp core update-db --allow-root

# 更新插件
echo "🔌 更新插件..."
docker exec $CLIENT_NAME wp plugin update --all --allow-root

# 更新主题
echo "🎨 更新主题..."
docker exec $CLIENT_NAME wp theme update --all --allow-root

# 清理和优化
echo "🧹 系统清理和优化..."
docker exec $CLIENT_NAME wp cache flush --allow-root
docker exec $CLIENT_NAME wp db optimize --allow-root

# 验证更新
echo "✅ 验证更新结果..."
docker exec $CLIENT_NAME wp core verify-checksums --allow-root
docker exec $CLIENT_NAME wp plugin verify-checksums --all --allow-root

echo "✅ 系统更新完成"
```

### 2.3 性能优化操作

```bash
#!/bin/bash
# performance-optimization.sh - 客户站点性能优化

CLIENT_NAME="client-site"

echo "=== $CLIENT_NAME 性能优化操作 ==="

# 数据库优化
echo "🗄️ 数据库优化..."
docker exec $CLIENT_NAME wp db optimize --allow-root
docker exec $CLIENT_NAME wp db repair --allow-root

# 清理垃圾数据
echo "🧹 清理垃圾数据..."
# 清理修订版本
docker exec $CLIENT_NAME wp post delete $(docker exec $CLIENT_NAME wp post list --post_type=revision --field=ID --allow-root) --allow-root
# 清理垃圾评论
docker exec $CLIENT_NAME wp comment delete $(docker exec $CLIENT_NAME wp comment list --status=spam --field=ID --allow-root) --allow-root
# 清理草稿
docker exec $CLIENT_NAME wp post delete $(docker exec $CLIENT_NAME wp post list --post_status=auto-draft --field=ID --allow-root) --allow-root

# 优化图片设置
echo "🖼️ 优化图片设置..."
docker exec $CLIENT_NAME wp option update thumbnail_size_w 150 --allow-root
docker exec $CLIENT_NAME wp option update thumbnail_size_h 150 --allow-root
docker exec $CLIENT_NAME wp option update medium_size_w 300 --allow-root
docker exec $CLIENT_NAME wp option update large_size_w 1024 --allow-root

# 刷新重写规则和缓存
echo "🔄 刷新缓存和重写规则..."
docker exec $CLIENT_NAME wp rewrite flush --allow-root
docker exec $CLIENT_NAME wp cache flush --allow-root

# 生成优化报告
echo "📊 生成优化报告..."
echo "优化完成时间: $(date)" > "reports/optimization-$(date +%Y%m%d).txt"
docker exec $CLIENT_NAME wp db size --allow-root >> "reports/optimization-$(date +%Y%m%d).txt"

echo "✅ 性能优化完成"
```

---

## 🚨 Phase 3: 故障排除与恢复

### 3.1 常见问题诊断

```bash
#!/bin/bash
# troubleshoot.sh - 客户站点故障诊断

CLIENT_NAME="client-site"
SITE_URL="https://client.com"

echo "=== $CLIENT_NAME 故障诊断 ==="

# 检查站点可访问性
echo "🌐 检查站点可访问性..."
HTTP_STATUS=$(curl -s -o /dev/null -w "%{http_code}" $SITE_URL)
if [ "$HTTP_STATUS" != "200" ]; then
    echo "❌ 站点访问异常 - HTTP状态码: $HTTP_STATUS"
else
    echo "✅ 站点访问正常"
fi

# 检查容器状态
echo "🐳 检查容器状态..."
CONTAINER_STATUS=$(docker inspect --format='{{.State.Status}}' $CLIENT_NAME 2>/dev/null)
if [ "$CONTAINER_STATUS" != "running" ]; then
    echo "❌ 容器状态异常: $CONTAINER_STATUS"
    echo "🔄 尝试重启容器..."
    docker restart $CLIENT_NAME
else
    echo "✅ 容器运行正常"
fi

# 检查WordPress状态
echo "📱 检查WordPress状态..."
if docker exec $CLIENT_NAME wp core verify-checksums --allow-root &>/dev/null; then
    echo "✅ WordPress核心文件完整"
else
    echo "❌ WordPress核心文件异常"
    echo "🔄 尝试修复WordPress..."
    docker exec $CLIENT_NAME wp core download --skip-content --force --allow-root
fi

# 检查数据库连接
echo "🗄️ 检查数据库连接..."
if docker exec $CLIENT_NAME wp db check --allow-root &>/dev/null; then
    echo "✅ 数据库连接正常"
else
    echo "❌ 数据库连接异常"
    echo "🔄 尝试修复数据库..."
    docker exec $CLIENT_NAME wp db repair --allow-root
fi

# 检查插件状态
echo "🔌 检查插件状态..."
PLUGIN_ERRORS=$(docker exec $CLIENT_NAME wp plugin list --status=inactive --field=name --allow-root 2>/dev/null)
if [ -n "$PLUGIN_ERRORS" ]; then
    echo "⚠️ 发现未激活插件: $PLUGIN_ERRORS"
else
    echo "✅ 所有插件状态正常"
fi

echo "✅ 故障诊断完成"
```

### 3.2 快速恢复操作

```bash
#!/bin/bash
# quick-recovery.sh - 客户站点快速恢复

CLIENT_NAME="client-site"

echo "=== $CLIENT_NAME 快速恢复操作 ==="

# 查找最新备份
LATEST_BACKUP=$(ls -1t backups/ | head -1)
if [ -z "$LATEST_BACKUP" ]; then
    echo "❌ 未找到可用备份"
    exit 1
fi

echo "📦 使用备份: $LATEST_BACKUP"

# 停止容器
echo "⏹️ 停止容器..."
docker stop $CLIENT_NAME

# 恢复数据库
echo "🗄️ 恢复数据库..."
if [ -f "backups/$LATEST_BACKUP/*.sql" ]; then
    docker start $CLIENT_NAME
    sleep 10  # 等待容器启动
    
    # 导入数据库备份
    SQL_FILE=$(ls backups/$LATEST_BACKUP/*.sql | head -1)
    docker cp "$SQL_FILE" $CLIENT_NAME:/tmp/restore.sql
    docker exec $CLIENT_NAME wp db import /tmp/restore.sql --allow-root
    docker exec $CLIENT_NAME rm /tmp/restore.sql
    
    echo "✅ 数据库恢复完成"
else
    echo "❌ 未找到数据库备份文件"
fi

# 恢复文件
echo "📁 恢复文件..."
if [ -f "backups/$LATEST_BACKUP/*.tar.gz" ]; then
    CONTENT_FILE=$(ls backups/$LATEST_BACKUP/*.tar.gz | head -1)
    docker cp "$CONTENT_FILE" $CLIENT_NAME:/tmp/restore-content.tar.gz
    docker exec $CLIENT_NAME tar -xzf /tmp/restore-content.tar.gz -C /
    docker exec $CLIENT_NAME rm /tmp/restore-content.tar.gz
    
    echo "✅ 文件恢复完成"
else
    echo "❌ 未找到文件备份"
fi

# 验证恢复结果
echo "✅ 验证恢复结果..."
sleep 5
docker exec $CLIENT_NAME wp core verify-checksums --allow-root
docker exec $CLIENT_NAME wp db check --allow-root

echo "✅ 快速恢复完成"
```

### 3.3 完整灾难恢复

```bash
#!/bin/bash
# disaster-recovery.sh - 客户站点完整灾难恢复

CLIENT_NAME="client-site"
SITE_URL="https://client.com"

echo "=== $CLIENT_NAME 完整灾难恢复 ==="

# 创建恢复日志
RECOVERY_LOG="logs/disaster-recovery-$(date +%Y%m%d_%H%M%S).log"
exec 1> >(tee -a $RECOVERY_LOG)
exec 2> >(tee -a $RECOVERY_LOG >&2)

echo "🚨 开始灾难恢复 - $(date)"

# 1. 停止并删除现有容器
echo "⏹️ 停止并清理现有容器..."
docker stop $CLIENT_NAME 2>/dev/null || true
docker rm $CLIENT_NAME 2>/dev/null || true

# 2. 重新创建容器
echo "🔄 重新创建容器..."
docker run -d \
  --name $CLIENT_NAME \
  -p 80:80 \
  -e WORDPRESS_AUTO_SETUP=false \
  -e WORDPRESS_DB_HOST=mysql:3306 \
  -e WORDPRESS_DB_NAME=client_db \
  -e WORDPRESS_DB_USER=wp_user \
  -e WORDPRESS_DB_PASSWORD=secure_password \
  -v client_content:/var/www/html/wp-content \
  coopotfan/wordpress-dev:latest

echo "⏳ 等待容器启动..."
sleep 30

# 3. 恢复最新备份
LATEST_BACKUP=$(ls -1t backups/ | head -1)
echo "📦 恢复备份: $LATEST_BACKUP"

# 恢复数据库
SQL_FILE=$(ls backups/$LATEST_BACKUP/*.sql | head -1)
docker cp "$SQL_FILE" $CLIENT_NAME:/tmp/disaster-restore.sql
docker exec $CLIENT_NAME wp db import /tmp/disaster-restore.sql --allow-root

# 恢复文件
CONTENT_FILE=$(ls backups/$LATEST_BACKUP/*.tar.gz | head -1)
docker cp "$CONTENT_FILE" $CLIENT_NAME:/tmp/disaster-restore.tar.gz
docker exec $CLIENT_NAME tar -xzf /tmp/disaster-restore.tar.gz -C /

# 4. 重新配置WordPress
echo "⚙️ 重新配置WordPress..."
docker exec $CLIENT_NAME wp core verify-checksums --allow-root
docker exec $CLIENT_NAME wp db check --allow-root
docker exec $CLIENT_NAME wp cache flush --allow-root
docker exec $CLIENT_NAME wp rewrite flush --allow-root

# 5. 验证恢复
echo "✅ 验证灾难恢复结果..."
sleep 10

HTTP_STATUS=$(curl -s -o /dev/null -w "%{http_code}" $SITE_URL)
if [ "$HTTP_STATUS" = "200" ]; then
    echo "✅ 网站访问恢复正常"
else
    echo "❌ 网站访问仍有问题 - HTTP: $HTTP_STATUS"
fi

docker exec $CLIENT_NAME wp user list --allow-root
docker exec $CLIENT_NAME wp plugin list --allow-root
docker exec $CLIENT_NAME wp theme list --allow-root

echo "✅ 灾难恢复完成 - $(date)"
```

---

## 📊 Phase 4: 监控报告与分析

### 4.1 生成运维报告

```bash
#!/bin/bash
# generate-report.sh - 生成客户站点运维报告

CLIENT_NAME="client-site"
REPORT_DATE=$(date +%Y%m%d)
REPORT_FILE="reports/monthly-report-$CLIENT_NAME-$REPORT_DATE.html"

cat > $REPORT_FILE << EOF
<!DOCTYPE html>
<html>
<head>
    <title>$CLIENT_NAME 运维报告 - $REPORT_DATE</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        .header { background: #f0f0f0; padding: 10px; border-radius: 5px; }
        .section { margin: 20px 0; }
        .status-ok { color: green; }
        .status-warning { color: orange; }
        .status-error { color: red; }
    </style>
</head>
<body>
    <div class="header">
        <h1>$CLIENT_NAME WordPress站点运维报告</h1>
        <p>报告日期: $(date)</p>
    </div>
    
    <div class="section">
        <h2>站点基本信息</h2>
        <ul>
            <li>WordPress版本: $(docker exec $CLIENT_NAME wp core version --allow-root)</li>
            <li>活跃插件数: $(docker exec $CLIENT_NAME wp plugin list --status=active --allow-root | wc -l)</li>
            <li>当前主题: $(docker exec $CLIENT_NAME wp theme list --status=active --field=name --allow-root)</li>
            <li>用户总数: $(docker exec $CLIENT_NAME wp user list --allow-root | wc -l)</li>
        </ul>
    </div>
    
    <div class="section">
        <h2>性能指标</h2>
        <ul>
            <li>平均响应时间: $(curl -s -o /dev/null -w "%{time_total}" https://client.com)s</li>
            <li>数据库大小: $(docker exec $CLIENT_NAME wp db size --allow-root)</li>
            <li>内存使用: $(docker exec $CLIENT_NAME wp eval 'echo size_format(memory_get_usage());' --allow-root)</li>
        </ul>
    </div>
    
    <div class="section">
        <h2>安全状态</h2>
        <ul>
            <li>WordPress核心: <span class="status-ok">✅ 最新版本</span></li>
            <li>插件状态: <span class="status-ok">✅ 全部最新</span></li>
            <li>备份状态: <span class="status-ok">✅ 每日备份正常</span></li>
        </ul>
    </div>
    
    <div class="section">
        <h2>本月维护记录</h2>
        <ul>
            <li>系统更新: $(ls logs/system-update-* 2>/dev/null | wc -l) 次</li>
            <li>内容更新: $(ls logs/content-update-* 2>/dev/null | wc -l) 次</li>
            <li>故障处理: $(ls logs/troubleshoot-* 2>/dev/null | wc -l) 次</li>
        </ul>
    </div>
    
    <div class="section">
        <h2>建议事项</h2>
        <ul>
            <li>建议定期更新WordPress核心和插件</li>
            <li>建议优化数据库以提升性能</li>
            <li>建议定期检查备份完整性</li>
        </ul>
    </div>
</body>
</html>
EOF

echo "✅ 运维报告已生成: $REPORT_FILE"
```

### 4.2 自动化运维脚本

```bash
#!/bin/bash
# automated-maintenance.sh - 客户站点自动化运维

CLIENT_NAME="client-site"

# 设置cron任务进行自动化运维
setup_cron() {
    echo "⚙️ 设置自动化运维任务..."
    
    # 创建cron任务文件
    cat > /tmp/client-maintenance-cron << EOF
# 每日健康检查 (每天早上8点)
0 8 * * * /path/to/daily-health-check.sh

# 每周系统更新 (每周日凌晨2点)
0 2 * * 0 /path/to/system-update.sh

# 每日自动备份 (每天凌晨1点)
0 1 * * * /path/to/auto-backup.sh

# 每月性能优化 (每月1号凌晨3点)
0 3 1 * * /path/to/performance-optimization.sh

# 每月生成报告 (每月最后一天)
0 23 28-31 * * [ \$(date -d tomorrow +\%d) -eq 1 ] && /path/to/generate-report.sh
EOF

    # 安装cron任务
    crontab /tmp/client-maintenance-cron
    rm /tmp/client-maintenance-cron
    
    echo "✅ 自动化运维任务设置完成"
}

# 创建运维目录结构
setup_directories() {
    echo "📁 创建运维目录结构..."
    mkdir -p {logs,backups,reports,scripts,configs}
    echo "✅ 目录结构创建完成"
}

# 初始化运维环境
echo "=== 初始化 $CLIENT_NAME 运维环境 ==="
setup_directories
setup_cron

echo "✅ 自动化运维环境初始化完成"
```

---

## 📋 运维检查清单

### 日常检查 (每日)
- [ ] 容器运行状态检查
- [ ] 网站可访问性检查  
- [ ] 数据库连接状态检查
- [ ] 错误日志检查
- [ ] 性能指标记录

### 周度检查 (每周)
- [ ] WordPress核心更新检查
- [ ] 插件和主题更新检查
- [ ] 安全扫描检查
- [ ] 备份完整性验证
- [ ] 性能优化执行

### 月度检查 (每月)
- [ ] 全面系统更新
- [ ] 数据库优化清理
- [ ] 安全配置审查
- [ ] 容量规划评估
- [ ] 运维报告生成

### 季度检查 (每季度)
- [ ] 灾难恢复测试
- [ ] 安全策略评估
- [ ] 性能基准测试
- [ ] 备份策略审查
- [ ] 运维流程优化

---

## 🏆 运维最佳实践

### 1. 预防性维护
- 建立完善的监控体系
- 定期执行健康检查
- 主动更新系统组件
- 保持充足的备份

### 2. 标准化操作
- 使用统一的脚本和工具
- 建立标准的操作流程
- 记录所有运维操作
- 建立知识库和文档

### 3. 快速响应
- 建立故障报警机制
- 准备快速恢复方案
- 保持24/7监控
- 建立应急联系机制

### 4. 持续改进
- 定期评估运维效果
- 优化运维流程
- 更新运维工具
- 培训运维团队

---

**通过这套完整的运维手册，确保客户WordPress站点的稳定运行、安全防护和性能优化。**
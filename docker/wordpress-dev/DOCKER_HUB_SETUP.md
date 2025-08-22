# Docker Hub 发布指南

## 🚀 快速发布到 Docker Hub

### 前置要求

1. **Docker Hub 账号**
   - 注册账号：https://hub.docker.com/
   - 创建仓库：`fsotool/wordpress-dev`

2. **本地 Docker 登录**
   ```bash
   docker login
   # 输入用户名和密码
   ```

### 方法1: 使用自动化脚本 (推荐)

```bash
# 进入项目目录
cd /mnt/d/work/wordpress_pages/docker/wordpress-dev/

# 构建并推送 (自动确认)
./push-to-dockerhub.sh --yes

# 或者交互式推送
./push-to-dockerhub.sh
```

### 方法2: 手动步骤

```bash
# 1. 构建镜像
./build.sh

# 2. 标记镜像
docker tag fsotool/wordpress-dev:latest fsotool/wordpress-dev:1.0.0
docker tag fsotool/wordpress-dev:latest fsotool/wordpress-dev:6.8.2
docker tag fsotool/wordpress-dev:latest fsotool/wordpress-dev:php8.2
docker tag fsotool/wordpress-dev:latest fsotool/wordpress-dev:production

# 3. 推送镜像
docker push fsotool/wordpress-dev:latest
docker push fsotool/wordpress-dev:1.0.0
docker push fsotool/wordpress-dev:6.8.2
docker push fsotool/wordpress-dev:php8.2
docker push fsotool/wordpress-dev:production
```

### 方法3: GitHub Actions 自动化

1. **设置 GitHub Secrets**
   ```
   DOCKER_HUB_USERNAME: your_dockerhub_username
   DOCKER_HUB_ACCESS_TOKEN: your_dockerhub_access_token
   ```

2. **触发构建**
   ```bash
   # 推送到 main 分支自动触发
   git add .
   git commit -m "Update WordPress development environment"
   git push origin main
   ```

## 📋 发布清单

### 发布前检查

- [ ] 镜像构建成功
- [ ] WP-CLI 功能测试通过
- [ ] 多语言支持正常
- [ ] 开发插件正常安装
- [ ] 文档更新完毕

### 发布后验证

- [ ] Docker Hub 页面更新
- [ ] README 正确显示
- [ ] 所有标签都可拉取
- [ ] 测试拉取和运行

### 测试命令

```bash
# 测试最新镜像
docker pull fsotool/wordpress-dev:latest
docker run --rm fsotool/wordpress-dev:latest wp --info --allow-root

# 测试完整环境
docker run -d -p 8080:80 -e WORDPRESS_AUTO_SETUP=true fsotool/wordpress-dev:latest
curl -I http://localhost:8080
```

## 🏷️ 标签策略

| 标签 | 用途 | 示例 |
|------|------|------|
| `latest` | 最新稳定版 | `fsotool/wordpress-dev:latest` |
| `v1.0.0` | 语义化版本 | `fsotool/wordpress-dev:v1.0.0` |
| `6.8.2` | WordPress 版本 | `fsotool/wordpress-dev:6.8.2` |
| `php8.2` | PHP 版本 | `fsotool/wordpress-dev:php8.2` |
| `production` | 生产就绪 | `fsotool/wordpress-dev:production` |
| `20250821` | 日期版本 | `fsotool/wordpress-dev:20250821` |

## 📊 发布统计

```bash
# 查看镜像信息
docker images fsotool/wordpress-dev

# 检查镜像层
docker history fsotool/wordpress-dev:latest

# 查看镜像大小
docker image inspect fsotool/wordpress-dev:latest | jq '.[0].Size'
```

## 🔄 更新流程

### 小版本更新
```bash
# 更新版本号
VERSION="1.0.1"

# 重新构建
./build.sh

# 标记新版本
docker tag fsotool/wordpress-dev:latest fsotool/wordpress-dev:$VERSION

# 推送更新
docker push fsotool/wordpress-dev:latest
docker push fsotool/wordpress-dev:$VERSION
```

### 大版本更新
```bash
# 更新 WordPress 或 PHP 版本后
# 修改 Dockerfile 中的基础镜像版本
# 更新标签策略
# 全面测试后发布
```

## 🐛 故障排除

### 常见问题

**推送失败**
```bash
# 检查登录状态
docker info | grep Username

# 重新登录
docker logout
docker login
```

**镜像过大**
```bash
# 分析镜像层
docker history fsotool/wordpress-dev:latest

# 优化 Dockerfile
# 合并 RUN 命令
# 清理缓存文件
```

**测试失败**
```bash
# 检查容器日志
docker run --rm fsotool/wordpress-dev:latest wp --info --allow-root

# 进入容器调试
docker run -it fsotool/wordpress-dev:latest bash
```

## 📝 发布日志

### v1.0.0 (2025-08-21)
- ✅ 首次发布 WordPress 开发环境
- ✅ 集成 WP-CLI 2.10.0
- ✅ 支持中英双语
- ✅ 预装开发插件
- ✅ 性能优化配置

---

**维护者**: FSO Tool Team  
**仓库**: https://hub.docker.com/r/fsotool/wordpress-dev  
**支持**: https://github.com/fsotool/wordpress-pages/issues
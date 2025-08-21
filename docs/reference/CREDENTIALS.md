# WordPress 登录信息

## 🔐 WordPress管理员
- **网站**: http://localhost:8080
- **后台**: http://localhost:8080/wp-admin
- **用户名**: petron
- **密码**: Petron12345^

## 🗄️ 数据库管理
- **phpMyAdmin**: http://localhost:8081
- **用户名**: root
- **密码**: root

## 🔧 容器管理
```bash
# 查看状态
docker ps

# 进入WordPress容器
docker exec -it wp_site_simple bash

# 查看日志
docker logs wp_site_simple
```

---

⚠️ **仅限开发环境使用** - 生产环境请更改密码
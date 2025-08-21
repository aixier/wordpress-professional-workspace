# WordPress工作空间目录结构重设计方案

## 🎯 设计目标

基于WordPress开发最佳实践，重新设计目录结构，实现：
- 清晰的环境分离（开发/生产）
- 标准的WordPress目录结构
- 高效的工作流程支持
- 便于维护和扩展

## 📊 当前问题分析

### ❌ 存在问题
1. **文件重复**：themes在多个位置重复存在
2. **环境混合**：开发文件与生产文件混在一起
3. **结构混乱**：WordPress标准目录被打散
4. **工作流不清晰**：缺乏明确的开发→测试→生产流程

### 📋 文件功能分类

#### 🔧 开发相关文件
- `migration-toolkit/development-tools/templates/` - 主题模板
- `themes/cardplanet-theme/` - 实际开发的主题
- `migration-toolkit/project-examples/` - 项目案例

#### 🚀 WordPress运行文件
- `wordpress/` - WordPress核心
- `wp-*` 文件 - WordPress配置
- `wp-content/` - WordPress内容目录
- `plugins/`, `uploads/` - WordPress标准目录

#### 🏗️ 基础设施文件
- `migration-toolkit/development-tools/docker-compose.yml` - Docker配置
- `migration-toolkit/backup-data/mysql-data/` - 数据库文件
- `migration-toolkit/development-tools/scripts/` - 自动化脚本

#### 📚 文档文件
- `migration-toolkit/documentation/` - 完整文档系统
- 各种 `.md` 文件 - 项目文档

## 🏗️ 新目录结构设计

```
wordpress_pages/
├── 🔧 src/                          # 源码开发区
│   ├── themes/                      # 主题开发源码
│   │   ├── cardplanet/             # CardPlanet主题源码
│   │   ├── apple-replica/          # Apple复刻主题源码
│   │   └── templates/              # 主题模板库
│   ├── plugins/                     # 插件开发源码
│   └── assets/                      # 开发资源
│       ├── images/                 # 图片资源
│       ├── fonts/                  # 字体文件
│       └── icons/                  # 图标文件
│
├── 🚀 app/                          # WordPress运行实例
│   ├── wp-content/                  # WordPress内容目录
│   │   ├── themes/                 # 活跃主题（从src构建）
│   │   ├── plugins/                # 活跃插件
│   │   ├── uploads/                # 上传文件
│   │   └── languages/              # 语言文件
│   ├── wp-config.php               # WordPress配置
│   ├── wp-*.php                    # WordPress核心文件
│   └── [其他WordPress核心文件]
│
├── 🏗️ infrastructure/              # 基础设施
│   ├── docker/                     # Docker配置
│   │   ├── docker-compose.yml     # 主要编排文件
│   │   ├── wordpress/              # WordPress容器配置
│   │   ├── mysql/                  # MySQL容器配置
│   │   └── nginx/                  # Nginx代理配置
│   ├── database/                   # 数据库相关
│   │   ├── data/                   # MySQL数据文件
│   │   ├── backups/                # 数据库备份
│   │   └── init/                   # 初始化脚本
│   ├── config/                     # 配置文件
│   │   ├── php.ini                 # PHP配置
│   │   ├── wp-cli.yml              # WP-CLI配置
│   │   └── environment/            # 环境变量
│   └── scripts/                    # 自动化脚本
│       ├── setup/                  # 环境搭建脚本
│       ├── deployment/             # 部署脚本
│       ├── backup/                 # 备份脚本
│       └── maintenance/            # 维护脚本
│
├── 📚 docs/                        # 文档系统
│   ├── guides/                     # 指南手册
│   │   ├── setup/                  # 环境搭建指南
│   │   ├── development/            # 开发指南
│   │   ├── migration/              # 迁移指南
│   │   ├── deployment/             # 部署指南
│   │   └── troubleshooting/        # 故障排查
│   ├── examples/                   # 示例案例
│   │   ├── apple-website/          # Apple网站案例
│   │   ├── cardplanet/             # CardPlanet案例
│   │   └── tutorials/              # 教程示例
│   ├── api/                        # API文档
│   │   ├── theme-functions/        # 主题函数文档
│   │   ├── hooks/                  # 钩子文档
│   │   └── customization/          # 自定义开发文档
│   └── reference/                  # 参考资料
│       ├── best-practices/         # 最佳实践
│       ├── code-standards/         # 代码标准
│       └── performance/            # 性能优化
│
├── 📦 resources/                   # 资源素材
│   ├── original-sites/             # 原始网站文件
│   │   ├── apple.com/             # Apple官网原始文件
│   │   ├── cardplanet.me/         # CardPlanet原始文件
│   │   └── [其他原始网站]/
│   ├── design-assets/              # 设计资源
│   │   ├── mockups/               # 设计稿
│   │   ├── style-guides/          # 设计规范
│   │   └── brand-assets/          # 品牌资源
│   ├── templates/                  # 模板库
│   │   ├── basic-theme/           # 基础主题模板
│   │   ├── e-commerce/            # 电商主题模板
│   │   └── portfolio/             # 作品集模板
│   └── backups/                   # 项目备份
│       ├── themes/                # 主题备份
│       ├── database/              # 数据库备份
│       └── complete-sites/        # 完整站点备份
│
├── 🛠️ tools/                       # 开发工具
│   ├── migration/                  # 迁移工具
│   │   ├── site-analyzer/         # 网站分析工具
│   │   ├── content-extractor/     # 内容提取工具
│   │   └── theme-generator/       # 主题生成工具
│   ├── testing/                    # 测试工具
│   │   ├── visual-regression/     # 视觉回归测试
│   │   ├── performance/           # 性能测试
│   │   └── compatibility/         # 兼容性测试
│   ├── deployment/                 # 部署工具
│   │   ├── staging/               # 预发布环境
│   │   ├── production/            # 生产环境
│   │   └── monitoring/            # 监控工具
│   └── utilities/                  # 实用工具
│       ├── image-optimization/    # 图片优化
│       ├── code-formatting/       # 代码格式化
│       └── security-scanning/     # 安全扫描
│
├── 📄 README.md                    # 项目主说明
├── 🔧 package.json                 # Node.js依赖（如果需要）
├── 📦 composer.json                # PHP依赖（如果需要）
└── ⚙️ .gitignore                   # Git忽略配置
```

## 🚀 工作流程优化

### 1. 开发流程
```bash
# 1. 在 src/ 目录开发主题
# 2. 使用 tools/ 中的工具测试
# 3. 构建到 app/wp-content/themes/
# 4. 在 app/ 环境中验证
```

### 2. 迁移流程
```bash
# 1. 原始网站文件放入 resources/original-sites/
# 2. 使用 tools/migration/ 分析和提取
# 3. 在 src/themes/ 开发主题
# 4. 参考 docs/guides/migration/ 执行迁移
```

### 3. 部署流程
```bash
# 1. 在 infrastructure/docker/ 配置环境
# 2. 使用 infrastructure/scripts/ 自动化部署
# 3. 通过 tools/deployment/ 发布到生产环境
```

## ✅ 新结构优势

### 🎯 清晰的职责分离
- **src/**: 纯源码开发，支持版本控制
- **app/**: WordPress运行实例，标准目录结构
- **infrastructure/**: 基础设施即代码
- **docs/**: 完整的文档体系
- **resources/**: 素材和资源管理
- **tools/**: 专业的开发工具链

### 🔄 标准的工作流程
1. **开发阶段**: 在 `src/` 开发，使用 `tools/` 测试
2. **构建阶段**: 构建到 `app/` 运行验证
3. **部署阶段**: 使用 `infrastructure/` 自动化部署

### 🎮 版本控制友好
- `src/` 目录完全纳入版本控制
- `app/` 目录可选择性纳入版本控制
- `infrastructure/` 配置即代码
- 其他目录按需管理

### 🔧 维护友好
- 文档集中在 `docs/`
- 工具集中在 `tools/`
- 配置集中在 `infrastructure/`
- 资源集中在 `resources/`

## 📋 迁移计划

### Phase 1: 创建新目录结构
1. 创建所有主要目录
2. 设置基础配置文件

### Phase 2: 迁移文件
1. 按功能分类迁移现有文件
2. 清理重复和过时文件

### Phase 3: 更新配置
1. 更新所有路径引用
2. 调整自动化脚本

### Phase 4: 测试验证
1. 验证所有功能正常
2. 更新文档说明

这个新结构将大大提升WordPress开发和迁移工作的效率和专业性！
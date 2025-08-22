import fs from 'fs';
import path from 'path';

const CONTENT_TYPES = ['blog', 'case-study', 'feature', 'doc'];
const CONTENT_DIR = path.join(process.cwd(), 'content');

const exampleContent = `---
title:
  zh: '示例文章'
  en: 'Example Post'
description:
  zh: '这是一个示例文章'
  en: 'This is an example post'
content:
  zh: |
    # 示例内容
    
    这是一个示例文章的内容。
  en: |
    # Example Content
    
    This is the content of an example post.
publishedAt: '2024-02-20T00:00:00.000Z'
updatedAt: '2024-02-20T00:00:00.000Z'
tags:
  - 'example'
  - 'test'
category: 'general'
metadata:
  author:
    name: 'TubeScanner Team'
    title: 'Content Team'
    avatar: '/images/authors/default.jpg'
    bio:
      zh: '内容团队'
      en: 'Content Team'
  coverImage: '/images/blog/example/cover.jpg'
  relatedContent: []
seo:
  metaTitle:
    zh: '示例文章 - TubeScanner'
    en: 'Example Post - TubeScanner'
  metaDescription:
    zh: '这是一个示例文章的描述'
    en: 'This is a description for the example post'
  keywords:
    - 'example'
    - 'test'
  canonicalUrl: 'https://tubescanner.fsotool.com/blog/example'
---`;

function createDirectoryIfNotExists(dirPath: string) {
  if (!fs.existsSync(dirPath)) {
    fs.mkdirSync(dirPath, { recursive: true });
    console.log(`Created directory: ${dirPath}`);
  }
}

function initContent() {
  // 确保主内容目录存在
  createDirectoryIfNotExists(CONTENT_DIR);

  CONTENT_TYPES.forEach(type => {
    // 创建类型目录
    const typeDir = path.join(CONTENT_DIR, type);
    createDirectoryIfNotExists(typeDir);

    // 创建示例目录
    const exampleDir = path.join(typeDir, 'example');
    createDirectoryIfNotExists(exampleDir);
    
    // 创建示例文件
    const filePath = path.join(exampleDir, 'index.md');
    if (!fs.existsSync(filePath)) {
      fs.writeFileSync(filePath, exampleContent);
      console.log(`Created example content: ${filePath}`);
    } else {
      console.log(`Example content already exists: ${filePath}`);
    }
  });

  console.log('Content initialization completed!');
}

try {
  initContent();
} catch (error) {
  console.error('Error initializing content:', error);
  process.exit(1);
} 
import { NextResponse } from 'next/server';

export async function GET(
  request: Request,
  { params }: { params: { slug: string } }
) {
  // 这里可以从数据库或CMS获取数据
  // 现在我们使用模拟数据
  const post = {
    id: params.slug,
    slug: params.slug,
    title: {
      en: 'Complete YouTube Analytics Guide',
      zh: '完整的 YouTube 数据分析指南'
    },
    excerpt: {
      en: 'Learn how to leverage YouTube analytics for channel growth',
      zh: '学习如何利用 YouTube 数据分析促进频道增长'
    },
    content: {
      en: '# Complete YouTube Analytics Guide\n\n## Introduction...',
      zh: '# 完整的 YouTube 数据分析指南\n\n## 介绍...'
    },
    author: {
      name: 'Alex Chen',
      title: 'Senior Data Analyst',
      avatar: '/images/authors/alex-chen.jpg',
      bio: {
        zh: '10年YouTube数据分析经验，曾服务过多个百万级订阅频道',
        en: '10 years of YouTube analytics experience, served multiple million-subscriber channels'
      }
    },
    publishedAt: '2024-02-07T00:00:00.000Z',
    updatedAt: '2024-02-07T00:00:00.000Z',
    tags: [
      'YouTube Analytics',
      'Content Strategy',
      'Data Analysis',
      'Channel Growth'
    ]
  };

  return NextResponse.json({ post });
} 
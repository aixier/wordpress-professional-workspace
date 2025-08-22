import { NextResponse } from 'next/server';

export async function GET(
  request: Request,
  { params }: { params: { slug: string } }
) {
  // 这里可以从数据库或CMS获取数据
  // 现在我们使用模拟数据
  const caseStudy = {
    id: params.slug,
    slug: params.slug,
    title: {
      en: 'How a Brand 10x Their YouTube Subscribers',
      zh: '品牌如何将 YouTube 订阅者增长10倍'
    },
    excerpt: {
      en: 'A success story of rapid YouTube channel growth',
      zh: 'YouTube 频道快速增长的成功案例'
    },
    content: {
      en: '# YouTube Growth Case Study\n\n## Background...',
      zh: '# YouTube 增长案例分析\n\n## 背景...'
    },
    highlights: [
      {
        value: '10x',
        label: {
          en: 'Subscriber Growth',
          zh: '订阅者增长'
        }
      },
      {
        value: '300%',
        label: {
          en: 'Engagement Rate',
          zh: '互动率'
        }
      },
      {
        value: '200%',
        label: {
          en: 'Revenue Increase',
          zh: '收入增长'
        }
      }
    ],
    author: {
      name: 'Sarah Zhang',
      title: 'Growth Strategy Director',
      avatar: '/images/authors/sarah-zhang.jpg',
      bio: {
        zh: '专注跨境电商增长策略，帮助超过50个品牌实现全球化',
        en: 'Focused on cross-border e-commerce growth strategy, helped over 50 brands achieve globalization'
      }
    },
    publishedAt: '2024-02-07T00:00:00.000Z',
    updatedAt: '2024-02-07T00:00:00.000Z',
    tags: [
      'Case Study',
      'YouTube Growth',
      'E-commerce',
      'Content Strategy'
    ]
  };

  return NextResponse.json({ caseStudy });
} 
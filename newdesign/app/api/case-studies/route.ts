import { NextResponse } from 'next/server';

export async function GET() {
  const caseStudies = [
    {
      id: 'youtube-success-case',
      slug: 'youtube-success-case',
      title: {
        en: 'How a Brand 10x Their YouTube Subscribers',
        zh: '品牌如何将 YouTube 订阅者增长10倍'
      },
      excerpt: {
        en: 'A success story of rapid YouTube channel growth',
        zh: 'YouTube 频道快速增长的成功案例'
      }
    },
    {
      id: 'tiktok-success-case',
      slug: 'tiktok-success-case',
      title: {
        en: 'TikTok Shop Success Story',
        zh: 'TikTok 电商成功案例'
      },
      excerpt: {
        en: 'How to leverage TikTok for e-commerce success',
        zh: '如何利用 TikTok 实现电商成功'
      }
    },
    {
      id: 'cross-platform-success',
      slug: 'cross-platform-success',
      title: {
        en: 'Cross-Platform Marketing Success',
        zh: '跨平台营销成功案例'
      },
      excerpt: {
        en: 'Achieving success across multiple platforms',
        zh: '实现多平台营销成功'
      }
    }
  ];

  return NextResponse.json({ caseStudies });
}
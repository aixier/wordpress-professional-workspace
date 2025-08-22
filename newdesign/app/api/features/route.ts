import { NextResponse } from 'next/server';

export async function GET() {
  const features = [
    {
      id: 'youtube-analytics',
      title: {
        en: 'YouTube Analytics',
        zh: 'YouTube 数据分析'
      },
      description: {
        en: 'Comprehensive YouTube channel and video analytics',
        zh: '全面的 YouTube 频道和视频数据分析'
      }
    },
    {
      id: 'tiktok-analytics',
      title: {
        en: 'TikTok Analytics',
        zh: 'TikTok 数据分析'
      },
      description: {
        en: 'In-depth TikTok account and content analytics',
        zh: '深度 TikTok 账号和内容数据分析'
      }
    },
    {
      id: 'competitor-analysis',
      title: {
        en: 'Competitor Analysis',
        zh: '竞品分析'
      },
      description: {
        en: 'Track and analyze your competitors',
        zh: '追踪和分析您的竞争对手'
      }
    },
    {
      id: 'trend-insights',
      title: {
        en: 'Trend Insights',
        zh: '趋势洞察'
      },
      description: {
        en: 'Discover trending topics and content',
        zh: '发现热门话题和内容'
      }
    }
  ];

  return NextResponse.json({ features });
} 
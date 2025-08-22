import { getServerSideSitemap } from 'next-sitemap';
import { ISitemapField } from 'next-sitemap';

export async function GET() {
  const dynamicPages: ISitemapField[] = [
    // 核心功能页面
    {
      loc: 'https://tubescanner.fsotool.com/features/youtube-analytics',
      lastmod: new Date().toISOString(),
      changefreq: 'weekly' as const,
      priority: 0.9
    },
    {
      loc: 'https://tubescanner.fsotool.com/features/tiktok-analytics',
      lastmod: new Date().toISOString(),
      changefreq: 'weekly' as const,
      priority: 0.9
    },
    {
      loc: 'https://tubescanner.fsotool.com/features/competitor-analysis',
      lastmod: new Date().toISOString(),
      changefreq: 'weekly' as const,
      priority: 0.8
    },
    {
      loc: 'https://tubescanner.fsotool.com/features/trend-insights',
      lastmod: new Date().toISOString(),
      changefreq: 'weekly' as const,
      priority: 0.8
    },

    // 文档中心
    {
      loc: 'https://tubescanner.fsotool.com/docs/getting-started',
      lastmod: new Date().toISOString(),
      changefreq: 'weekly' as const,
      priority: 0.8
    },
    {
      loc: 'https://tubescanner.fsotool.com/docs/api-reference',
      lastmod: new Date().toISOString(),
      changefreq: 'weekly' as const,
      priority: 0.7
    },
    {
      loc: 'https://tubescanner.fsotool.com/docs/youtube-data-api',
      lastmod: new Date().toISOString(),
      changefreq: 'weekly' as const,
      priority: 0.7
    },
    {
      loc: 'https://tubescanner.fsotool.com/docs/tiktok-data-api',
      lastmod: new Date().toISOString(),
      changefreq: 'weekly' as const,
      priority: 0.7
    },

    // 博客文章 - YouTube相关
    {
      loc: 'https://tubescanner.fsotool.com/blog/youtube-analytics-guide',
      lastmod: new Date().toISOString(),
      changefreq: 'monthly' as const,
      priority: 0.7
    },
    {
      loc: 'https://tubescanner.fsotool.com/blog/youtube-channel-growth-tips',
      lastmod: new Date().toISOString(),
      changefreq: 'monthly' as const,
      priority: 0.7
    },
    {
      loc: 'https://tubescanner.fsotool.com/blog/youtube-seo-optimization',
      lastmod: new Date().toISOString(),
      changefreq: 'monthly' as const,
      priority: 0.7
    },
    {
      loc: 'https://tubescanner.fsotool.com/blog/youtube-monetization-strategies',
      lastmod: new Date().toISOString(),
      changefreq: 'monthly' as const,
      priority: 0.7
    },

    // 博客文章 - TikTok相关
    {
      loc: 'https://tubescanner.fsotool.com/blog/tiktok-analytics-guide',
      lastmod: new Date().toISOString(),
      changefreq: 'monthly' as const,
      priority: 0.7
    },
    {
      loc: 'https://tubescanner.fsotool.com/blog/tiktok-content-strategy',
      lastmod: new Date().toISOString(),
      changefreq: 'monthly' as const,
      priority: 0.7
    },
    {
      loc: 'https://tubescanner.fsotool.com/blog/tiktok-trend-analysis',
      lastmod: new Date().toISOString(),
      changefreq: 'monthly' as const,
      priority: 0.7
    },
    {
      loc: 'https://tubescanner.fsotool.com/blog/tiktok-shop-optimization',
      lastmod: new Date().toISOString(),
      changefreq: 'monthly' as const,
      priority: 0.7
    },

    // 博客文章 - 跨境电商相关
    {
      loc: 'https://tubescanner.fsotool.com/blog/cross-border-ecommerce-guide',
      lastmod: new Date().toISOString(),
      changefreq: 'monthly' as const,
      priority: 0.7
    },
    {
      loc: 'https://tubescanner.fsotool.com/blog/social-media-marketing-strategy',
      lastmod: new Date().toISOString(),
      changefreq: 'monthly' as const,
      priority: 0.7
    },
    {
      loc: 'https://tubescanner.fsotool.com/blog/influencer-marketing-tips',
      lastmod: new Date().toISOString(),
      changefreq: 'monthly' as const,
      priority: 0.7
    },

    // 案例研究
    {
      loc: 'https://tubescanner.fsotool.com/case-studies/success-story-1',
      lastmod: new Date().toISOString(),
      changefreq: 'monthly' as const,
      priority: 0.8
    },
    {
      loc: 'https://tubescanner.fsotool.com/case-studies/youtube-success-case',
      lastmod: new Date().toISOString(),
      changefreq: 'monthly' as const,
      priority: 0.8
    },
    {
      loc: 'https://tubescanner.fsotool.com/case-studies/tiktok-success-case',
      lastmod: new Date().toISOString(),
      changefreq: 'monthly' as const,
      priority: 0.8
    },
    {
      loc: 'https://tubescanner.fsotool.com/case-studies/cross-platform-success',
      lastmod: new Date().toISOString(),
      changefreq: 'monthly' as const,
      priority: 0.8
    },

    // 工具和资源
    {
      loc: 'https://tubescanner.fsotool.com/resources/youtube-templates',
      lastmod: new Date().toISOString(),
      changefreq: 'monthly' as const,
      priority: 0.6
    },
    {
      loc: 'https://tubescanner.fsotool.com/resources/tiktok-templates',
      lastmod: new Date().toISOString(),
      changefreq: 'monthly' as const,
      priority: 0.6
    },
    {
      loc: 'https://tubescanner.fsotool.com/resources/analytics-reports',
      lastmod: new Date().toISOString(),
      changefreq: 'monthly' as const,
      priority: 0.6
    }
  ];

  return getServerSideSitemap([
    ...dynamicPages,
    ...dynamicPages.map(page => ({
      ...page,
      loc: page.loc.replace('tubescanner.fsotool.com/', 'tubescanner.fsotool.com/en/'),
    })),
    ...dynamicPages.map(page => ({
      ...page,
      loc: page.loc.replace('tubescanner.fsotool.com/', 'tubescanner.fsotool.com/zh/'),
    }))
  ]);
}
/** @type {import('next-sitemap').IConfig} */
module.exports = {
  siteUrl: process.env.NEXT_PUBLIC_SITE_URL || "https://tubescanner.fsotool.com",
  generateRobotsTxt: true,
  sitemapSize: 7000,
  generateIndexSitemap: true,
  outDir: "public",
  exclude: ['/api/*', '/admin/*', '/404', '/500'],
  alternateRefs: [
    {
      href: 'https://tubescanner.fsotool.com/en',
      hreflang: 'en'
    },
    {
      href: 'https://tubescanner.fsotool.com/zh',
      hreflang: 'zh'
    }
  ],
  // 添加主要路由
  additionalPaths: async (config) => [
    // 主要页面
    {
      loc: '/',
      changefreq: 'daily',
      priority: 1.0,
      lastmod: new Date().toISOString(),
    },
    // 功能特性页面
    {
      loc: '/features',
      changefreq: 'weekly',
      priority: 0.9,
      lastmod: new Date().toISOString(),
    },
    // 文档中心
    {
      loc: '/docs',
      changefreq: 'weekly',
      priority: 0.8,
      lastmod: new Date().toISOString(),
    },
    // 博客
    {
      loc: '/blog',
      changefreq: 'weekly',
      priority: 0.8,
      lastmod: new Date().toISOString(),
    },
    // 案例研究
    {
      loc: '/case-studies',
      changefreq: 'weekly',
      priority: 0.8,
      lastmod: new Date().toISOString(),
    }
  ],
  transform: async (config, path) => {
    // 为不同类型的页面设置不同的优先级和更新频率
    const priority = 
      path === '/' ? 1.0 :
      path.startsWith('/features') ? 0.9 :
      path.startsWith('/docs') ? 0.8 :
      path.startsWith('/blog') ? 0.7 :
      path.startsWith('/case-studies') ? 0.8 :
      0.5;

    const changefreq = 
      path === '/' ? 'daily' :
      path.startsWith('/blog') ? 'weekly' :
      path.startsWith('/docs') ? 'weekly' :
      'monthly';

    return {
      loc: path,
      changefreq,
      priority,
      lastmod: new Date().toISOString(),
      alternateRefs: config.alternateRefs ?? []
    }
  },
  robotsTxtOptions: {
    policies: [
      {
        userAgent: '*',
        allow: '/',
        disallow: ['/api', '/admin', '/private']
      },
      {
        userAgent: 'Googlebot',
        allow: '/',
        disallow: ['/api', '/admin', '/private'],
        crawlDelay: 2
      },
      {
        userAgent: 'Bingbot',
        allow: '/',
        disallow: ['/api', '/admin', '/private'],
        crawlDelay: 2
      }
    ],
    additionalSitemaps: [
      'https://tubescanner.fsotool.com/sitemap.xml',
      'https://tubescanner.fsotool.com/server-sitemap.xml'
    ]
  }
}
import { MetadataRoute } from 'next'

export default function sitemap(): MetadataRoute.Sitemap {
  const baseUrl = process.env.NEXT_PUBLIC_SITE_URL || "https://tubescanner.fsotool.com"
  
  // 基础路由
  const routes = [
    '',
    '/features',
    '/docs',
    '/blog',
    '/case-studies',
  ].map((route) => ({
    url: `${baseUrl}${route}`,
    lastModified: new Date(),
    changeFrequency: 'daily' as const,
    priority: 1,
  }))

  // 语言变体
  const locales = ['en', 'zh']
  const localizedRoutes = locales.flatMap((locale) =>
    routes.map((route) => ({
      url: `${baseUrl}/${locale}${route}`,
      lastModified: new Date(),
      changeFrequency: 'daily' as const,
      priority: 0.9,
    }))
  )

  return [...routes, ...localizedRoutes]
} 
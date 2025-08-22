import type { IconType } from 'react-icons/lib'

export type AuthorsConfig = {
  name: string
  url: string
  twitter?: string
}
export type ProductLink = {
  url: string
  name: string
}
export type Link = {
  name: string
  href: string
  icon: IconType
}
export type ThemeColor = {
  media: string
  color: string
}
export type SiteConfig = {
  name: string
  description: string
  url: string
  keywords: string[]
  authors: AuthorsConfig[]
  creator: string
  openSourceURL?: string
  ogImage: string
  headerLinks: Link[]
  footerLinks: Link[],
  footerProducts: ProductLink[]
  metadataBase: URL | string
  themeColors?: string | ThemeColor[]
  nextThemeColor?: string
  icons: {
    icon: string
    shortcut?: string
    apple?: string
  }
  openGraph: {
    type: string
    locale: string
    locales?: string[]
    url: string
    title: string
    description: string
    siteName: string
    images?: string[]
    article?: {
      publishedTime: string
      modifiedTime: string
      section: string
      authors: string[]
    }
    twitter?: {
      card: string
      site: string
      creator: string
    }
  },
  alternates?: {
    canonical: string
    languages: {
      [key: string]: string
    }
    countries?: {
      [key: string]: string
    }
  },
  i18n?: {
    defaultLocale: string
    locales: string[]
    localeMap: {
      [key: string]: string
    }
  },
  robots?: {
    index: boolean
    follow: boolean
    googleBot: {
      index: boolean
      follow: boolean
      'max-video-preview'?: number
      'max-image-preview'?: string
      'max-snippet'?: number
    }
  },
  structuredData?: {
    "@context": string
    "@type": string
    name: string
    description: string
    applicationCategory: string
    operatingSystem: string
    offers: {
      "@type": string
      price: string
      priceCurrency: string
    }
  }
}

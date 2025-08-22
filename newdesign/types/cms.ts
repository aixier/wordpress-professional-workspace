export interface LocalizedString {
  zh: string;
  en: string;
}

export interface Author {
  name: string;
  title: string;
  avatar: string;
  bio: LocalizedString;
}

export interface CMSContent {
  id: string;
  slug: string;
  type: 'blog' | 'case-study' | 'feature' | 'doc';
  title: LocalizedString;
  description: LocalizedString;
  content: LocalizedString;
  metadata: {
    author?: Author;
    publishedAt: string;
    updatedAt: string;
    tags: string[];
    category: string;
    coverImage?: string;
    relatedContent: string[];
    order?: number;
    sidebarTitle?: LocalizedString;
    results?: Record<string, string[]>;
  };
  seo?: {
    metaTitle?: LocalizedString;
    metaDescription?: LocalizedString;
    keywords?: string[];
    canonicalUrl?: string;
  };
}

export type Feature = CMSContent & {
  type: 'feature';
}; 
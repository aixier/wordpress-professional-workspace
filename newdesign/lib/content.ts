import path from 'path';
import fs from 'fs/promises';
import matter from 'gray-matter';
import { CMSContent } from '@/types/cms';
import { ContentSchema } from './validators/content';

const CONTENT_DIR = path.join(process.cwd(), 'content');

const TYPE_MAP: Record<string, CMSContent['type']> = {
  'blog': 'blog',
  'case-studies': 'case-study',
  'features': 'feature',
  'docs': 'doc'
};

export async function getContentBySlug(type: string, slug: string): Promise<CMSContent | null> {
  try {
    const fullPath = path.join(CONTENT_DIR, type, slug, 'index.md');
    const fileContents = await fs.readFile(fullPath, 'utf8');
    const { data, content } = matter(fileContents);

    const now = new Date().toISOString();

    const contentObj = {
      id: slug,
      slug,
      type: TYPE_MAP[type] || type as CMSContent['type'],
      title: data.title || { zh: '', en: '' },
      description: data.description || { zh: '', en: '' },
      content: { zh: content, en: content },
      metadata: {
        author: data.metadata?.author,
        publishedAt: data.publishedAt || now,
        updatedAt: data.updatedAt || data.publishedAt || now,
        tags: data.tags || ['default'],
        category: data.category || 'uncategorized',
        coverImage: data.metadata?.coverImage,
        relatedContent: data.metadata?.relatedContent || []
      },
      seo: data.seo ? {
        metaTitle: data.seo.metaTitle || data.title,
        metaDescription: data.seo.metaDescription || data.description,
        keywords: data.seo.keywords || data.tags || ['default'],
        canonicalUrl: data.seo.canonicalUrl
      } : undefined
    };

    return ContentSchema.parse(contentObj);
  } catch (error) {
    console.error(`Error loading content for ${type}/${slug}:`, error);
    return null;
  }
}

export async function getAllContent(type: string): Promise<CMSContent[]> {
  try {
    const contentPath = path.join(CONTENT_DIR, type);
    const dirs = await fs.readdir(contentPath);
    
    const contents = await Promise.all(
      dirs.map(async (dir) => {
        const content = await getContentBySlug(type, dir);
        return content;
      })
    );

    return contents.filter((content): content is CMSContent => content !== null);
  } catch (error) {
    console.error(`Error loading ${type} content:`, error);
    return [];
  }
} 
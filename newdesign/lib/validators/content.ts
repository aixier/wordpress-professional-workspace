import { z } from 'zod';

export const LocalizedStringSchema = z.object({
  zh: z.string().min(1),
  en: z.string().min(1)
});

export const AuthorSchema = z.object({
  name: z.string().min(1),
  title: z.string().min(1),
  avatar: z.string().startsWith('/'),
  bio: LocalizedStringSchema
});

export const MetadataSchema = z.object({
  author: AuthorSchema.optional(),
  publishedAt: z.string().datetime(),
  updatedAt: z.string().datetime(),
  tags: z.array(z.string()).min(1),
  category: z.string().min(1),
  coverImage: z.string().startsWith('/').optional(),
  relatedContent: z.array(z.string()).default([])
});

export const SEOSchema = z.object({
  metaTitle: LocalizedStringSchema.optional(),
  metaDescription: LocalizedStringSchema.optional(),
  keywords: z.array(z.string()).optional(),
  canonicalUrl: z.string().url().optional()
}).optional();

export const ContentSchema = z.object({
  id: z.string(),
  slug: z.string(),
  type: z.enum(['blog', 'case-study', 'feature', 'doc']),
  title: LocalizedStringSchema,
  description: LocalizedStringSchema,
  content: LocalizedStringSchema,
  metadata: MetadataSchema,
  seo: SEOSchema
}); 
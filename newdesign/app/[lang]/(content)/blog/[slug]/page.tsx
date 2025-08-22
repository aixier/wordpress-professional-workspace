import { getContentBySlug } from '@/lib/content';
import { BlogPostContent } from '@/components/blog/BlogPostContent';
import { Locale } from '@/lib/i18n';

interface PageProps {
  params: { 
    lang: Locale;
    slug: string;
  };
}

export default async function BlogPostPage({ params: { lang, slug } }: PageProps) {
  const post = await getContentBySlug('blog', slug);
  if (!post) return null;
  
  return <BlogPostContent post={post} lang={lang} />;
}
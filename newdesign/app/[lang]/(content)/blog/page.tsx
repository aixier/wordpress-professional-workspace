import { getAllContent } from '@/lib/content';
import { BlogContent } from '@/components/blog/BlogContent';
import { Locale } from '@/lib/i18n';

interface PageProps {
  params: { lang: Locale };
}

export default async function BlogPage({ params: { lang } }: PageProps) {
  const posts = await getAllContent('blog');
  
  return <BlogContent posts={posts} lang={lang} />;
} 
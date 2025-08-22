import { CMSContent } from '@/types/cms';
import { Locale } from '@/lib/i18n';

interface BlogContentProps {
  posts: CMSContent[];
  lang: Locale;
}

export function BlogContent({ posts, lang }: BlogContentProps) {
  return (
    <div className="grid gap-8">
      {posts.map((post) => (
        <article key={post.id} className="p-6 bg-white rounded-lg shadow">
          <h2 className="text-2xl font-bold mb-2">
            {post.title[lang]}
          </h2>
          <p className="text-gray-600">
            {post.description[lang]}
          </p>
        </article>
      ))}
    </div>
  );
} 
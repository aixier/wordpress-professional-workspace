import { CMSContent } from '@/types/cms';
import { Locale } from '@/lib/i18n';
import Image from 'next/image';

interface BlogPostContentProps {
  post: CMSContent;
  lang: Locale;
}

export function BlogPostContent({ post, lang }: BlogPostContentProps) {
  return (
    <article className="prose lg:prose-xl mx-auto">
      <h1>{post.title[lang]}</h1>
      {post.metadata.author && (
        <div className="flex items-center gap-4 my-4">
          <Image
            src={post.metadata.author.avatar}
            alt={post.metadata.author.name}
            width={48}
            height={48}
            className="w-12 h-12 rounded-full"
          />
          <div>
            <h3 className="font-medium">{post.metadata.author.name}</h3>
            <p className="text-gray-600">{post.metadata.author.bio[lang]}</p>
          </div>
        </div>
      )}
      <div dangerouslySetInnerHTML={{ __html: post.content[lang] }} />
    </article>
  );
}
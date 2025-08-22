import { CMSContent } from '@/types/cms';
import { Locale } from '@/lib/i18n';

interface DocContentProps {
  docs: CMSContent[];
  lang: Locale;
}

export function DocContent({ docs, lang }: DocContentProps) {
  // 按 order 排序
  const sortedDocs = [...docs].sort((a, b) => 
    (a.metadata.order || 0) - (b.metadata.order || 0)
  );

  return (
    <div className="max-w-4xl mx-auto">
      {sortedDocs.map((doc) => (
        <article key={doc.id} className="mb-8">
          <h2 className="text-2xl font-bold mb-4">
            {doc.metadata.sidebarTitle?.[lang] || doc.title[lang]}
          </h2>
          <div className="prose max-w-none">
            <div dangerouslySetInnerHTML={{ __html: doc.content[lang] }} />
          </div>
        </article>
      ))}
    </div>
  );
} 
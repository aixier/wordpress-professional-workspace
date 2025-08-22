import { getAllContent } from '@/lib/content';
import { DocContent } from '@/components/docs/DocContent';
import { Locale } from '@/lib/i18n';

interface PageProps {
  params: { lang: Locale };
}

export default async function DocsPage({ params: { lang } }: PageProps) {
  const docs = await getAllContent('docs');
  
  return <DocContent docs={docs} lang={lang} />;
} 
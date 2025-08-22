import { getAllContent } from '@/lib/content';
import { CaseStudyCard } from '@/components/case-studies/CaseStudyCard';
import { Locale } from '@/lib/i18n';

interface PageProps {
  params: { lang: Locale };
}

export default async function CaseStudiesPage({ params: { lang } }: PageProps) {
  const cases = await getAllContent('case-studies');
  
  return (
    <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
      {cases.map((caseStudy) => (
        <CaseStudyCard 
          key={caseStudy.id}
          caseStudy={caseStudy}
          lang={lang}
        />
      ))}
    </div>
  );
} 
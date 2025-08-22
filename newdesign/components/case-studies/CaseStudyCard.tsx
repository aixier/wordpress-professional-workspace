import Image from 'next/image';
import { CMSContent } from '@/types/cms';
import { Locale } from '@/lib/i18n';

interface CaseStudyCardProps {
  caseStudy: CMSContent;
  lang: Locale;
}

export function CaseStudyCard({ caseStudy, lang }: CaseStudyCardProps) {
  return (
    <div className="bg-white rounded-lg shadow-md overflow-hidden">
      {caseStudy.metadata.coverImage && (
        <Image
          src={caseStudy.metadata.coverImage}
          alt={caseStudy.title[lang]}
          width={600}
          height={400}
          className="w-full object-cover"
        />
      )}
      <div className="p-6">
        <h3 className="text-xl font-bold mb-2">{caseStudy.title[lang]}</h3>
        <p className="text-gray-600 mb-4">{caseStudy.description[lang]}</p>
        <div className="space-y-2">
          {caseStudy.metadata.results?.[lang]?.map((result, index) => (
            <div key={index} className="flex items-center">
              <span className="text-green-500 mr-2">✓</span>
              <span>{result}</span>
            </div>
          ))}
        </div>
      </div>
    </div>
  );
} 
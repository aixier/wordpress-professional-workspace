import Image from 'next/image';
import { CMSContent } from '@/types/cms';
import { Locale } from '@/lib/i18n';

interface FeatureCardProps {
  feature: CMSContent;
  lang: Locale;
}

export function FeatureCard({ feature, lang }: FeatureCardProps) {
  return (
    <div className="rounded-lg shadow-md overflow-hidden">
      {feature.metadata.coverImage && (
        <Image
          src={feature.metadata.coverImage}
          alt={feature.title[lang]}
          width={400}
          height={250}
          className="w-full object-cover"
        />
      )}
      <div className="p-6">
        <h3 className="text-xl font-semibold mb-2">
          {feature.title[lang]}
        </h3>
        <p className="text-gray-600">
          {feature.description[lang]}
        </p>
      </div>
    </div>
  );
} 
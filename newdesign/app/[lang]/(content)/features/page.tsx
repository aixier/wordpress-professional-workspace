import { getAllContent } from '@/lib/content';
import { FeatureCard } from '@/components/feature-cards/FeatureCard';
import { Locale } from '@/lib/i18n';

interface PageProps {
  params: { lang: Locale };
}

export default async function FeaturesPage({ params: { lang } }: PageProps) {
  // 从 content/features 获取内容
  const features = await getAllContent('features');
  
  return (
    <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      {features.map((feature) => (
        <FeatureCard 
          key={feature.id}
          feature={feature}
          lang={lang}
        />
      ))}
    </div>
  );
} 
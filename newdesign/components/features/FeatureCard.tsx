import { type Feature } from '@/types/cms';
import Image from 'next/image';

interface FeatureCardProps {
  feature: Feature;
  lang: 'en' | 'zh';
}

export function FeatureCard({ feature, lang }: FeatureCardProps) {
  if (!feature) {
    return null;
  }

  return (
    <div className="rounded-lg shadow-md overflow-hidden">
      {feature.metadata?.coverImage && (
        <Image
          src={feature.metadata.coverImage}
          alt={feature.title?.[lang] ?? 'Feature image'}
          width={400}
          height={250}
          className="w-full object-cover"
        />
      )}
      <div className="p-6">
        <h3 className="text-xl font-semibold mb-2">
          {feature.title?.[lang] ?? 'Untitled Feature'}
        </h3>
        <p className="text-gray-600">
          {feature.description?.[lang] ?? ''}
        </p>
      </div>
    </div>
  );
}
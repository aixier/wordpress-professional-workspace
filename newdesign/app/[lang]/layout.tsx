import * as React from 'react';
import { type Metadata } from 'next';
import { getLocalizedConfig } from '@/config/site';
import MainNav from '@/components/navigation/MainNav';

interface Props {
  params: {
    lang: string;
  };
  children: React.ReactNode;
}

export default function Layout({ params: { lang }, children }: Props) {
  return (
    <>
      <MainNav lang={lang} />
      {children}
    </>
  );
}

export async function generateMetadata({ params: { lang } }: Props): Promise<Metadata> {
  const config = getLocalizedConfig(lang);
  
  const alternates = config.alternates ? {
    canonical: config.url,
    languages: config.alternates.languages,
  } : undefined;

  const otherLocales = config.i18n?.locales?.filter((l: string) => l !== lang) || [];

  return {
    metadataBase: new URL(config.url),
    title: {
      template: `%s | ${config.name}`,
      default: config.name,
    },
    description: config.description,
    keywords: config.keywords,
    alternates,
    openGraph: {
      ...config.openGraph,
      locale: lang,
      alternateLocale: otherLocales,
    },
    robots: {
      index: true,
      follow: true,
      googleBot: {
        index: true,
        follow: true,
        'max-video-preview': -1,
        'max-image-preview': 'large',
        'max-snippet': -1,
      },
    },
  };
}
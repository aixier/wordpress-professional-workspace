import { Metadata } from 'next';
import { siteConfig } from "@/config/site";
import HomeIndex from "@/components/home/HomeIndex";

export async function generateMetadata({ params: { lang } }: { params: { lang: string } }): Promise<Metadata> {
  return {
    title: siteConfig.name,
    description: siteConfig.description,
    alternates: {
      canonical: siteConfig.url,
      languages: {
        'en': '/en',
        'zh': '/zh',
      },
    },
  };
}

export default function Home({ params: { lang } }: { params: { lang: string } }) {
  const structuredData = {
    "@context": "https://schema.org",
    "@type": "WebApplication",
    "name": "TubeScanner",
    "applicationCategory": "BusinessApplication",
    "operatingSystem": "Any",
    "description": lang === 'zh' ? 
      "专业的跨境社媒数据分析工具，支持YouTube和TikTok数据分析" : 
      "Professional cross-border social media analytics tool supporting YouTube and TikTok analysis",
    "offers": {
      "@type": "Offer",
      "price": "0",
      "priceCurrency": "USD"
    },
    "aggregateRating": {
      "@type": "AggregateRating",
      "ratingValue": "4.8",
      "ratingCount": "1250"
    },
    "featureList": [
      "YouTube Analytics",
      "TikTok Analytics",
      "Competitor Analysis",
      "Trend Insights"
    ],
    "screenshot": [
      {
        "@type": "ImageObject",
        "url": "https://tubescanner.fsotool.com/screenshots/dashboard.png"
      }
    ],
    "author": {
      "@type": "Organization",
      "name": "FSO Tool",
      "url": "https://fsotool.com"
    }
  };

  return (
    <>
      <script
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(structuredData) }}
      />
      <HomeIndex lang={lang} />
    </>
  );
}

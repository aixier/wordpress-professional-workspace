interface SchemaOrgProps {
  lang: string;
  pageType: 'website' | 'article' | 'product' | 'organization';
  title: string;
  description: string;
  url: string;
  imageUrl?: string;
  datePublished?: string;
  dateModified?: string;
  breadcrumbs?: {
    name: string;
    item: string;
  }[];
}

export default function SchemaOrg({
  lang,
  pageType,
  title,
  description,
  url,
  imageUrl,
  datePublished,
  dateModified,
  breadcrumbs
}: SchemaOrgProps) {
  const websiteSchema = {
    "@context": "https://schema.org",
    "@type": "WebSite",
    "name": "TubeScanner",
    "url": "https://tubescanner.fsotool.com",
    "description": lang === 'zh' ? 
      "专业的跨境社媒数据分析工具，支持YouTube和TikTok数据分析" : 
      "Professional cross-border social media analytics tool supporting YouTube and TikTok analysis",
    "potentialAction": {
      "@type": "SearchAction",
      "target": "https://tubescanner.fsotool.com/search?q={search_term_string}",
      "query-input": "required name=search_term_string"
    }
  };

  const organizationSchema = {
    "@context": "https://schema.org",
    "@type": "Organization",
    "name": "TubeScanner",
    "url": "https://tubescanner.fsotool.com",
    "logo": "https://tubescanner.fsotool.com/tubescanner.png",
    "sameAs": [
      "https://twitter.com/tubescanner",
      "https://www.linkedin.com/company/tubescanner"
    ]
  };

  const articleSchema = pageType === 'article' ? {
    "@context": "https://schema.org",
    "@type": "Article",
    "headline": title,
    "description": description,
    "image": imageUrl,
    "datePublished": datePublished,
    "dateModified": dateModified,
    "url": url,
    "publisher": organizationSchema
  } : null;

  const breadcrumbSchema = breadcrumbs ? {
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": breadcrumbs.map((item, index) => ({
      "@type": "ListItem",
      "position": index + 1,
      "name": item.name,
      "item": item.item
    }))
  } : null;

  return (
    <>
      <script
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(websiteSchema) }}
      />
      <script
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(organizationSchema) }}
      />
      {articleSchema && (
        <script
          type="application/ld+json"
          dangerouslySetInnerHTML={{ __html: JSON.stringify(articleSchema) }}
        />
      )}
      {breadcrumbSchema && (
        <script
          type="application/ld+json"
          dangerouslySetInnerHTML={{ __html: JSON.stringify(breadcrumbSchema) }}
        />
      )}
    </>
  );
} 
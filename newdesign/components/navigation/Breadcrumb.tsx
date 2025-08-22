'use client';

import Link from 'next/link';
import { usePathname } from 'next/navigation';

interface BreadcrumbProps {
  lang: string;
}

export default function Breadcrumb({ lang }: BreadcrumbProps) {
  const pathname = usePathname();
  const paths = pathname.split('/').filter(Boolean);
  
  const breadcrumbData = {
    "@context": "https://schema.org",
    "@type": "BreadcrumbList",
    "itemListElement": paths.map((path, index) => ({
      "@type": "ListItem",
      "position": index + 1,
      "item": {
        "@id": `/${paths.slice(0, index + 1).join('/')}`,
        "name": getBreadcrumbName(path, lang)
      }
    }))
  };

  function getBreadcrumbName(path: string, lang: string): string {
    const nameMap: { [key: string]: { [key: string]: string } } = {
      'features': {
        'en': 'Features',
        'zh': '功能特性'
      },
      'docs': {
        'en': 'Documentation',
        'zh': '文档中心'
      },
      'blog': {
        'en': 'Blog',
        'zh': '博客'
      },
      'case-studies': {
        'en': 'Case Studies',
        'zh': '客户案例'
      }
    };

    return nameMap[path]?.[lang] || path;
  }

  return (
    <>
      <script
        type="application/ld+json"
        dangerouslySetInnerHTML={{ __html: JSON.stringify(breadcrumbData) }}
      />
      
      <nav aria-label="breadcrumb" className="py-4 px-4 overflow-x-auto">
        <ol className="flex flex-nowrap space-x-2 text-sm whitespace-nowrap min-w-full md:min-w-0">
          <li className="flex-shrink-0">
            <Link href={`/${lang}`} className="text-blue-600 hover:text-blue-800">
              {lang === 'zh' ? '首页' : 'Home'}
            </Link>
          </li>
          {paths.map((path, index) => (
            <li key={path} className="flex items-center flex-shrink-0">
              <span className="mx-2 text-gray-500">/</span>
              {index === paths.length - 1 ? (
                <span className="text-gray-700 truncate max-w-[150px] md:max-w-none">
                  {getBreadcrumbName(path, lang)}
                </span>
              ) : (
                <Link
                  href={`/${paths.slice(0, index + 1).join('/')}`}
                  className="text-blue-600 hover:text-blue-800 truncate max-w-[150px] md:max-w-none"
                >
                  {getBreadcrumbName(path, lang)}
                </Link>
              )}
            </li>
          ))}
        </ol>
      </nav>
    </>
  );
}
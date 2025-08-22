import Link from 'next/link';
import { locales, localeNames, defaultLocale, Locale } from '@/lib/i18n';

export default function LangLinks() {
  return (
    <div className="flex space-x-2 flex-wrap justify-center">
      {Object.keys(localeNames).map((key) => {
        const locale = key as Locale;
        const name = localeNames[locale];
        return (
          <span key={locale}>
            <Link href={`/${locale === defaultLocale ? "" : locale}`}>{name}</Link>
          </span>
        );
      })}
    </div>
  );
}

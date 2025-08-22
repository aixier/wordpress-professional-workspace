import * as React from 'react';
import { LineText } from "@/components/LineText";
import CTAButton from "@/components/home/CTAButton";
import { motion } from "framer-motion";

interface LocaleType {
  cta: {
    title: string;
    subtitle: string;
    description: string;
  };
  content: {
    title1: string;
    title2: string;
    title3: string;
    title4: string;
  };
  description: string;
}

interface CTALocaleType {
  [key: string]: string;
}

interface HeroProps {
  locale: LocaleType;
  CTALocale: CTALocaleType;
}

const Hero = ({ locale, CTALocale }: HeroProps) => {
  return (
    <section className="min-h-[calc(100vh-80px)] flex items-center justify-center">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
        {/* Main Hero Content */}
        <div className="max-w-4xl mx-auto">
          {/* CTA Content */}
          <div className="space-y-4 mb-8">
            <h1 className="text-4xl sm:text-5xl md:text-6xl font-bold tracking-tight">
              {locale.cta.title}
            </h1>
            <p className="text-xl sm:text-2xl md:text-3xl text-slate-700 dark:text-slate-300">
              {locale.cta.subtitle}
            </p>
            <p className="text-lg sm:text-xl md:text-2xl text-slate-600 dark:text-slate-400">
              {locale.cta.description}
            </p>
          </div>

          {/* CTA Button */}
          <div className="mt-10">
            <CTAButton locale={CTALocale} />
          </div>

          {/* Original Content */}
          <div className="space-y-4 mt-16">
            <p className="text-xl sm:text-2xl text-slate-700 dark:text-slate-300">
              {locale.content.title1}
              {locale.content.title2}
              {locale.content.title3 && <br />}
              {locale.content.title3}
              {locale.content.title4 && <br />}
              {locale.content.title4}
            </p>
          </div>

          {/* Description if exists */}
          {locale.description && (
            <article className="mt-8 prose lg:prose-xl mx-auto">
              <p className="text-slate-700 dark:text-slate-400">
                {locale.description}
              </p>
            </article>
          )}
        </div>

        {/* Structured Data */}
        <script type="application/ld+json">
          {JSON.stringify({
            "@context": "https://schema.org",
            "@type": "WebApplication",
            "name": locale.cta.title,
            "description": locale.description
          })}
        </script>
      </div>
    </section>
  );
};

export default Hero;
import CTA from "@/components/home/CTA";
import FAQ from "@/components/home/FAQ";
import Feature from "@/components/home/Feature";
import Hero from "@/components/home/Hero";
import Testimonials from "@/components/home/Testimonials";
import { defaultLocale, getDictionary } from "@/lib/i18n";


export default async function HomeIndex({ lang }: { lang: string }) {
  const langName = lang || defaultLocale;
  const dict = await getDictionary(langName);

  return (
    <>
      {/* Hero Section */}
      <Hero locale={dict.Hero} CTALocale={dict.CTAButton} />

      <Testimonials id="Testimonials" locale={dict.Testimonials} langName={langName} />
      {/* USP (Unique Selling Proposition) */}
      <Feature id="Features" locale={dict.Feature} langName={langName} />
      {/* FAQ (Frequently Asked Questions) */}
      <FAQ id="FAQ" locale={dict.FAQ} langName={langName} />

      {/* CTA (Call to Action) */}
      <CTA locale={dict.CTA} CTALocale={dict.CTAButton} />
    </>
  );
}

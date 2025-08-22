import { match } from "@formatjs/intl-localematcher";
import Negotiator from "negotiator";
import type { NextRequest } from 'next/server';

export const locales = ['en', 'zh'] as const;
export type Locale = typeof locales[number];

export const defaultLocale = 'en';

export const localeNames: Record<Locale, string> = {
  en: 'English',
  zh: '中文'
};

// If you wish to automatically redirect users to a URL that matches their browser's language setting,
// you can use the `getLocale` to get the browser's language.
export function getLocale(headers: NextRequest['headers']): Locale {
  const languages = new Negotiator({ headers: Object.fromEntries(headers) }).languages();
  return match(languages, locales, defaultLocale) as Locale;
}

const dictionaries: any = {
  en: () => import("@/locales/en.json").then((module) => module.default),
  zh: () => import("@/locales/zh.json").then((module) => module.default),
};

export const getDictionary = async (locale: string) => {
  if (["zh-CN", "zh-TW", "zh-HK"].includes(locale)) {
    locale = "zh";
  }

  if (!Object.keys(dictionaries).includes(locale)) {
    locale = "en";
  }

  return dictionaries[locale]();
};

export function getLocaleFromPath(path: string): Locale {
  const locale = path.split('/')[1];
  return locales.includes(locale as Locale) ? (locale as Locale) : defaultLocale;
}

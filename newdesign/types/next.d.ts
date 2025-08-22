import type { Metadata as NextMetadata } from 'next';

declare module 'next' {
  interface Metadata extends NextMetadata {
    openGraph?: {
      locale?: string;
      alternateLocale?: string[];
      [key: string]: any;
    };
  }
} 
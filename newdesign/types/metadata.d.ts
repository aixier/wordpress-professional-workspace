import type { Metadata as NextMetadata } from 'next';

declare module 'next' {
  interface OpenGraphMetadata {
    locale?: string;
    alternateLocale?: string[];
  }
} 
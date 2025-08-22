import * as React from 'react';
import type { ReactNode } from 'react';

import type { Metadata } from 'next/dist/lib/metadata/types/metadata-interface';
import type { Viewport } from 'next/dist/lib/metadata/types/metadata-interface';

import BaiDuAnalytics from "@/app/BaiDuAnalytics";
import GoogleAnalytics from "@/app/GoogleAnalytics";
import { TailwindIndicator } from "@/components/TailwindIndicator";
import { ThemeProvider } from "@/components/ThemeProvider";
import Footer from "@/components/footer/Footer";
import Header from "@/components/header/Header";
import { siteConfig } from "@/config/site";
import { defaultLocale } from "@/lib/i18n";
import { cn } from "@/lib/utils";

import "@/styles/globals.css";
import "@/styles/loading.css";
import { Inter as FontSans } from "next/font/google";

export const fontSans = FontSans({
  subsets: ["latin"],
  variable: "--font-sans",
});

export const metadata: Metadata = {
  title: siteConfig.name,
  description: siteConfig.description,
  keywords: siteConfig.keywords,
  authors: siteConfig.authors,
  creator: siteConfig.creator,
  icons: siteConfig.icons,
  metadataBase: new URL(siteConfig.metadataBase.toString()),
  openGraph: siteConfig.openGraph,
  verification: {
    google: "7o51IsNSJSECierrIiURvznjdPNAWTymo0JulI7IAqg",
    other: {
      "baidu-site-verification": "",
      "msvalidate.01": "C769F30ABECA177EB9008339E6D1BE2D",
    },
  },
};
export const viewport: Viewport = {
  themeColor: siteConfig.themeColors,
};

export default async function RootLayout({
  children,
  params: { lang },
}: {
  children: JSX.Element | JSX.Element[];
  params: { lang: string | undefined };
}) {
  return (
    <html lang={lang || defaultLocale} suppressHydrationWarning>
      <head>
        <link rel="preconnect" href="https://www.googletagmanager.com" />
        <link rel="preconnect" href="https://www.google-analytics.com" />
        
        <link rel="preload" href="/tubescanner.png" as="image" />
        
        <GoogleAnalytics />
        <BaiDuAnalytics />
      </head>
      <body
        className={cn(
          "min-h-screen bg-background font-sans antialiased",
          fontSans.variable
        )}
      >
        <ThemeProvider
          attribute="class"
          defaultTheme={siteConfig.nextThemeColor}
          enableSystem
        >
          <Header />
          <main className="flex flex-col items-center py-6">{children}</main>
          <Footer />
          <TailwindIndicator />
        </ThemeProvider>
      </body>
    </html>
  );
}
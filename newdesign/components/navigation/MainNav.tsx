'use client';

import Link from 'next/link';
import { usePathname } from 'next/navigation';
import { useState } from 'react';
import Image from 'next/image';

interface MainNavProps {
  lang: string;
}

export default function MainNav({ lang }: MainNavProps) {
  const pathname = usePathname();
  const [isMobileMenuOpen, setIsMobileMenuOpen] = useState(false);

  const navigation = [
    {
      name: {
        en: 'Home',
        zh: '首页'
      },
      href: `/${lang}`
    },
    {
      name: {
        en: 'Features',
        zh: '功能特性'
      },
      href: `/${lang}/features`
    },
    {
      name: {
        en: 'Documentation',
        zh: '文档中心'
      },
      href: `/${lang}/(content)/docs`
    },
    {
      name: {
        en: 'Blog',
        zh: '博客'
      },
      href: `/${lang}/(content)/blog`
    },
    {
      name: {
        en: 'Case Studies',
        zh: '客户案例'
      },
      href: `/${lang}/(content)/case-studies`
    }
  ];

  return (
    <nav className="bg-white shadow-sm fixed w-full top-0 z-50 h-16">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div className="flex justify-between h-16">
          <div className="flex">
            <div className="flex-shrink-0 flex items-center">
              <Link href={`/${lang}`}>
                <Image
                  src="/tubescanner.png"
                  alt="TubeScanner"
                  width={50}
                  height={20}
                  priority
                />
              </Link>
            </div>
            {/* Desktop Navigation */}
            <div className="hidden md:ml-6 md:flex md:space-x-8">
              {navigation.map((item) => {
                const isActive = pathname.startsWith(item.href);
                return (
                  <Link
                    key={item.href}
                    href={item.href}
                    className={`inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium ${
                      isActive
                        ? 'border-blue-500 text-gray-900'
                        : 'border-transparent text-gray-500 hover:border-gray-300 hover:text-gray-700'
                    }`}
                  >
                    {item.name[lang as keyof typeof item.name]}
                  </Link>
                );
              })}
            </div>
          </div>

          {/* Desktop Language Switch */}
          <div className="hidden md:ml-6 md:flex md:items-center">
            <Link
              href={lang === 'zh' ? '/en' : '/zh'}
              className="text-gray-500 hover:text-gray-700 px-3 py-2 rounded-md text-sm font-medium"
            >
              {lang === 'zh' ? 'English' : '中文'}
            </Link>
          </div>

          {/* Mobile menu button */}
          <div className="flex items-center md:hidden">
            <button
              type="button"
              className="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100"
              aria-controls="mobile-menu"
              aria-expanded="false"
              onClick={() => setIsMobileMenuOpen(!isMobileMenuOpen)}
            >
              <span className="sr-only">Open main menu</span>
              {/* Icon when menu is closed */}
              <svg
                className={`${isMobileMenuOpen ? 'hidden' : 'block'} h-6 w-6`}
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  strokeLinecap="round"
                  strokeLinejoin="round"
                  strokeWidth={2}
                  d="M4 6h16M4 12h16M4 18h16"
                />
              </svg>
              {/* Icon when menu is open */}
              <svg
                className={`${isMobileMenuOpen ? 'block' : 'hidden'} h-6 w-6`}
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  strokeLinecap="round"
                  strokeLinejoin="round"
                  strokeWidth={2}
                  d="M6 18L18 6M6 6l12 12"
                />
              </svg>
            </button>
          </div>
        </div>
      </div>

      {/* Mobile menu */}
      <div
        className={`${isMobileMenuOpen ? 'block' : 'hidden'} md:hidden`}
        id="mobile-menu"
      >
        <div className="pt-2 pb-3 space-y-1">
          {navigation.map((item) => {
            const isActive = pathname.startsWith(item.href);
            return (
              <Link
                key={item.href}
                href={item.href}
                className={`block pl-3 pr-4 py-2 border-l-4 text-base font-medium ${
                  isActive
                    ? 'border-blue-500 text-blue-700 bg-blue-50'
                    : 'border-transparent text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700'
                }`}
              >
                {item.name[lang as keyof typeof item.name]}
              </Link>
            );
          })}
          <Link
            href={lang === 'zh' ? '/en' : '/zh'}
            className="block pl-3 pr-4 py-2 border-l-4 border-transparent text-base font-medium text-gray-500 hover:bg-gray-50 hover:border-gray-300 hover:text-gray-700"
          >
            {lang === 'zh' ? 'English' : '中文'}
          </Link>
        </div>
      </div>

      {/* Add a spacer div to prevent content from being hidden under nav */}
      <div className="h-16"></div>
    </nav>
  );
} 
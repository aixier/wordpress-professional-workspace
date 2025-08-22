import { NextResponse } from 'next/server';
import type { NextRequest } from 'next/server';
import { locales, defaultLocale } from './lib/i18n';

export function middleware(request: NextRequest) {
  const { pathname } = request.nextUrl;

  // 检查路径是否已经包含语言前缀
  const pathnameHasLocale = locales.some(
    (locale) => pathname.startsWith(`/${locale}/`) || pathname === `/${locale}`
  );

  // 如果已经有语言前缀，不做处理
  if (pathnameHasLocale) return;

  // 始终使用英文作为默认语言
  const locale = defaultLocale;

  // 处理根路径
  if (pathname === '/') {
    return NextResponse.redirect(new URL(`/${locale}`, request.url));
  }

  // 为其他路径添加语言前缀
  return NextResponse.redirect(new URL(`/${locale}${pathname}`, request.url));
}

export const config = {
  matcher: [
    // 匹配所有路径，但排除不需要语言前缀的路径
    '/((?!api|_next/static|_next/image|favicon.ico|robots.txt|sitemap.xml|.*\\.(?:jpg|jpeg|gif|png|svg|ico|webp|js|css|woff|woff2)).*)'
  ]
};
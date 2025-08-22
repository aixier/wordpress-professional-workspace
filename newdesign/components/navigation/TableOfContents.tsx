'use client';

import { useEffect, useState } from 'react';

interface TableOfContentsProps {
  lang: string;
}

export default function TableOfContents({ lang }: TableOfContentsProps) {
  const [headings, setHeadings] = useState<{ id: string; text: string; level: number }[]>([]);
  const [activeId, setActiveId] = useState<string>('');

  useEffect(() => {
    const elements = Array.from(document.querySelectorAll('h2, h3, h4'))
      .map(element => ({
        id: element.id,
        text: element.textContent || '',
        level: parseInt(element.tagName.charAt(1))
      }));
    setHeadings(elements);

    const observer = new IntersectionObserver(
      entries => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            setActiveId(entry.target.id);
          }
        });
      },
      { rootMargin: '0px 0px -40% 0px' }
    );

    elements.forEach(heading => {
      const element = document.getElementById(heading.id);
      if (element) observer.observe(element);
    });

    return () => observer.disconnect();
  }, []);

  return (
    <nav className="sticky top-24 max-h-[calc(100vh-6rem)] overflow-auto p-4">
      <h2 className="text-lg font-semibold mb-4">
        {lang === 'zh' ? '目录' : 'Table of Contents'}
      </h2>
      <ul className="space-y-2">
        {headings.map(heading => (
          <li
            key={heading.id}
            style={{ paddingLeft: `${(heading.level - 2) * 1}rem` }}
          >
            <a
              href={`#${heading.id}`}
              className={`block py-1 text-sm ${
                activeId === heading.id
                  ? 'text-blue-600 font-medium'
                  : 'text-gray-600 hover:text-blue-600'
              }`}
              onClick={(e) => {
                e.preventDefault();
                document.getElementById(heading.id)?.scrollIntoView({
                  behavior: 'smooth'
                });
              }}
            >
              {heading.text}
            </a>
          </li>
        ))}
      </ul>
    </nav>
  );
} 
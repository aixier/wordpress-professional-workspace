export interface BlogPost {
  id: string;
  slug: string;
  title: {
    zh: string;
    en: string;
  };
  description: {
    zh: string;
    en: string;
  };
  content: {
    zh: string;
    en: string;
  };
  author: {
    name: string;
    title: string;
    avatar: string;
    bio: {
      zh: string;
      en: string;
    };
  };
  publishedAt: string;
  updatedAt: string;
  tags: string[];
  readingTime: number;
  category: string;
  coverImage: string;
  relatedPosts: string[];
} 
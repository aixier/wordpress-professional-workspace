/// <reference types="node" />
/// <reference types="react" />
/// <reference types="react-dom" />
/// <reference types="next" />

declare namespace NodeJS {
  interface ProcessEnv {
    NODE_ENV: 'development' | 'production' | 'test'
    NEXT_PUBLIC_BAIDU_TONGJI?: string
  }
}

declare module '@vercel/analytics/react' {
  export const Analytics: React.ComponentType
} 
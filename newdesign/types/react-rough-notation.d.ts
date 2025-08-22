declare module 'react-rough-notation' {
  import { ReactNode, ComponentType } from 'react';

  interface RoughNotationProps {
    type: 'underline' | 'box' | 'circle' | 'highlight' | 'strike-through' | 'crossed-off' | 'bracket';
    show: boolean;
    color?: string;
    strokeWidth?: number;
    padding?: number;
    iterations?: number;
    children: ReactNode;
  }

  export const RoughNotation: ComponentType<RoughNotationProps>;
  export const RoughNotationGroup: ComponentType<{ children: ReactNode }>;
} 
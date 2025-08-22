 'use client';

interface SectionSelectProps {
  lang: string;
}

export default function SectionSelect({ lang }: SectionSelectProps) {
  return (
    <select 
      className="w-full p-2 border rounded-md"
      onChange={(e) => {
        const element = document.getElementById(e.target.value);
        element?.scrollIntoView({ behavior: 'smooth' });
      }}
      aria-label={lang === 'zh' ? '选择章节' : 'Select section'}
    >
      <option value="overview">
        {lang === 'zh' ? '概览' : 'Overview'}
      </option>
      <option value="youtube-analytics">
        {lang === 'zh' ? 'YouTube 数据分析' : 'YouTube Analytics'}
      </option>
      <option value="tiktok-analytics">
        {lang === 'zh' ? 'TikTok 数据分析' : 'TikTok Analytics'}
      </option>
      <option value="competitor-analysis">
        {lang === 'zh' ? '竞品分析' : 'Competitor Analysis'}
      </option>
      <option value="trend-insights">
        {lang === 'zh' ? '趋势洞察' : 'Trend Insights'}
      </option>
    </select>
  );
}
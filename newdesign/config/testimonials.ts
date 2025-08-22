export const TestimonialsData_ZH = [
  {
    title: "多平台账号发掘",
    content:
      "支持YouTube和TikTok双平台搜索\n" +
      "自定义搜索关键词和账号数量\n" +
      "按观看量、粉丝数和发布时间智能筛选",
  },
  {
    title: "智能数据分析",
    content:
      "账号整体运营状况分析\n" +
      "内容发布规律洞察\n" +
      "互动数据统计与趋势",
  },
  {
    title: "专业报告生成",
    content:
      "一键生成详细分析报告\n" +
      "核心数据可视化展示\n" +
      "内容策略要点提炼",
  },
  {
    title: "智能关键词分析",
    content:
      "热门关键词自动发现\n" +
      "相关词智能推荐",
  },
  {
    title: "精准账号追踪",
    content:
      "指定账号深度分析\n" +
      "竞品动态实时掌握",
  },
];

export const TestimonialsData_EN = [
  {
    title: "Multi-Platform Account Discovery",
    content:
      "Search across YouTube and TikTok platforms\n" +
      "Customize search keywords and account quantity\n" +
      "Smart filtering by views, followers, and posting time",
  },
  {
    title: "Intelligent Data Analysis",
    content:
      "Comprehensive account performance analysis\n" +
      "Content publishing pattern insights\n" +
      "Engagement statistics and trends",
  },
  {
    title: "Professional Report Generation",
    content:
      "One-click detailed analysis reports\n" +
      "Core data visualization\n" +
      "Content strategy key points extraction",
  },
  {
    title: "Smart Keyword Analysis",
    content:
      "Trending keyword discovery\n" +
      "Related keyword recommendations",
  },
  {
    title: "Precise Account Tracking",
    content:
      "In-depth account analysis\n" +
      "Real-time competitor monitoring",
  },
];


interface TestimonialsCollection {
  [key: `TestimonialsData_${string}`]: {
    title: string;
    content: string;
  }[];
}

export const ALL_TestimonialsData: TestimonialsCollection = {
  TestimonialsData_EN,
  TestimonialsData_ZH,
}
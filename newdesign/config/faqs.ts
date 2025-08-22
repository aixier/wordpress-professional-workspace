export const FAQS_EN = [
  {
    title: "Which platforms does TubeScanner support?",
    content:
      "Currently, TubeScanner supports YouTube and TikTok, with plans to expand to more social platforms in the future.",
  },
  {
    title: "How is data security ensured?",
    content:
      "We strictly adhere to data security and privacy protection standards. All analysis data is used solely for report generation and will never be leaked or misused.",
  },
  {
    title: "Do I need specialized knowledge to use it?",
    content:
      "No. TubeScanner features an intuitive interface and efficient operation, making it suitable for all users.",
  },
  {
    title: "Will there be continuous updates?",
    content:
      "Yes, we are constantly improving our features, including support for more platforms, AI analysis upgrades, additional data dimensions, and customizable report templates.",
  },
  {
    title: "How can I get technical support?",
    content:
      "You can reach our technical support team at contact@fsotool.com.",
  },
];
export const FAQS_ZH = [
  {
    title: "TubeScanner支持哪些平台？",
    content:
      "目前支持YouTube和TikTok两大平台，未来将支持更多社交平台。",
  },
  {
    title: "如何保障数据安全？",
    content:
      "我们严格遵守数据安全和隐私保护规范，所有分析数据仅用于生成报告，不会泄露或他用。",
  },
  {
    title: "是否需要专业知识才能使用？",
    content:
      "不需要。TubeScanner界面简洁直观，操作便捷高效，适合所有用户使用。",
  },
  {
    title: "是否会持续更新功能？",
    content:
      "是的，我们将持续完善功能，包括支持更多平台、AI智能分析升级、更多数据维度和自定义报告模板等。",
  },
  {
    title: "如何获取技术支持？",
    content:
      "您可以通过邮箱contact@fsotool.com联系我们的技术支持团队。",
  },
];



interface FAQSCollection {
  [key: `FAQS_${string}`]: {
    title: string;
    content: string;
  }[];
}
export const ALL_FAQS: FAQSCollection = {
  FAQS_EN,
  FAQS_ZH
}
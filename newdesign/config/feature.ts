import { LucideIcon, MagnetIcon } from "lucide-react";
import { IconType } from "react-icons";
import { BsGithub } from "react-icons/bs";
import { FaToolbox } from "react-icons/fa";
import { FaEarthAsia, FaMobileScreenButton } from "react-icons/fa6";
import { MdCloudUpload } from "react-icons/md";
import { FaChartLine, FaRocket, FaSmile, FaShieldAlt } from "react-icons/fa";

export const FEATURES_EN = [
  {
    title: "Professional",
    content: `Focused social media analysis
Deep data insights with continuous updates`,
    icon: FaChartLine, // 更换为数据分析相关的图标
  },
  {
    title: "Efficient",
    content: `One-click account discovery
Quick report generation, saving research time`,
    icon: FaRocket, // 更换为表示高效的图标
  },
  {
    title: "User-Friendly",
    content: `Clean, intuitive interface
No professional training needed`,
    icon: FaSmile, // 更换为表示用户友好的图标
  },
  {
    title: "Reliable",
    content: `Accurate and timely data
Secure privacy protection with ongoing technical support`,
    icon: FaShieldAlt, // 更换为表示安全和可靠的图标
  },
];



export const FEATURES_ZH = [
  {
    title: "专业性",
    content: `专注跨境社媒分析
深度数据洞察，持续更新迭代`,
    icon: FaChartLine, // 更换为数据分析相关的图标
  },
  {
    title: "效率性",
    content: `一键获取目标账号
快速生成分析报告，节省调研时间`,
    icon: FaRocket, // 更换为表示高效的图标
  },
  {
    title: "易用性",
    content: `界面简洁直观，操作便捷高效
无需专业培训即可上手`,
    icon: FaSmile, // 更换为表示用户友好的图标
  },
  {
    title: "可靠性",
    content: `数据准确及时，性能稳定
安全隐私保护，持续技术支持`,
    icon: FaShieldAlt, // 更换为表示安全和可靠的图标
  },
];


interface FeaturesCollection {
  [key: `FEATURES_${string}`]: {
    title: string;
    content: string;
    icon: IconType | LucideIcon | string;
  }[];
}

export const ALL_FEATURES: FeaturesCollection = {
  FEATURES_EN,
  FEATURES_ZH,
}
import { ALL_FEATURES } from "@/config/feature";
import React from "react";
import { RoughNotation } from "react-rough-notation";

const Feature = ({
  id,
  locale,
  langName,
}: {
  id: string;
  locale: any;
  langName: string;
}) => {
  const FEATURES = ALL_FEATURES[`FEATURES_${langName.toUpperCase()}`];
  return (
    <section
      id={id}
      className="flex flex-col justify-center lg:max-w-7xl md:max-w-5xl w-[95%] mx-auto md:gap-14 pt-16"
    >
      <h2 className="text-center text-white">
        <div className="inline-block">
          <RoughNotation type="highlight" show={true} color="#2563EB">
            {langName === "zh" ? "为什么选择 TubeScanner ？" : "Why Choose TubeScanner?"}
          </RoughNotation>
        </div>
      </h2>
      {/* <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
        {FEATURES?.map((feature, index) => (
          <div
            key={feature.title}
            className={`
              flex flex-col items-center text-center px-8 py-6 border-b
              ${index === 0 ? "md:border-r" : ""}
              ${index === 1 ? "lg:border-r" : ""}
              ${index === 2 ? "md:border-r lg:border-r-0" : ""}
              ${index === 3 ? "lg:border-b-0 lg:border-r" : ""}
              ${index === 4 ? "md:border-b-0 md:border-r" : ""}
              ${index === 5 ? "border-b-0 border-r-0" : ""}
            `}
          >
            <div className="p-4 w-16 h-16 dark:text-white rounded-full flex items-center justify-center">
              {feature.icon && typeof feature.icon === "string" ? (
                <span className="text-2xl">{feature.icon}</span>
              ) : (
                React.createElement(feature.icon, { className: "text-2xl" })
              )}
            </div>
            <h2 className={"text-xl font-semibold mb-2"}>{feature.title}</h2>
            <p className="text-slate-700 dark:text-slate-400">
              {feature.content}
            </p>
          </div>
        ))}
      </div> */}
      <div className="grid grid-cols-1 md:grid-cols-2">
        {FEATURES?.map((feature, index) => (
          <div
            key={feature.title}
            className={`
        flex flex-col items-center text-center px-8 py-6
        border-b border-r
        ${index === 0 ? "md:border-r" : ""} // 第一列右边框
        ${index === 1 ? "md:border-r-0" : ""} // 第二列无右边框
        ${index === 2 ? "md:border-b-0" : ""} // 第三行无下边框
        ${index === 3 ? "md:border-b-0" : ""} // 第四行无下边框
        ${index % 2 === 0 ? "lg:border-r" : "lg:border-r-0"} // 大屏幕下奇数列右边框
      `}
          >
            <div className="p-4 w-16 h-16 dark:text-white rounded-full flex items-center justify-center">
              {feature.icon && typeof feature.icon === "string" ? (
                <span className="text-2xl">{feature.icon}</span>
              ) : (
                <feature.icon className="text-2xl" />
              )}
            </div>
            <h2 className={"text-xl font-semibold mb-2"}>{feature.title}</h2>
            <p className="text-slate-700 dark:text-slate-400 whitespace-pre-line">
              {feature.content}
            </p>
          </div>
        ))}
      </div>
    </section>
  );
};

export default Feature;

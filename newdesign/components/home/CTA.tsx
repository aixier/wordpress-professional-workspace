"use client";
/* eslint-disable react/no-unescaped-entities */
import CTAButton from "@/components/home/CTAButton";
import { RoughNotation } from "react-rough-notation";
import { motion, useInView } from "framer-motion";
import React from "react";

const CTA = ({ locale, CTALocale }: { locale: any; CTALocale: any }) => {
  // Use the useInView hook to detect when the h2 element is in the viewport
  const h2Ref1 = React.useRef(null);
  const h2Ref2 = React.useRef(null);
  const h2Ref3 = React.useRef(null);
  const isInView1 = useInView(h2Ref1, { once: true }); // Trigger animation only once
  const isInView2 = useInView(h2Ref2, { once: true });
  const isInView3 = useInView(h2Ref3, { once: true });

  return (
    <section className="flex flex-col justify-center max-w-[88%] items-center py-16 gap-12">
      <div className="flex flex-col text-center gap-4">
        <motion.h2
          ref={h2Ref1}
          className="text-center"
          style={{ lineHeight: 1.2 }}
          initial={{ opacity: 0, y: 20 }} // Initial state (hidden and slightly below)
          animate={isInView1 ? { opacity: 0.7, y: 0 } : {}} // Animate when in view
          transition={{ duration: 0.6, ease: "easeOut" }} // Animation duration and easing
        >

          {locale.title}
        </motion.h2>
        <motion.h2
          ref={h2Ref2}
          className="text-center"
          style={{ lineHeight: 1.2 }}
          initial={{ opacity: 0, y: 20 }} // Initial state (hidden and slightly below)
          animate={isInView2 ? { opacity: 0.85, y: 0 } : {}} // Animate when in view
          transition={{ duration: 1, ease: "easeOut", delay: 0.3 }} // Animation duration and easing
        >


          {locale.title1}


        </motion.h2>
        <motion.h2
          ref={h2Ref3}
          className="text-center"
          style={{ lineHeight: 1.2 }}
          initial={{ opacity: 0, y: 20 }} // Initial state (hidden and slightly below)
          animate={isInView3 ? { opacity: 1, y: 0 } : {}} // Animate when in view
          transition={{ duration: 1.4, ease: "easeOut", delay: 0.6 }} // Animation duration and easing
        >

          {locale.title2}
        </motion.h2>
      </div>
      <CTAButton locale={CTALocale} />
    </section>
  );
};


export default CTA;

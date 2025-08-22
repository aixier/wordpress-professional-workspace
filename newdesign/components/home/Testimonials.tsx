"use client";
/* eslint-disable react/no-unescaped-entities */
import React, { useEffect, useRef } from "react";

import { siteConfig } from "@/config/site";
import { ALL_TestimonialsData } from "@/config/testimonials";
import Image from "next/image";
import Link from "next/link";
import { RoughNotation } from "react-rough-notation";



const TestimonialItem = ({ line, index }: { line: string; index: number }) => {
  const liRef = useRef<HTMLLIElement>(null); // Specify the type of the ref

  useEffect(() => {
    const currentLiRef = liRef.current; // Store the current value of the ref

    if (currentLiRef) {
      const observer = new IntersectionObserver(
        (entries) => {
          entries.forEach((entry) => {
            if (entry.isIntersecting) {
              // Delay the animation for a staggered effect
              setTimeout(() => {
                entry.target.classList.add("opacity-100");
              }, index * 300); // Each <li> is delayed by 300ms
              observer.unobserve(entry.target); // Stop observing after triggering
            }
          });
        },
        {
          threshold: 0.1, // Trigger when 10% of the element is visible
        }
      );

      observer.observe(currentLiRef);

      // Cleanup function
      return () => {
        observer.unobserve(currentLiRef); // Use the stored ref value
      };
    }
  }, [index]);

  return (
    <li
      ref={liRef}
      className="opacity-0 transition-opacity duration-1000 ease-out mb-4"
    >
      {line}
    </li>
  );
};

const Testimonials = ({ id, locale, langName, }: { id: string; locale: any, langName: string }) => {

  const TestimonialsData = ALL_TestimonialsData[`TestimonialsData_${langName.toUpperCase()}`];
  return (
    <section
      id={id}
      className="flex flex-col justify-center items-center pt-16 gap-12 max-w-[88%]"
    >
      <div className="flex flex-col text-center max-w-xl gap-4">
        <h2 className="text-center text-white">
          <RoughNotation type="highlight" show={true} color="#2563EB">
            {langName === "zh" ? "产品功能" : "Product Features"}
          </RoughNotation>
        </h2>
      </div>

      <div className="grid grid-cols-1 md:grid-cols-3 gap-4">
        {TestimonialsData.map((testimonial, index) => (
          <div
            className={`mb-4 z-0 break-inside-avoid-column ${index >= 3 ? 'md:col-span-1.5' : 'md:col-span-1'
              }`}
            key={index}
          >
            <div className="border border-slate/10 rounded-lg p-4 flex flex-col items-start gap-3">
              <div className="flex items-start justify-between w-full">
                <div className="flex items-start gap-2">
                  <div className="flex flex-col items-start">
                    <p className="font-bold text-xl">{testimonial.title}</p>
                  </div>
                </div>
              </div>
              <ul className="dark:text-zinc-200 text-[16px] list-disc pl-5 mt-[15px]">
                {testimonial.content.split("\n").map((line, i) => (
                  <TestimonialItem key={i} line={line} index={i} />
                ))}
              </ul>
            </div>
          </div>
        ))}
      </div>
    </section>
  );
};

export default Testimonials;

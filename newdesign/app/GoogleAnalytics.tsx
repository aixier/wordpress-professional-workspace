"use client";

import Script from "next/script";
import * as gtag from "../gtag.js";
import * as React from 'react';

const GoogleAnalytics = (): JSX.Element | null => {
  if (!gtag.GA_TRACKING_ID) return null;
  
  return (
    <>
      <Script id="gtag-base" strategy="afterInteractive">
        {`
          window.dataLayer = window.dataLayer || [];
          function gtag(){dataLayer.push(arguments);}
          gtag('js', new Date());
          gtag('config', '${gtag.GA_TRACKING_ID}', {
            page_path: window.location.pathname,
          });
        `}
      </Script>
      <Script id="gtag-init" strategy="afterInteractive">
        {`
          (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
          new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
          j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
          'https://www.googletagmanager.com/gtag/js?id='+i+dl;f.parentNode.insertBefore(j,f);
          })(window,document,'script','dataLayer','${gtag.GA_TRACKING_ID}');
        `}
      </Script>
    </>
  );
};

export default GoogleAnalytics;
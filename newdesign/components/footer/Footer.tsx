
import { siteConfig } from "@/config/site";
import Link from "next/link";

const Footer = () => {
  const d = new Date();
  const currentYear = d.getFullYear();
  const { footerLinks } = siteConfig;
  const list = 'https://www.fsotool.com/privacy/TermsofServiceAgreement.html'
  const list1 = 'https://www.fsotool.com/privacy/PrivacyNotice.html'
  const list2 = 'https://www.fsotool.com/privacy/特定商取引法に基づく表示.html'
  return (
    <footer>
      <div className="mt-16 space-y-2 pt-6 pb-4 flex flex-col items-center bg-black text-sm text-gray-400 border-t">
        {/* <FooterLinks /> */}
        {/* <LangLinks /> */}
        <div>
          <a className="privacy" href={`${list}`} target="_blank" rel="noopener noreferrer">Service Agreement</a>
          <span style={{ color: 'rgba(125, 125, 125, 1)' }}> | </span>
          <a className="privacy" href={`${list1}`} target="_blank" rel="noopener noreferrer">Privacy Policy</a>
          <span style={{ color: 'rgba(125, 125, 125, 1)' }}> | </span>
          <a className="privacy" href={`${list2}`} target="_blank" rel="noopener noreferrer">特定商取引法に基づく表示</a>
        </div>
        <div className="flex space-x-2">
          <div>{`©${currentYear}`}</div>{" "}
          <Link href="https://www.fsotool.com/" target="_blank">
            fsotool.
          </Link>{" "}
          <div>All rights reserved.</div>
        </div>
      </div>
    </footer>
  );
};

export default Footer;

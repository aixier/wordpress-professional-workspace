import { siteConfig } from "@/config/site";
import Image from "next/image";
import Link from "next/link";

export default function NotFound() {
  return (
    <div className="mx-auto max-h-screen flex flex-col items-center">
      <h1>404 - Page Not Found</h1>
      <Image 
        src="/404.svg" 
        alt="404 Error Page"
        width={128} 
        height={128}
        priority
      />
      <nav className="mt-8">
        <ul>
          <li><Link href="/">Return Home</Link></li>
          <li><Link href="/sitemap.xml">View Sitemap</Link></li>
        </ul>
      </nav>
    </div>
  );
}

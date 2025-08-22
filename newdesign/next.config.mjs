/** @type {import('next').NextConfig} */
const nextConfig = {
  images: {
    formats: ['image/avif', 'image/webp'],
    deviceSizes: [640, 750, 828, 1080, 1200, 1920, 2048, 3840],
    imageSizes: [16, 32, 48, 64, 96, 128, 256, 384],
  },


  // 添加内容安全策略
  async headers() {
    return [
      {
        source: '/:path*',
        headers: [
          {
            key: 'Content-Security-Policy',
            value: [
              "default-src 'self'",
              "style-src 'self' 'unsafe-inline'",
              "script-src 'self' 'unsafe-eval' 'unsafe-inline'",
              "img-src 'self' data: blob: https:",
            ].join('; '),
          },
        ],
      },
    ];
  },
};

export default nextConfig;
